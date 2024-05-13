<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UnregOrder;
use App\Models\User;

class OrderController extends Controller
{
    public function sendOrder(Request $request) {
        // dd($request->all());
        $knownKeys = ['_token', 'email', 'phone', 'address', 'address_val', 'info_adress', 'info', 'user_name', 'user_id', 'address_name'];
        $productData = json_encode($request->except($knownKeys));
        $userName = $request->user_name;
        $userId = $request->user_id;
        $userEmail = $request->email;
        $userPhone = $request->phone;
        $address = $request->address_val;
        $addressName = $request->address_name;
        $addressId = $request->address;
        $addressInfo = $request->info_adress;
        $comment = $request->info;
        // dd($address, $addressId, $addressName);
        if(isset($request->user_id)){
            $order = Order::create([
                'user_id' => $userId,
                'user_address' => (($address == 'random-address' || $address == NULL) ? $addressName : $address), 
                'user_address_info' => $addressInfo,
                'comment' => $comment,
                'products' => $productData
            ]);
        } else {
            $unregOrder = UnregOrder::create([
                'user_name' => $userName,
                'user_email' => $userEmail,
                'user_phone' => $userPhone,
                'user_address' => $address,
                'user_address_info' => $addressInfo,
                'comment' => $comment,
                'products' => $productData
            ]);
        }
        $request->session()->forget('basket');
        return view('order');
        
    } 
}
