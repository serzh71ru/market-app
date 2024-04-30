<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use App\Models\Category;

class ProductController extends Controller
{
    public function showProductsByCategory()
    {
        $category = Category::find();
        $products = $category->products;

        return view('category', ['products' => $products]);
    }
}
