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

        return view('category', ['products' => $products]);
    }
    // public function category($slug) {
    //     $category = Category::where('slug', $slug)->first();
    //     // $category_name = Category::where('slug', $slug)->first()->name;
    //     return view('category', compact('category'));
    // }
}
