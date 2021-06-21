<?php

namespace App\Http\Controllers\Api;

use App\Events\Registered;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterCustomer extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\DataResource
     */
    public function __invoke(Request $request)
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
}
