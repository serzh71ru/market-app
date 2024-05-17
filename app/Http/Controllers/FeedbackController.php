<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class FeedbackController extends Controller
{
    public function send(Request $request){
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $text = $request->text;
        Mail::send(['text' => 'mails.feedbackMail'], ['name' => 'Market App', 'name' => $name, 'email' => $email, 'phone' => $phone, 'text' => $text], function($message){
            $message->to('serzhik.kiselev.1998@gmail.com', 'Для кого письмо')->subject('Обратная связь');
            $message->from('market.app.laravel@yandex.ru', 'Market app');
        });
        return view('sendFeedback');
    }
}
