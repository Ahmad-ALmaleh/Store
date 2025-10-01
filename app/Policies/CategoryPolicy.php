<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;

class CategoryPolicy
{
    // Admin يملك كل الصلاحيات
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true; // أي واحد يستطيع رؤية التصنيفات
    }

    public function view(User $user, Category $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        // فقط admin (handled by before)؛ لو أردت تخصيص إضافي ضع شرط هنا
        return false;
    }

    public function update(User $user, Category $category): bool
    {
        return false;
    }

    public function delete(User $user, Category $category): bool
    {
        return false;
    }
}
