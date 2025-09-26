<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // تحديد الجدول (اختياري إذا الاسم مطابق بصيغة الجمع)
    protected $table = 'products';

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'name',
        'price',
        'description',
        'exp_date',
        'img_url',
        'quantity',
        'category_id',
        'user_id',
    ];

    protected $primaryKey = "id";

    public  $timestamps = true;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // العلاقة مع الخصومات
    public function discounts()
    {
        return $this->hasMany(Discount::class, 'product_id');
    }

    // Accessor لحساب السعر النهائي
    public function getPriceAttribute($value)
    {
        $today = now()->toDateString();

        $discount = $this->discounts()
            ->where('discount_date', '<=', $today)
            ->orderByDesc('discount_date')
            ->first();

        if ($discount) {
            $value = $value - ($value * ($discount->discount_percentage / 100));
        }

        return $value;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
