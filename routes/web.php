<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
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

// Legal routes

Route::prefix('legal')->group(function () {
    Route::get('/terms-and-conditions', function () {
        return view('legal.terms');
    })->name('terms');
});

// service routes
Route::get('/category/{slug}/services', function ($slug) {
    $category = Category::where('slug', $slug)->firstOrFail();
    return view('services.category-services-page', compact('category'));
})->name('category.services');
Route::get('/services/{slug}', [ServiceController::class , 'show'])->name('services.show');

Route::Resource('/services', ServiceController::class);



Route::middleware('auth')->group(function () {
    // Display saved services
    Route::get('/user/saved-services', [SavedServiceController::class, 'index'])
        ->name('saved-services.index');

    // Toggle save status (using POST for security)
    Route::post('/services/{service}/save', [SavedServiceController::class, 'toggleSaved'])
        ->name('services.save');

    // Bulk remove saved services
    // Route::delete('/saved-services/remove', [SavedServiceController::class, 'bulkRemove'])
    //     ->name('saved-services.bulk-remove');

    // private profile
    Route::get('/user/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // inquires
    Route::put('/inquiries/{inquiry}/complete', [InquiryController::class, 'markInquiryCompleted'])->name('inquiries.complete');
    Route::Resource('/inquiries', InquiryController::class);

    Route::get('/profile', [UserController::class, 'account'])->name('user.profile');
    Route::get('/{user}/services', [UserController::class, 'services'])->name('user.services');

    // notification routes
    Route::get('/notifications', [NotificationController::class, 'notifications'])->name('user.notifications');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/user/inquires-requests' , [NotificationController::class , 'getInquiriesRequests'])->name('user.inquiresRequests');

    // for reviews
    Route::Resource('/reviews', ReviewController::class);
});



Route::prefix('user')->middleware('auth')->group(function () {

});

require __DIR__.'/auth.php';
