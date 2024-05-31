<?php

namespace App\Service;

use YooKassa\Client;

class PaymentService {
    public function getClient(): Client{
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
            'metadata' => [
                'transaction_id' => $options['transaction_id'],
                'user_name' => $options['user_name'],
                'order_id' => $options['order_id'],
                'order_type' => $options['order_type']
            ]
        ], uniqid('', true));

        return $payment->getConfirmation()->getConfirmationUrl();
    }

}