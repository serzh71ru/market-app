<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\UnregOrder;

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

    public function refresh($orderType, $orderId, $productId){
        if($orderType === "App\Models\Order"){
            $order = Order::where('id', $orderId)->firstOrFail();
        } else {
            $order = UnregOrder::where('id', $orderId)->firstOrFail();
        }
        $products = json_decode($order->products);
        foreach($products as $id => $quantity){
            if($id == $productId){
                unset($products->$id);
            }
        }
        $order->products = json_encode($products);
        $order->save();
        $product = Product::where('id', $productId)->firstOrFail();

        $category = Category::where('id', $product->category_id)->firstOrFail();
        $products = $category->products;
        $categoryName = $category->name;
        return view('refProduct', ['products' => $products, 'categoryName' => $categoryName, 'order' => $order]);
    }
}
