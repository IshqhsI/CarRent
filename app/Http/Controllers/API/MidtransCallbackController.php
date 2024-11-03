<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function callback(){

        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $notification = New Notification();

        $status = $notification->transaction_status;
        $order_id = $notification->order_id;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;

        $booking = Booking::findOrFail($order_id);

        if($status == 'capture'){
            if($type == 'credit_car'){
                if($fraud == 'challenge'){
                    $booking->payment_status == 'pending';
                } else {
                    $booking->payment_status == 'success';
                }
            }
        } else if ($status == 'settlement') {
            $booking->payment_status = 'success';
        } else if ($status == 'pending') {
            $booking->payment_status = 'pending';
        } else if ($status == 'deny') {
            $booking->payment_status = 'cancelled';
        } else if ($status == 'expire') {
            $booking->payment_status = 'cancelled';
        } else if ($status == 'cancel') {
            $booking->payment_status = 'cancelled';
        }

        $booking->save();

        return response()->json([
            'meta' => [
                'code' => 200,
                'message' => 'Midtrans Notification Success'
            ]
        ]);
    }
}
