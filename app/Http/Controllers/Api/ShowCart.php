<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use Illuminate\Http\Request;
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
        return DataResource::collection(auth()->user()->carts()->with(['product.imagesProduct' => function ($query) {
            $query->where('thumbnail', 1);
        }, 'product.category'])->simplePaginate());
    }
}
