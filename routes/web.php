<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('profile/avatar', [ProfileController::class, 'avatar'])->name('avatar.update');
    Route::get('/profile-search', [ProfileController::class, 'search'])->name('profile.search');

    Route::get('/', [WelcomeController::class, 'index']);
    Route::get('author_profile/{username}', [UserController::class, 'authorProfile'])->name('author_profile');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post:uuid}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/edit/{post:uuid}', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post:uuid}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post:uuid}', [PostController::class, 'destroy'])->name('posts.destroy');


    Route::post('/comments/store/{post:uuid}', [CommentController::class, 'store'])->name('comments.store');
});

require __DIR__.'/auth.php';
