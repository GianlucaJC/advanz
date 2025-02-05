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



Route::group(['only_log' => ['auth']], function () {
    Route::get('main_log', [ 'as' => 'main_log', 'uses' => 'App\Http\Controllers\MainController@main_log']);
	Route::post('main_log', [ 'as' => 'main_log', 'uses' => 'App\Http\Controllers\MainController@main_log']);

    Route::get('dashboard', [ 'as' => 'dashboard', 'uses' => 'App\Http\Controllers\MainController@main_log']);
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
