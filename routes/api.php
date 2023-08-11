<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/chat/auth', 'MessagesController@pusherAuth')->name('api.pusher.auth');
Route::post('/idInfo', 'MessagesController@idFetchData')->name('api.idInfo');
Route::post('/sendMessage', 'MessagesController@send')->name('api.send.message');
Route::get('/download/{fileName}', 'MessagesController@download')->name('api.'.config('chatify.attachments.download_route_name'));
Route::post('/makeSeen', 'MessagesController@seen')->name('api.messages.seen');
Route::get('/getContacts', 'MessagesController@getContacts')->name('api.contacts.get');
Route::post('/star', 'MessagesController@favorite')->name('api.star');
Route::post('/favorites', 'MessagesController@getFavorites')->name('api.favorites');
Route::get('/search', 'MessagesController@search')->name('api.search');
Route::post('/shared', 'MessagesController@sharedPhotos')->name('api.shared');
Route::post('/deleteConversation', 'MessagesController@deleteConversation')->name('api.conversation.delete');
Route::post('/updateSettings', 'MessagesController@updateSettings')->name('api.avatar.update');

