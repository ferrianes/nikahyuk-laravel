<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class RemoveCartItem extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        Cart::where('id', $id)->delete();

        return response()->json([
            'message' => 'Item Deleted'
        ]);
    }
}
