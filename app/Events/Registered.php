<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class Registered
{
    use SerializesModels;

    /**
     * The authenticated customer.
     *
     */
    public $customer;

    /**
     * Create a new event instance.
     *
     * @param  $customer
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }
}
