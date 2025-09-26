<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'product_id',
    ];

    // علاقة: التعليق ينتمي لمستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة: التعليق ينتمي لمنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
