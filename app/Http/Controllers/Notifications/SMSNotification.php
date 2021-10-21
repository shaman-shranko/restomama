<?php

namespace App\Http\Controllers\Notifications;

use App\Orders;
use App\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Nexmo\Client\Credentials\Basic;
use Nexmo\Client;

class SMSNotification extends Controller
{
    public static function order_create($order_id){
        $order = Orders::with('restaurant')->findOrFail($order_id);

        $administrators = Staff::getAdministrators($order->restaurant_id);

        foreach($administrators as $admin){
            self::sendSMS($admin['phone'], 'New Order');
        }
    }

    public static function order_accept($order_id){
        $order = Orders::with('user')->findOrFail($order_id);

        self::sendSMS($order->user->phone, 'Order accept');
    }

    public static function order_reject($order_id){
        $order = Orders::with('user')->findOrFail($order_id);

        self::sendSMS($order->user->phone, 'Order reject');
    }

    public static function order_cancel($order_id){
        $order = Orders::with('restaurant')->findOrFail($order_id);
        $administrators = Staff::getAdministrators($order->restaurant_id);

        foreach($administrators as $admin){
            self::sendSMS($admin['phone'], 'Order cancel');
        }
    }

    public static function order_success($order_id){
        $order = Orders::with(['restaurant', 'user'])->findOrFail($order_id);
        $administrators = Staff::getAdministrators($order->restaurant_id);

        foreach($administrators as $admin){
            self::sendSMS($admin['phone'], 'Event is finish');
        }

        self::sendSMS($order->user->phone, 'Event is finish');
    }

    public static function order_complete($order_id){

    }

    private static function sendSMS($phone, $message){
        $client = self::initNEXMO();
        try {
            $message = $client->message()->send([
                'to' => $phone,
                'from' => 'Acme Inc',
                'text' => 'Сообщение через NEXMO',
                'type' => 'unicode',
            ]);
            $response = $message->getResponseData();

            if($response['messages'][0]['status'] == 0) {
//                echo "The message was sent successfully\n";
            } else {
//                echo "The message failed with status: " . $response['messages'][0]['status'] . "\n";
            }
        } catch (Exception $e) {
//            echo "The message was not sent. Error: " . $e->getMessage() . "\n";
        }
    }

    private static function initNEXMO(){
        $basic  = new Basic('67526b2d', 'kIOfDexWNIfKh7YC');
        $client = new Client($basic);

        return $client;
    }
}
