<?php

namespace App\Http\Controllers\Front;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function index($bookingId){
        $booking = Booking::with(['item', 'user'])->whereId($bookingId)->firstorFail();
        return view('payment', compact('booking'));
    }

    public function update(Request $request, $bookingId){
        // Get data booking
        $booking = Booking::with(['item', 'user'])->whereId($bookingId)->firstorFail();

        // Set payment method
        $booking->payment_method = $request->payment_method;

        //
        if($request->payment_method == 'midtrans'){

            // Set up Midtrans
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = config('services.midtrans.isSanitized');
            Config::$is3ds = config('services.midtrans.is3ds');

            // Set transaction details
            $transaction_details = array(
                'order_id' => $booking->id,
                'gross_amount' => $booking->total_price,
            );
            // Set customer details
            $customer_details = array(
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            );
            //  Set enable payment
            $enable_payments = array('credit_card', 'gopay');


            // Set midtrans parameter
            $midtrans_params = array(
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'enable_payments' => $enable_payments,
            );

            // Create transaction
            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;

            $booking->payment_url = $paymentUrl;
            $booking->save();

            // Redirect to Midtrans
            return redirect($paymentUrl);
        }
    }

    public function success(){
        return view('payment-success');
    }
}
