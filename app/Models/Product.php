<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'produk';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the category for product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }

    /**
     * Get the imageproduct for the product.
     */
    public function ImagesProduct()
    {
        return $this->hasMany(ImageProduct::class, 'produk_id');
    }

    /**
     * Get the carts for the product.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
