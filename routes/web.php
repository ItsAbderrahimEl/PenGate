<?php


use App\Http\Controllers\{LikeController,
    PostController,
    UserController,
    FollowController,
    SessionController,
    CommentController,
    ExamplesController,
    SessionsController,
    DashboardController,
    EmailVerificationController};
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/posts');

Route::controller(EmailVerificationController::class)
    ->prefix('email')
    ->middleware('auth')
    ->name('verification.')
    ->group(function (
) {
    Route::get('verify', 'create')->name('notice');
    Route::get('verify/{id}/{hash}', 'verify')->name('verify')->middleware('signed');
    Route::post('verification-notification', 'send')->name('send')->middleware('throttle:6,1');
});

Route::get('example/{example}', ExamplesController::class)->name('example');

Route::controller(SessionController::class)->group(function () {
    Route::delete('login', 'destroy')->middleware('auth')->name('login.destroy');

    Route::middleware('guest')->group(function () {
        Route::get('login', 'create')->name('login.create');
        Route::post('login', 'store')->name('login.store');
    });
});

Route::controller(SessionsController::class)->group(function () {
    Route::get('sessions', 'index')->name('sessions.index');
    Route::delete('sessions', 'destroy')->name('sessions.destroy');
});

Route::controller(UserController::class)->group(function () {
    Route::get('users/{user}/{name}', 'show')->name('users.show');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('profile', 'edit')->name('profile.edit');
        Route::post('profile', 'update')->name('profile.update');
        Route::delete('profile', 'destroy')->name('profile.destroy');
    });

    Route::middleware('guest')->group(function () {
        Route::get('signup', 'create')->name('signup.create');
        Route::post('signup', 'store')->name('signup.store');
    });
});

Route::controller(PostController::class)->group(function () {
    Route::get('posts', 'index')->name('posts.index');
    Route::get('posts/{post}/{slug?}', 'show')->whereNumber('post')->name('posts.show');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::post('posts', 'store')->name('posts.store');
        Route::delete('posts/{post}', 'destroy')->name('posts.destroy');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'show')->name('dashboard.show');
    });

    Route::controller(CommentController::class)->group(function () {
        Route::post('posts/{post}/comments', 'store')->name('posts.comments.store');
        Route::put('comments/{comment}', 'update')->name('comments.update');
        Route::delete('/comments/{comment}', 'destroy')->name('comments.destroy');
    });

    Route::controller(LikeController::class)->group(function () {
        Route::post('likes/{what}/{id}', 'store')->name('likes.store');
        Route::delete('likes/{like}', 'destroy')->name('likes.destroy');
    });

    Route::controller(FollowController::class)->group(function () {
        Route::get('follows', 'index')->name('follows.index');
        Route::post('follows/{followed}', 'store')->name('follows.store');
        Route::delete('follows/{follow}', 'destroy')->name('follows.destroy');
    });
});