<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    // public function create_category() {
    //     $category = new Category();
    //     $category->name = $request->input(key: 'name');
    //     $category->slug = $request->input(key: 'slug');
    //     $category->save();
    // }

    public function category($slug){
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products;
        
        dd($basket);
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
