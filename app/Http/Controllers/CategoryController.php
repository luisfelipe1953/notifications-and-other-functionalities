<?php

namespace App\Http\Controllers;

use App\Classes\Facades\CacheComposite;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        Category::create($request->only(['name']));
        CacheComposite::updateCache(Category::class, 'categories', ['id', 'name']);

        return redirect()->route('product.index');
    }
}
