<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Classes\Facades\CacheComposite;
use App\Events\Products\SoftDeletedProductEvent;

class TableProducts extends Component
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

    public function export($extension)
    {
        $products = Product::select('id', 'name', 'description', 'category_id')
            ->with(['category' => fn ($query) => $query->select('id', 'name')])
            ->when($this->categoryFilter, fn ($query) => $query->where('category_id', $this->categoryFilter))
            ->when($this->searchProduct, fn ($query) => $query->where('name', 'like', '%' . $this->searchProduct . '%'))
            ->get();

        return Excel::download(new ProductsExport($products), 'products.' . $extension);
    }

    public function search()
    {
        $this->render();
    }

    public function redirectToLogin()
    {
        return redirect()->route('login')->with('fail', 'Debes ingresar a tu cuenta primero');
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);

        event(new SoftDeletedProductEvent($product, auth()->user()));

        $product->delete();

        CacheComposite::updateCache(
            Product::class,
            'products',
            ['id', 'name', 'description', 'category_id']
        );

        $this->emit('productDeleted');
    }

    public function render()
    {
        $this->products = Product::select('id', 'name', 'description', 'category_id')
            ->with(['category' => fn ($query) => $query->select('id', 'name')])
            ->when($this->categoryFilter, fn ($query) => $query->where('category_id', $this->categoryFilter))
            ->when($this->searchProduct, fn ($query) => $query->where('name', 'like', '%' . $this->searchProduct . '%'))
            ->get();

        return view('livewire.table-products', [
            'products' => $this->products,
            'categories' => $this->categories,
        ]);
    }
}
