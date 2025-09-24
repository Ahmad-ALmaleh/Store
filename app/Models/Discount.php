<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'product_id',
        'discount_date',
        'discount_percentage',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
