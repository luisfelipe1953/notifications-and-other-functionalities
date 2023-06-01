<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Classes\Facades\CacheComposite;
use App\Events\Products\CreatedProductEvent;

class ProductController extends Controller
{
    public function index()
    {
        $products = CacheComposite::getCacheOrCreate(
            'products',
            Product::class,
            ['id', 'name', 'description', 'category_id']
        );

        $categories = CacheComposite::getCacheOrCreate(
            'categories',
            Category::class,
            ['id', 'name']
        );

        return view('livewire.product-index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        event(new CreatedProductEvent($product, auth()->user()));

        return redirect()->route('product.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        CacheComposite::updateCache(
            Product::class,
            'products',
            ['id', 'name', 'description', 'category_id']
        );

        return redirect()->route('product.index');
    }

    public function trash()
    {
        $products = CacheComposite::getCacheOrCreate(
            'productsTrash',
            Product::class,
            ['id', 'name', 'description', 'category_id']
        );

        $categories = CacheComposite::getCacheOrCreate(
            'categories',
            Category::class,
            ['id', 'name']
        );

        return view('livewire.product-trash', compact('products', 'categories'));
    }
}
