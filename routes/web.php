<?php

use App\Http\Controllers\ProfileController;
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

Route::get('main', [ 'as' => 'main', 'uses' => 'App\Http\Controllers\MainController@main']);
Route::post('main', [ 'as' => 'main', 'uses' => 'App\Http\Controllers\MainController@main']);

Route::get('contact', [ 'as' => 'contact', 'uses' => 'App\Http\Controllers\MainController@contact']);
Route::post('contact', [ 'as' => 'contact', 'uses' => 'App\Http\Controllers\MainController@contact']);

Route::post('check_allestimento', [ 'as' => 'check_allestimento', 'uses' => 'App\Http\Controllers\AjaxController@check_allestimento']);

Route::middleware('auth')->group(function () {
    Route::get('main_log', [ 'as' => 'main_log', 'uses' => 'App\Http\Controllers\MainController@main_log']);
	Route::post('main_log', [ 'as' => 'main_log', 'uses' => 'App\Http\Controllers\MainController@main_log']);
    
    Route::get('order', [ 'as' => 'order', 'uses' => 'App\Http\Controllers\orderController@order']);
	Route::post('order', [ 'as' => 'order', 'uses' => 'App\Http\Controllers\orderController@order']);

    Route::get('send_result', [ 'as' => 'send_result', 'uses' => 'App\Http\Controllers\resultController@send_result']);
	Route::post('send_result', [ 'as' => 'send_result', 'uses' => 'App\Http\Controllers\resultController@send_result']);
    Route::post('delete_up', [ 'as' => 'delete_up', 'uses' => 'App\Http\Controllers\resultController@delete_up']);
    Route::post('upload', [ 'as' => 'upload', 'uses' => 'App\Http\Controllers\FileUploadController@upload']);
    Route::get('dashboard', [ 'as' => 'dashboard', 'uses' => 'App\Http\Controllers\MainController@main_log']);

    Route::get('main_pharma', [ 'as' => 'main_pharma', 'uses' => 'App\Http\Controllers\mainPharmaController@main_pharma']);
	Route::post('main_pharma', [ 'as' => 'main_pharma', 'uses' => 'App\Http\Controllers\mainPharmaController@main_pharma']);

    Route::get('send_result_pharma', [ 'as' => 'send_result_pharma', 'uses' => 'App\Http\Controllers\resultControllerPharma@send_result_pharma']);
	Route::post('send_result_pharma', [ 'as' => 'send_result_pharma', 'uses' => 'App\Http\Controllers\resultControllerPharma@send_result_pharma']);
});      


/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/


//route profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
