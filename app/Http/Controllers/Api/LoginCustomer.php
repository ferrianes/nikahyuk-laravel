<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class LoginCustomer extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
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
            return response()->json([
                'message' => __('validation.current_password')
            ], 400);
        }

        // Get Customer
        $customer = auth()->user();

        // Cek Verifikasi Email
        if (!$customer->is_active) {
            return response()->json([
                'message' => __('auth.not_verify')
            ], 400);
        }

        // Jika berhasil maka loginkan
        $token_result = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => [
                'access_token' => $token_result,
                'token_type' => 'Bearer',
                'customer' => $customer
            ]
        ], 200);
    }
}
