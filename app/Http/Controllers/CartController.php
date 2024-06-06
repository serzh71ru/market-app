<?php


namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\UnregOrder;

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

    public function repeatOrder(Request $request){
        if($request->order_type === "App\Models\UnregOrder"){
            $order = UnregOrder::find($request->order_id);
        } elseif($request->order_type === "App\Models\Order"){
            $order = Order::find($request->order_id);
        }
        $order->products = (array) json_decode($order->products);
        $productModels = Product::find(array_keys($order->products));
        $products = [];
        for($i = 0; $i < count($productModels); $i++){
            $values = array_values($order->products);
            $productModels[$i]->quantity = $values[$i];
            $products[] = $productModels[$i];
        }
        $order->products = $products;
        $basket = session()->get('basket', []);
        foreach($order->products as $index => $product){
            $quantity = $product->quantity;
            if($product->unit->name === 'кг'){
                $step = 0.5; 
                $roundedQuantity = round($quantity / $step);
            } elseif($product->unit->name === 'г'){
                $step = 100;
                $quantity = $quantity * 1000;
                $roundedQuantity = round($quantity / $step) * $step / 100;
            } elseif($product->unit->name === 'шт'){
                $step = 1; 
                $roundedQuantity = round($quantity / $step) * $step;
            }
            $product->quantity = $roundedQuantity;
            $basket[$index] = [$product->id => $product->quantity];
        }
        
        session()->put('basket', $basket);

        return view('repeatOrder', ['order' => $order]);
    }
}
