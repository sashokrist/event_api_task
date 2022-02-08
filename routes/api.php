<?php

use App\Http\Controllers\API\V1\MeetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::middleware('auth:api')
    ->get('/user', function (Request $request) {
        return $request->user();
    });*/

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

//Route::group(['middleware' => 'auth:sanctum'], function() {
Route::get('meets', [MeetController::class, 'index'])->name('meets');
Route::post('meet', [MeetController::class, 'store']);
Route::post('meet/{meet}', [MeetController::class, 'update']);
Route::delete('meet/{meet}', [MeetController::class, 'delete']);
Route::get('meets-user', [MeetController::class, 'userMeets']);
Route::post('meets-user-today', [MeetController::class, 'todayUserMeets']);
//});
