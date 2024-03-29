<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \App\Http\Resources\DataResource
     */
    public function index(Request $request)
    {
        // Jika ada limit
        $limit = $request->input('limit', 6);

        if ($request->has('category_id') && !$request->has('search')) {
            $products = Product::with(['imagesProduct' => function ($query) {
                $query->where('thumbnail', 1);
            }, 'category'])
                ->where('id_kategori', $request->category_id)
                ->simplePaginate($limit);
        } else if ($request->has('search') && !$request->has('category_id')) {
            $products = Product::where('nama', 'like', "%$request->search%")->simplePaginate($limit);
        } else {
            $products = Product::with(['imagesProduct' => function ($query) {
                $query->where('thumbnail', 1);
            }, 'category'])->simplePaginate($limit);
        }

        return DataResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new DataResource($product->load(['imagesProduct', 'category']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
