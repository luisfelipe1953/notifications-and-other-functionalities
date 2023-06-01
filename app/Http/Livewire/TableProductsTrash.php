<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Classes\Facades\CacheComposite;
use App\Events\Products\RestoredProductEvent;

class TableProductsTrash extends Component
{
    public $products, $categories, $categoryFilter, $searchProduct, $search;

    protected $listeners = [
        'reset' => 'resetFilters',
        'refreshProductList' => '$refresh'
    ];

    public function resetFilters()
    {
        $this->reset(['categoryFilter', 'searchProduct']);
    }

    public function search()
    {
        $this->render();
    }

    public function redirectToLogin()
    {
        return redirect()->route('login')->with('fail', 'Debes ingresar a tu cuenta primero');
    }

    public function restoreProduct($productId)
    {
        $product = Product::onlyTrashed()->findOrFail($productId);

        event(new RestoredProductEvent($product, Auth::user()));

        $product->restore();

        CacheComposite::updateCache(
            Product::class,
            'products',
            ['id', 'name', 'description', 'category_id']
        );

        $this->emit('productRestored');
    }

    public function forceDeleteProduct($productId)
    {
        $product = Product::onlyTrashed()->findOrFail($productId);

        $product->forceDelete();

        CacheComposite::updateCache(
            Product::class,
            'products',
            ['id', 'name', 'description', 'category_id']
        );

        $this->emit('productForceDeleted');
    }

    public function render()
    {
        $this->products = Product::withTrashed()
            ->select('id', 'name', 'description', 'category_id')
            ->whereNotNull('deleted_at')
            ->with(['category' => fn ($query) => $query->select('id', 'name')])
            ->when($this->categoryFilter, fn ($query) => $query->where('category_id', $this->categoryFilter))
            ->when($this->searchProduct, fn ($query) => $query->where('name', 'like', '%' . $this->searchProduct . '%'))
            ->get();

        return view('livewire.table-products-trash', [
            'products' => $this->products,
            'categories' => $this->categories,
        ]);
    }
}
