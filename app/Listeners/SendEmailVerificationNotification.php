<?php

namespace App\Listeners;

use App\Events\Registered;
use Illuminate\Support\Facades\DB;

class SendEmailVerificationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ($event->customer->is_active === 0) {

            $token = base64_encode(random_bytes(32));

            DB::table('kustomer_token')->insertGetId([
                'email' => $event->customer->email,
                'token' => $token,
                'tgl_dibuat' => time()
            ]);

            $event->customer->sendEmailVerificationNotificationCustomer($token);
        }
    }
}
