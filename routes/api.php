<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::prefix("categories")->group(function () {
        Route::get('/', [CategoryController::class, 'index']);     // عرض كل التصنيفات
        Route::post('/', [CategoryController::class, 'store']);    // إضافة تصنيف جديد
        Route::get('/{id}', [CategoryController::class, 'show']);  // عرض تصنيف محدد
        Route::put('/{id}', [CategoryController::class, 'update']); // تحديث تصنيف
        Route::delete('/{id}', [CategoryController::class, 'destroy']); // حذف تصنيف
    });

    Route::prefix("products")->group(function(){
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);

        Route::prefix("/{product}/comments")->group(function (){
            Route::get('/', [CommentController::class, 'index']);
            Route::post('/', [CommentController::class, 'store']);
            Route::put('/{comment}', [CommentController::class, 'update']);
            Route::delete('/{comment}', [CommentController::class, 'destroy']);
          });

          // Likes nested
        Route::prefix("/{product}/likes")->middleware('auth:sanctum')->group(function () {
            Route::get('/', [LikeController::class, 'index']);      // استعراض اللايكات
            Route::post('/', [LikeController::class, 'store']);     // إضافة لايك
            Route::delete('/', [LikeController::class, 'destroy']); // إزالة لايك
        });
    });



});

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */



