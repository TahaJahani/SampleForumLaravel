<?php

use App\Http\Controllers\ForumController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('forum')->group(function () {
    Route::post('question', [ForumController::class, 'addQuestion']);
    Route::get('question', [ForumController::class, 'viewQuestion']);
    Route::post('reply', [ForumController::class, 'addReply']);
    Route::get('list', [ForumController::class, 'viewAllQuestions']);
});
