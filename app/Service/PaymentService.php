<?php

namespace App\Service;

use YooKassa\Client;

class PaymentService {
    protected function getClient(): Client{
        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));
        return $client;
    }

    public function createPayment(float $amount, string $description, array $options = []){
        $client = $this->getClient();
        $payment = $client->createPayment([
            'amount' => [
                'value' => $amount,
                'currency' => 'RUB',
            ],
            'capture' => true,
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('order.success')
            ],
            'description' => $description,
            "refundable" => true,
            'metadata' => [
                'transaction_id' => $options['transaction_id'],
                'user_name' => $options['user_name'],
                'order_id' => $options['order_id'],
                'order_type' => $options['order_type']
            ]
        ], uniqid('', true));

        return $payment->getConfirmation()->getConfirmationUrl();
    }

    public static function refundCreate($paymentId, $refundSum){
        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));
        $idempotenceKey = uniqid('', true);
        // dd($paymentId);
        $response = $client->createRefund(
            array(
                'payment_id' => $paymentId,
                'amount' => array(
                    'value' => $refundSum,
                    'currency' => 'RUB',
                ),
            ),
            $idempotenceKey
        );
        dd($response);
    }

}