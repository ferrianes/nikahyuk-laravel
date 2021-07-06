<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AddToCart extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\DataResource
     */
    public function __invoke(Request $request, $id_produk)
    {
        Validator::make(['produk' => $id_produk], [
            'produk' => [
                'exists:produk,id',
                Rule::unique('booking_temp', 'id_produk')->where(function ($query) use ($request) {
                    return $query->where('id_kustomer', $request->user()->id_kustomer);
                })
            ]
        ])->validate();

        $cart = Cart::create([
            'id_kustomer' => $request->user()->id_kustomer,
            'id_produk' => $request->id_produk,
            'jumlah' => 1,
            'tgl_booking' => date("Y-m-d"),
            'jam_booking' => date('H:i:s'),
        ]);

        return new DataResource($cart->load(['product.imagesProduct' => function ($query) {
            $query->where('thumbnail', 1);
        }, 'product.category']));
    }
}
