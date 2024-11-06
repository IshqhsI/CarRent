<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request, $slug){
        $item = Item::with(['brand', 'type'])->whereSlug($slug)->firstorFail();
        return view('checkout', compact('item'));
    }

    public function store(Request $request, $slug){

        $request->validate([
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
        ]);

        // get the Item
        $item = Item::with(['brand', 'type'])->whereSlug($slug)->firstorFail();

        // Format start_date and end_date from dd mm yyyy to timestamp
        $start_date = Carbon::createFromFormat('d m Y', $request->start_date);
        $end_date = Carbon::createFromFormat('d m Y', $request->end_date);

        // Count days from start to end
        $days = $start_date->diffInDays($end_date);

        // Calculate the total price
        $total_price = $days * $item->price;
        $tax = 0.10;
        $total_price = $total_price + ($total_price * $tax);

        // Create the booking
        $booking = $item->bookings()->create([
            'name' => $request->name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'total_price' => $total_price,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('front.payment', $booking->id);
    }
}
