<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MessageController;
use App\Models\Category;
use App\Http\Controllers\SavedServiceController;
use App\Models\Conversation;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about',[HomeController::class , 'about'])->name('about');

Route::Resource('/contact', ContactController::class);

Route::Resource('/categories', CategoryController::class);

// public user profile route
Route::get('/users/{user}/profile', [UserController::class, 'show'])->name('users.show');
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

Route::Resource('/services', ServiceController::class);
Route::post('/services/upload', [ServiceController::class, 'upload'])->name('services.upload');
Route::get('/services/{slug}', [ServiceController::class , 'show'])->name('services.show');



Route::middleware('auth')->group(function () {
    // Display saved services
    Route::get('/user/saved-services', [SavedServiceController::class, 'index'])
        ->name('saved-services.index');

    // Toggle save status (using POST for security)
    Route::post('/services/{service}/save', [SavedServiceController::class, 'toggleSaved'])
        ->name('services.save');


    // private profile
    Route::get('/user/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [UserController::class, 'account'])->name('user.profile');
    Route::get('/{user}/services', [UserController::class, 'services'])->name('user.services');



    // inquires
    Route::put('/inquiries/resolve', [InquiryController::class, 'resolveConflict'])->name('inquiries.resolve');

    Route::get('/inquiries/requests', [InquiryController::class, 'requests'])
    ->name('inquiries.requests');

    Route::put('/inquiries/{inquiry}/complete', [InquiryController::class, 'markInquiryCompleted'])->name('inquiries.complete');
    Route::Resource('/inquiries', InquiryController::class);



    // notification routes
    Route::get('/notifications/{notification}/view-service', [NotificationController::class, 'viewService'])->name('notifications.viewService');
    Route::get('/notifications', [NotificationController::class, 'notifications'])->name('user.notifications');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    // Route::get('/user/inquires-requests' , [NotificationController::class , 'getInquiriesRequests'])->name('user.inquiresRequests');

    // for reviews
    Route::Resource('/reviews', ReviewController::class);

    // converation routes
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');

    Route::post('/conversations', [ConversationController::class, 'store'])
    ->name('conversations.store');

    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])
    ->name('conversations.messages.store');

    // services actions
    Route::post('/{service}/activate', [ServiceController::class, 'activate'])->name('services.toggle-status');
    Route::post('/{service}/promote', [ServiceController::class, 'promote'])->name('services.promote');

});



Route::prefix('user')->middleware('auth')->group(function () {

});

require __DIR__.'/auth.php';
