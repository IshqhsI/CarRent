<?php

namespace App\Http\Controllers\Front;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index()
    {
        $items = Item::with(['brand', 'type'])->latest()->take(4)->get()->reverse();
        return view('landing', compact('items'));
    }

    public function show(string $slug){
        $item = Item::with(['brand', 'type'])->whereSlug($slug)->firstorFail();
        $similarItems = Item::with(['brand', 'type'])->where('id', '!=', $item->id)->latest()->take(4)->get()->reverse();
        return view('detail', compact('item', 'similarItems'));
    }
}
