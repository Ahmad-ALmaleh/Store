<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    // تحديد الجدول (اختياري إذا الاسم مطابق بصيغة الجمع)
    protected $table = 'categories';

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'name',
    ];

    protected $primaryKey = "id";

    public  $timestamps = true;

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

}
