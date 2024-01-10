<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\v1\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    Route::resource('tickets', TicketController::class)->except(['create', 'edit']);
    Route::post('tickets/{ticketId}/store/comments', [TicketController::class, 'addComment'])->name('comment.store'); 
    Route::post('tickets/{ticketId}/store/comments/{commentId}/answer', [TicketController::class, 'answerComment'])->name('comment.answer');
 
});
