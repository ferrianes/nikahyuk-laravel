<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CountCart extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $cart = Cart::where('id_kustomer', auth()->id())->count();

        return response()->json(['data' => $cart]);
    }
}
