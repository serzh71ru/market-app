<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\PaymentService;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\UnregOrder;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;

class PaymentController extends Controller
{
    public function create(Request $request, PaymentService $service){
        $order = OrderController::sendOrder($request);
        if($order instanceof Order){
            $userName = $order->user->name;
            $orderType = "order";
        } elseif($order instanceof UnregOrder){
            $userName = $order->user_name;
            $orderType = "unregOrder";
        }
        $amount = (float)$order->sum;
        $description = "Оплата заказа № " . $order->id . " от " . $order->created_at;

        if($orderType === 'order'){
            $transaction = Transaction::create([
                'amount' => $amount,
                'description' => $description,
                'order_id' => $order->id,
                'user_id' => $order->user->id,
                'user_name' => $order->user->name,
                'order_type' => $orderType
            ]);
        }elseif($orderType === 'unregOrder'){
            $transaction = Transaction::create([
                'amount' => $amount,
                'description' => $description,
                'unreg_order_id' => $order->id,
                'user_name' => $userName,
                'order_type' => $orderType
            ]);
        }
        

        if($transaction){
            $link = $service->createPayment($amount, $description, [
                'transaction_id' => $transaction->id,
                'user_name' => $userName,
                'order_id' => $order->id,
                'order_type' => $orderType
            ]);

            return redirect()->away($link);
        }
    }

    protected function callback(PaymentService $service){
        $source = file_get_contents('php://input');
        
        $requestBody = json_decode($source, true);
        $notification = (isset($requestBody['event']) && $requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
            ? new NotificationSucceeded($requestBody)
            : new NotificationWaitingForCapture($requestBody);
        $payment = $notification->getObject();

        if(isset($payment->status) && $payment->status === 'waiting_for_capture'){
            $service->getClient()->capturePayment([
                'amount' => $payment->amount,
            ], $payment->id, uniqid('', true));
        }

        if(isset($payment->status) && $payment->status === 'succeeded'){
            if((bool)$payment->paid === true){
                $metadata = (object)$payment->metadata;
                if(isset($metadata->transaction_id)){
                    $transactionId = (int)$metadata->transaction_id;
                    $transaction = Transaction::find($transactionId);
                    $transaction->status = 'CONFIRMED';
                    $transaction->payment_id = $payment->id;
                    $transaction->save();
                }
            }
        }
        
    }
}
