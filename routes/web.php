<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// routes/web.php
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;


Route::middleware(['auth','log.activity'])->group(function () {
    // Route::get('/posts', [PostController::class, 'index'])->name('posts');
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::resource('roles', RoleController::class)->middleware('role:Admin');
});

# Social login
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('oauth.callback');

# Admin area
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('users', AdminUserController::class)->only(['index','edit','update','destroy','create','store']);
    Route::get('posts', [PostController::class, 'adminIndex'])->name('posts.index'); // list all posts incl. trashed
    Route::post('posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('posts/{post}/force', [PostController::class, 'forceDelete'])->name('posts.force');
});

// Route::get('/discount', [::class, 'showDiscount']);
// use App\Http\Controllers\DiscountController;

Route::get('/discount', [ProductController::class, 'index'])->name('discount.form');
Route::post('/discount/calculate', [ProductController::class, 'calculate'])->name('discount.calculate');


