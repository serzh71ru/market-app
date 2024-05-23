<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function category($slug){
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products;
        return view('category', ['products' => $products, 'basket' => $basket]);
    }
    public function showProducts($slug) {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products;
        $categoryName = $category->name;
        $basket = session()->get('basket');
        return view('category', ['products' => $products, 'categoryName' => $categoryName, 'basket' => $basket]);
    }
}
