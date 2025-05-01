<?php

use App\Http\Controllers\admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ReportController as AdminReportController;
use App\Http\Controllers\admin\ServiceController as AdminServiceController;
use App\Http\Controllers\admin\UserController as AdminUserController;
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
use App\Http\Controllers\ReportController;
use App\Models\Category;
use App\Http\Controllers\SavedServiceController;
use App\Http\Controllers\ServiceImageController;
use App\Mail\userBanned;
use Illuminate\Support\Facades\Mail;


Route::get('/', [HomeController::class, 'index'])
->middleware('banned')
->name('home');

Route::get('/about',[HomeController::class , 'about'])->name('about');

Route::Resource('/contact', ContactController::class);

Route::Resource('/categories', CategoryController::class);

// public user profile route
Route::get('/users/{user}/profile', [UserController::class, 'show'])->name('users.show');

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
Route::get('/services/{slug}', [ServiceController::class , 'show'])->name('services.show');



Route::middleware(['auth', 'user' , 'banned'])->group(function () {
    // Display saved services
    Route::get('/user/saved-services', [SavedServiceController::class, 'index'])
        ->name('saved-services.index');

    // single service
    // Toggle save status (using POST for security)
    Route::post('/services/{service}/save', [SavedServiceController::class, 'toggleSaved'])
        ->name('services.save');

    Route::post('/service/{service}/report', [ReportController::class, 'store'])->name('services.report');

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

    // own services actions
    Route::put('/{service}/activate', [ServiceController::class, 'activate'])->name('services.toggle-status');
    Route::get('services/{service}/promote/payment', [ServiceController::class, 'showPaymentPage'])->name('services.promote.payment');
    Route::post('/{service}/promote', [ServiceController::class, 'promote'])->name('services.promote');
    Route::delete('/service-images/{serviceImage}', [ServiceImageController::class, 'destroy'])->name('service-image.delete');
    Route::post('/services/upload', [ServiceController::class, 'upload'])->name('services.upload');



});





Route::middleware(['auth', 'admin'])
->prefix('admin')
->name('admin.')
->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // user routes
    Route::get('/users/ban-appeal' , [AdminUserController::class, 'banAppeal'])->name('users.ban-appeal');
    Route::Resource('/users', AdminUserController::class);
    Route::put('/users/{user}/ban', [AdminUserController::class, 'toggleBanUser'])->name('users.toggle-ban');


    // services routes
    Route::get('/services/index', [AdminServiceController::class, 'index'])->name('services.index');
    Route::delete('/services/{service}' , [AdminServiceController::class, 'destroy'])->name('services.destroy');
    Route::put('/services/{service}/activate' , [AdminServiceController::class, 'toggleStatus'])->name('service.toggle-status');
    Route::post('/service/promote', [AdminServiceController::class, 'promote'])->name('services.promote');

    // categories routes
    Route::resource('/categories', AdminCategoryController::class);

    // reports routes
    Route::get('/services/reports', [AdminReportController::class , 'index'])->name('service.reports');
    Route::put('/reports/{report}/resolve', [AdminReportController::class, 'markAsResolved'])->name('reports.resolve');


});

require __DIR__.'/auth.php';
