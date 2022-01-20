<?php

use App\Http\Controllers\Content\CommentController;
use App\Http\Controllers\Content\NewsController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\Content\ContentController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BannedPageController;
use App\Http\Controllers\DeletedController;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\MailtrapExample;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Authentication
Route::get('/login/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/', [LoginController::class, 'login']);
Route::post('/forgot-password/', [UserController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/recover/{id}', [UserController::class, 'viewRecoverPassword']);
Route::post('/recover_password', [UserController::class, 'recoverPassword']);

Route::get('/logout/', [LoginController::class, 'logout'])->name('logout');
Route::get('/register/', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register/', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {

    // Deleted user
    Route::get('/deleted_user', [DeletedController::class, 'show']);
    Route::post('/recover_user', [DeletedController::class, 'recoverUser']);
});

Route::middleware(['deleted'])->group(function () {

    Route::middleware(['notbanned'])->group(function () {

        // Content
        Route::get('/news/{id}/', [NewsController::class, 'show'])->where(['id'=>'[0-9]+']);

        // Home
        Route::get('/', [HomepageController::class, 'show'])->name('home');

        // Search
        Route::get('/search/', [SearchController::class, 'show'])->name('search');

        // Profile
        Route::get('/user/{username}', [UserController::class, 'show']);

        // FAQ
        Route::get('/faq/', [FAQController::class, 'show'])->name('faq');

         // Contacts
        Route::get('/contacts/', [ContactsController::class, 'show'])->name('contacts');

        // About
        Route::get('/about/', [AboutController::class, 'show'])->name('about');
    });


    // Authenticated needed for this routes
    Route::middleware(['auth'])->group(function () {

        Route::middleware(['ban'])->group(function () {
            Route::get('/ban/', [BannedPageController::class, 'show'])->name('ban');
            Route::post('/user/{username}/unban_appeal/', [UserController::class, 'unban_appeal']);
        });

        Route::middleware(['notbanned'])->group(function () {

            // content
            Route::post('/vote', [ContentController::class, 'toggleVote']);

            // news
            Route::post('/news/create/', [NewsController::class, 'create']);
            Route::patch('/news/{id}/', [NewsController::class, 'edit'])->where(['id'=>'[0-9]+']);
            Route::delete('/news/{id}/', [NewsController::class, 'delete'])->where(['id'=>'[0-9]+']);
            Route::post('/news/{id}/report/', [NewsController::class, 'report'])->where(['id'=>'[0-9]+']);

            // comments
            Route::post('/comment/{id}/report/', [CommentController::class, 'report'])->where(['id'=>'[0-9]+']);
            Route::post('/comment/create/', [CommentController::class, 'create']);
            Route::patch('/comment/{id}', [CommentController::class, 'edit'])->where(['id'=>'[0-9]+']);
            Route::delete('/comment/{id}', [CommentController::class, 'delete'])->where(['id'=>'[0-9]+']);

            //notifications
            Route::get('/notifications/', [NotificationsController::class, 'show']);
            Route::delete('/notifications/', [NotificationsController::class, 'delete']);

            // faq
            Route::post('/faq/', [FAQController::class, 'create']);
            Route::patch('/faq/{id}/', [FAQController::class, 'edit'])->where(['id'=>'[0-9]+'])->middleware(['admin']);
            Route::delete('/faq/{id}/', [FAQController::class, 'delete'])->where(['id'=>'[0-9]+'])->middleware(['admin']);

            // report
            Route::post('/user/{id}/report/', [UserController::class, 'report'])->where(['id'=>'[0-9]+']);
            Route::post('/user/{id}/ban/', [UserController::class, 'ban'])->middleware(['admin']);

            // profile
            Route::get('/user/{username}/edit', [UserController::class, 'showEditPage']);
            Route::post('/update_password', [UserController::class, 'updatePassword']);
            Route::post('/update_profile', [UserController::class, 'updateUser']);
            Route::post('/delete_user', [UserController::class, 'deleteUser']);
            Route::post('/follow', [UserController::class, 'follow']);
            Route::post('/unfollow', [UserController::class, 'unfollow']);

            // request
            Route::patch('/request/{id}/accept/', [RequestController::class, 'approve']);
            Route::patch('/request/{id}/reject/', [RequestController::class, 'reject']);

        });
    });
});


Route::get('/clear-all-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    echo "Cleared all caches successfully.";
});

Route::get('/send-mail/{mail}', function (Request $request) {
   
    Mail::to($request->mail)->send(new MailtrapExample());
    return 'A message has been sent to Mailtrap!';

});