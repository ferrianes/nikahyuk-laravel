<?php

namespace App\Http\Controllers\Api;

use App\Events\Registered;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Handle login request
     *
     * @param Request $request
     * @return \App\Helpers\ResponseFormatter
     */
    public function login(Request $request)
    {
        // Validasi Input
        $rules = [
            'email' => 'required|email|exists:kustomer,email',
            'password' => 'required'
        ];

        $request->validate($rules);

        // Mengecek Credentials (login)
        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 500);
        }

        // Jika hash tidak sesuai maka beri error
        $customer = Customer::where('email', $request->email)->first();

        // Jika berhasil maka loginkan
        $token_result = $customer->createToken('auth_token')->plainTextToken;
        return ResponseFormatter::success([
            'access_token' => $token_result,
            'token_type' => 'Bearer',
            'customer' => $customer
        ], 'Authenticated');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|min:3|max:16',
            'alamat' => 'required|max:128',
            'email' => 'required|email|unique:kustomer,email',
            'telepon' => 'required|numeric|digits_between:10,14',
            'password' => 'required|string|confirmed|min:4'
        ]);

        // Store
        $customer = Customer::create([
            'nm_lengkap' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => Hash::make($request->password),
            'tgl_dibuat' => date("Y-m-d"),
            'is_active' => 0
        ]);

        // Send email verify
        event(new Registered($customer));

        // Return data
        return new DataResource($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
