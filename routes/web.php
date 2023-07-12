<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
Use App\Http\Controllers\MessagesController;
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
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
    Route::post('/updateAbout', [ProfileController::class, 'updateAbout'])->middleware('auth');
    Route::post('/updateName', [ProfileController::class,  'updateName'])->middleware('auth');
    Route::post('/updateImg', [ProfileController::class,  'updateImg'])->middleware('auth');
Route::get('/messages', [MessagesController::class, 'showChat'])->middleware('auth');
Route::post('/addPost', [PostController::class,  'addPost'])->middleware('auth');
//Route::get('/profile', [PostController::class, 'showPost']);

require __DIR__.'/auth.php';
