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
     * @return \App\Helpers\ResponseFormatter
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
}
