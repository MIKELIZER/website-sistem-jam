<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('primaryImage', 'category');

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products   = $query->latest()->paginate(12);
        $categories = \App\Models\Category::where('is_active', true)->get();
        $featuredProducts = Product::where('is_active', true)->with('primaryImage', 'category')->latest()->take(4)->get();

        return view('catalog.index', compact('products', 'categories', 'featuredProducts'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->with('primaryImage', 'images', 'category')->firstOrFail();
        return view('catalog.show', compact('product'));
    }
}
