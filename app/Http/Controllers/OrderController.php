<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UnregOrder;
use App\Models\User;
use App\Models\Product;
use App\Service\PaymentService;
use Mail;

class OrderController extends Controller
{
    public static function sendOrder(Request $request) {
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
    } 

    public function ordersStory(){
        $orders = Order::where('user_id', auth()->user()->id)->orderByDesc('created_at')->get();
        foreach ($orders as $order){
            $order->products = (array) json_decode($order->products);
            $productModels = Product::find(array_keys($order->products));
            $products = [];
            for($i = 0; $i < count($productModels); $i++){
                $values = array_values($order->products);
                $productModels[$i]->quantity = $values[$i];
                $products[] = $productModels[$i];
            }
            $order->products = $products;
            
        }
        session(['orders' => $orders]);
        return view('orders', ['orders' => $orders]);
    }

    protected function confirmationOrders(){
        if(auth()->user() !== null && auth()->user()->role->id === 1){
            $unregOrders = UnregOrder::all();
            $regOrders = Order::all();
            $orders = $regOrders->mergeRecursive($unregOrders)->sortByDesc('created_at');
            foreach ($orders as $order){
                $order->products = (array) json_decode($order->products);
                $productModels = Product::find(array_keys($order->products));
                $products = [];
                for($i = 0; $i < count($productModels); $i++){
                    $values = array_values($order->products);
                    $productModels[$i]->quantity = $values[$i];
                    $products[] = $productModels[$i];
                }
                $order->products = $products;
            }
            return view('confirmation.orders', ['orders' => $orders]);
        } else {
            return back();
        }
    }

    public function orderConfirm(Request $request){
        if($request->action === 'confirm'){
            if($request->order_type === "App\Models\UnregOrder"){
                $order = UnregOrder::find($request->order_id);
            } elseif($request->order_type === "App\Models\Order"){
                $order = Order::find($request->order_id);
            }
            $knownKeys = ['_token', 'order_id', 'order_type'];
            $weightProducts = $request->except($knownKeys);
            $order->products = (array) json_decode($order->products);
            $productModels = Product::find(array_keys($order->products));
            $products = [];
            for($i = 0; $i < count($productModels); $i++){
                $keys = array_keys($weightProducts);
                $values = array_values($weightProducts);
                $productModels[$i]->total_weight = $values[$i];
                $products[] = $productModels[$i];
            }
            $order->products = $products;
            $order->sum = 0;
            foreach($order->products as $product){
                
                switch ($product->unit_id) {
                    case '1':
                        $productSum = $product->total_weight * ($product->price * 10);
                        $order->sum += $productSum;
                        break;
                    case '2':
                        $productSum = $product->total_weight * $product->price;
                        $order->sum += $productSum;
                        break;
                    case '3':
                        $productSum = $product->price;
                        $order->sum += $productSum;
                        break;
                    
                    default:
                        echo('ОШИБКА: НЕИЗВЕСТНЫЕ ДАННЫЕ');
                        break;
                }
                
            }
            $initialAmount = $order->transaction->amount;
            $finalAmount = $order->sum;
            $refundSum = $initialAmount - $finalAmount;
            $paymentId = $order->transaction->payment_id;
            PaymentService::refundCreate($paymentId, $refundSum);
            $keys = [];
            $values = [];
            foreach($order->products as $product){
                array_push($keys, $product->id);
                array_push($values, $product->total_weight);
            }
            $order->products = json_encode(array_combine($keys, $values));
            $order->status = 'Подтвержден';
            $order->save();
            return back();
        } elseif($request->action === 'complete'){
            if($request->order_type === "App\Models\UnregOrder"){
                $order = UnregOrder::find($request->order_id);
            } elseif($request->order_type === "App\Models\Order"){
                $order = Order::find($request->order_id);
            }
            $order->status = 'Выполнен';
            $order->save();
            return back();
        }
    }

    public function refresh(Request $request){
        $product = Product::where('id', $request->refresh_product)->firstOrFail();
        if($request->order_type === "App\Models\Order"){
            $order = Order::where('id', $request->order_id)->firstOrFail();
        } else {
            $order = UnregOrder::where('id', $request->order_id)->firstOrFail();
        }
        $orderProducts = (array)json_decode($order->products);
        $orderProducts[$product->id] = 1;
        $order->products = json_encode($orderProducts);
        $order->save();

        return redirect(route('orders.confirmation'));
    }

    public function deleteProduct($orderType, $orderId, $productId){
        if($orderType === "App\Models\Order"){
            $order = Order::where('id', $orderId)->firstOrFail();
        } else {
            $order = UnregOrder::where('id', $orderId)->firstOrFail();
        }
        $product = Product::where('id', $productId)->firstOrFail();
        $products = json_decode($order->products);
        foreach($products as $id => $quantity){
            if($id == $productId){
                if($product->unit->name === 'кг'){
                    $order->sum = $order->sum - ($product->price * $quantity * 0.5);
                } else {
                    $order->sum = $order->sum - ($product->price * $quantity);
                }
                unset($products->$id);
            }
        }
        $order->products = json_encode($products);
        $order->save();
        return back();
    }
}
