<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UnregOrder;
use App\Models\User;
use App\Models\Product;
use Mail;

class OrderController extends Controller
{
    public static function sendOrder(Request $request) {
        // $order = $request->all();
        $knownKeys = ['_token', 'variant', 'unitValue', 'unitName', 'email', 'phone', 'address', 'address_val', 'info_adress', 'info', 'user_name', 'user_id', 'address_name', 'sum'];
        $productData = json_encode($request->except($knownKeys));
        $userName = $request->user_name;
        $userId = $request->user_id;
        $userEmail = $request->email;
        $userPhone = $request->phone;
        $variant = $request->variant;
        $address = $request->address_val;
        $addressName = $request->address_name;
        $addressId = $request->address;
        $addressInfo = $request->info_adress;
        $comment = $request->info;
        $sum = $request->sum;
        $adres = (($address == 'random-address' || $address == NULL) ? $addressName : $address);
        $productsModel = Product::find(array_keys($request->except($knownKeys)));
        $productNames = [];
        foreach ($productsModel as $product){
            array_push($productNames, $product->name);
        };
        $products = array_combine($productNames, array_values($request->except($knownKeys)));
        $productUnit = [];
        foreach ($productsModel as $product){
            array_push($productUnit, $product->unit->value);
        };
        $productUnits = array_combine($productNames, $productUnit);
        if(isset($request->user_id)){
            $order = Order::create([
                'user_id' => $userId,
                'user_address' => $adres, 
                'user_address_info' => $addressInfo,
                'comment' => $comment,
                'products' => $productData,
                'sum' => $sum,
            ]);
            $request->session()->forget('basket');
            return $order;
        } else {
            $unregOrder = UnregOrder::create([
                'user_name' => $userName,
                'user_email' => $userEmail,
                'user_phone' => $userPhone,
                'user_address' => $address,
                'user_address_info' => $addressInfo,
                'comment' => $comment,
                'products' => $productData,
                'sum' => $sum,
            ]);
            $request->session()->forget('basket');
            return $unregOrder;
        }
        Mail::send(['text' => 'mails.orderMail'], ['name' => 'Market App', 'userName' => $userName, 'userEmail' => $userEmail, 'userPhone' => $userPhone, 'variant' => $variant, 'address' => $adres, 'addressInfo' => $addressInfo, 'comment' => $comment, 'products' => $products, 'productUnits' => $productUnits, 'sum' =>$sum], function($message){
            $message->to('serzhik.kiselev.1998@gmail.com', 'Менеджеру')->subject('Новый заказ');
            $message->from('market.app.laravel@yandex.ru', 'Market app');
        });
        // return view('order');
        
        
    } 

    public function ordersStory(Request $request){
        $orders = Order::where('user_id', auth()->user()->id)->orderByDesc('created_at')->get();
        foreach ($orders as $order){
            $order->products = (array) json_decode($order->products);
            $productModels = Product::find(array_keys($order->products));
            $products = [];
            for($i = 0; $i < count($productModels); $i++){
                $keys = array_keys($order->products);
                $values = array_values($order->products);
                $productModels[$i]->quantity = $values[$i];
                $products[] = $productModels[$i];
            }
            $order->products = $products;
        }
        session(['orders' => $orders]);
        return view('orders', ['orders' => $orders]);
    }
}
