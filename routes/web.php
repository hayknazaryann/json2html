<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::group(['middleware' => 'auth'], function (){
    Route::get('/', function (){
        return redirect('/generate/list');
    });
    Route::match(['GET', 'POST'],'/generate/list', [\App\Http\Controllers\ListsController::class,'generateList'])->name('list.generate');
    Route::post('load/inputs', [\App\Http\Controllers\ListsController::class,'loadInputs'])->name('load.inputs');
});
