<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifyEmail extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Customer $customer
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Customer $customer, $token)
    {
        $customer_token = DB::table('kustomer_token')
            ->where('email', $customer->email)
            ->where('token', $token);

        if ($customer_token->exists()) {
            // Cek jika token lebih dari 1 hari
            if (time() - $customer_token->value('tgl_dibuat') > (60 * 60 * 24)) {
                return ResponseFormatter::error([
                    'message' => 'Account Activation Failed! Token expired.'
                ], 'Verification Failed', 400);
            }

            $customer->update(['is_active' => 1]);

            $customer_token->delete();

            return ResponseFormatter::success([
                'message' => 'Account Activation Success! Please login.'
            ]);
        } else {
            return ResponseFormatter::error([
                'message' => 'Token Not Found'
            ], 'Verification Failed', 400);
        }
    }
}
