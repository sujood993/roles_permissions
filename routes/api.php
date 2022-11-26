<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

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
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth:api', 'isAdmin'])->group(function () {
    Route::Resource('users', UserController::class);
});
Route::post('users/{user}/assign-rules', [UserController::class, 'assignRule']);
Route::post('/assign-permission-role/{role}', [UserController::class, 'assignPermissionRule']);




