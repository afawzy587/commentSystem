<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Reply\ReplyController;

Route::redirect('/', 'login');


Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/comments',[CommentController::class,'index'])->name('home');
    Route::post('/comments',[CommentController::class,'store'])->name('home');
    Route::post('/replies', [ReplyController::class, 'store'])->name('replies.store');
});
require __DIR__.'/auth.php';
