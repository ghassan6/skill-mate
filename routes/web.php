<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Http\Controllers\SavedServiceController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about',[HomeController::class , 'about'])->name('about');

Route::Resource('/contact', ContactController::class);

Route::Resource('/categories', CategoryController::class);

// public user profile route
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/services', [UserController::class, 'services'])->name('users.services');
Route::get('/users/{user}/reviews', [UserController::class, 'reviews'])->name('users.reviews');



// service routes
Route::get('/category/{slug}/services', function ($slug) {
    $category = Category::where('slug', $slug)->firstOrFail();
    return view('services.category-services-page', compact('category'));
})->name('category.services');

Route::Resource('/services', ServiceController::class);

// saved services

Route::middleware(['auth'])->group(function () {
    // Display saved services
    Route::get('/saved-services', [SavedServiceController::class, 'index'])
        ->name('saved-services.index');

    // Toggle save status (using POST for security)
    Route::post('/services/{service}/save', [SavedServiceController::class, 'toggleSaved'])
        ->name('services.save');

    // Bulk remove saved services
    Route::delete('/saved-services/remove', [SavedServiceController::class, 'bulkRemove'])
        ->name('saved-services.bulk-remove');
});
// Legal routes

Route::prefix('legal')->group(function () {
    Route::get('/terms-and-conditions', function () {
        return view('legal.terms');
    })->name('terms');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'account'])->name('user.profile');
    Route::get('/notifications', [UserController::class, 'notifications'])->name('user.notifications');
    Route::get('/services', [UserController::class, 'services'])->name('user.services');
});

require __DIR__.'/auth.php';
