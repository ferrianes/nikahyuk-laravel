<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_kustomer',
        'id_produk',
        'jumlah',
        'tgl_booking',
        'jam_booking',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'booking_temp';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the product for the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    /**
     * Get the customer for the cart.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
