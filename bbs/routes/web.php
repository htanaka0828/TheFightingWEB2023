<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\AccountsController;

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

Route::get('/comments', [CommentsController::class, 'index']);
// loginページを表示する
Route::get('/accounts', [AccountsController::class, 'index']);
Route::post('/accounts', [AccountsController::class, 'login']);

// accountの作成formの表示
Route::get('/accounts/create', [AccountsController::class, 'create_form']);
Route::post('/accounts/create', [AccountsController::class, 'create']);
