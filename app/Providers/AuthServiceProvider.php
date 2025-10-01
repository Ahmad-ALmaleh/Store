<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Models\Product;
use App\Models\Comment;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Product::class  => ProductPolicy::class,
        Comment::class  => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // هنا يمكنك تعريف Gates إضافية لو احتجت
        // Gate::define('manage-categories', fn($user) => $user->isAdmin());
    }
}
