<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShowCart extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\DataResource
     */
    public function __invoke(Request $request)
    {
        // Jika ada limit
        $limit = $request->input('limit', 6);

        $total_price = DB::table('booking_temp')
            ->join('produk', 'booking_temp.id_produk', '=', 'produk.id')
            ->where('booking_temp.id_kustomer', auth()->id())
            ->sum('produk.harga');

        return DataResource::collection(auth()->user()->carts()->with(['product.imagesProduct' => function ($query) {
            $query->where('thumbnail', 1);
        }, 'product.category'])->simplePaginate($limit))->additional(['meta' => [
            'total_price' => $total_price
        ]]);
    }
}
