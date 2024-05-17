<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function setSession(Request $request){ 
        $basket = $request->basket;
        $request->session()->put('basket', $basket);
    }

    public function getsession(Request $request)
    {
        $basket = $request->session()->get('basket');
        return($basket);
    }
    
    public function add(Request $request)
    {
        $basket = $request->session()->get('basket', []);
        $id = $request->input('id');
        if (!isset($basket[$id])) {
            $basket[$id] = 0;
        }
        $basket[$id]++;
        $request->session()->put('basket', $basket);
        return response()->json($basket);
    }

    public function update(Request $request)
    {
        $basket = $request->session()->get('basket', []);
        $id = $request->input('id');
        $quantity = $request->input('quantity');
        $basket[$id] = $quantity;
        $request->session()->put('basket', $basket);
        return response()->json($basket);
    }

    public function remove(Request $request)
    {
        $basket = $request->session()->get('basket', []);
        $id = $request->input('id');
        unset($basket[$id]);
        $request->session()->put('basket', $basket);
        return response()->json($basket);
    }

    public function getBasket(Request $request)
    {
        $basket = session()->get('basket');
        $keys = [];
        $values = [];
        if($basket != NULL){
            foreach($basket as $product){
                foreach($product as $key => $value){
                    array_push($keys, $key);
                    array_push($values, $value);
                }
            }
            $user = $request->user();
            $products = Product::find($keys);
            if($user != NULL){
                $addresses = $user->addresses;
                return view('cart', ['basket' => $basket, 'products' => $products, 'user' => $user, 'addresses' => $addresses]);
            } else {
                return view('cart', ['basket' => $basket, 'products' => $products, 'user' => $user]);
            }
            
        } else {
            return view('cart');
        }        
    }
}
