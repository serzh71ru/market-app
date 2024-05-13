<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index($slug) {
        $product = Product::where('slug', $slug)->firstOrFail();
        $basket = session()->get('basket');
        // dd($basket);
        return view('product', ['product' => $product, 'basket' => $basket]);
    }

    public function showProductsByCategory()
    {
        $category = Category::find();
        $products = $category->products;

        return view('category', ['products' => $products]);
    }

    public function search(Request $request) {
        $q = $request->q;
        $products = Product::where('name', 'LIKE', "%{$q}%")->orWhere('description', 'LIKE', "%{$q}%")->orderBy('name')->get();
        $basket = session()->get('basket');
        
        return view('search', ['products' => $products, 'basket' => $basket]);
    }
}
