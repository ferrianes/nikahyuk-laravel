<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateProfile extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        Validator::make($request->all(), [
            'nama' => 'string|min:3|max:16',
            'alamat' => 'string|max:128',
            'telepon' => 'numeric|digits_between:10,14',
            'password' => 'required'
        ])->after(function ($validator) use ($request) {
            if (!Hash::check($request->password, auth()->user()->password)) {
                $validator->errors()->add('password', __('validation.current_password'));
            }
        })->validate();

        $customer = auth()->user();

        $customer->update([
            'nm_lengkap' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon
        ]);

        return new DataResource($customer);
    }
}
