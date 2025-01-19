<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/friends', [FriendController::class, 'index'])->name('friends');
Route::post('/friends/{id}/give-thumb', [FriendController::class, 'giveThumb'])->name('friends.giveThumb');


Route::get('/friend-requests', [UserController::class, 'friendRequests'])->name('friend.requests');
Route::post('/friend-request/accept/{id}', [UserController::class, 'acceptFriendRequest'])->name('friend.accept');
Route::post('/friend-request/decline/{id}', [UserController::class, 'declineFriendRequest'])->name('friend.decline');

Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/chat/{friendId}', [MessageController::class, 'chat'])->name('messages.chat');
Route::post('/messages/send/{receiverId}', [MessageController::class, 'sendMessage'])->name('messages.send');


