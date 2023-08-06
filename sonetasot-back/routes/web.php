<?php

use App\Http\Controllers\Api\CurpController;
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
});

Route::get('/api/getAllCURPS',[CurpController::class,"index"]);
Route::post('/api/createCurp',[CurpController::class,"create"]);
Route::put('/api/updateCurp',[CurpController::class,"update"]);
Route::get('/api/getCurp/{curp}',[CurpController::class,"getCurp"]);
Route::get('/api/getCurp/{curp}',[CurpController::class,"getCurp"]);
Route::delete('/api/deleteCurp/{curp}',[CurpController::class,"deleteCurp"]);