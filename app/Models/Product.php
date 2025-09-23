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

}
