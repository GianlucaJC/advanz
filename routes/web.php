<?php

use App\Http\Controllers\AllestimentoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
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

	Route::post('stat', [ 'as' => 'stat', 'uses' => 'App\Http\Controllers\mainPharmaController@stat']);

    Route::get('send_result_pharma', [ 'as' => 'send_result_pharma', 'uses' => 'App\Http\Controllers\resultControllerPharma@send_result_pharma']);
	Route::post('send_result_pharma', [ 'as' => 'send_result_pharma', 'uses' => 'App\Http\Controllers\resultControllerPharma@send_result_pharma']);


    Route::get('main_admin_order', [ 'as' => 'main_admin_order', 'uses' => 'App\Http\Controllers\mainAdminController@main_admin_order']);
	Route::post('main_admin_order', [ 'as' => 'main_admin_order', 'uses' => 'App\Http\Controllers\mainAdminController@main_admin_order']);


    Route::get('main_admin_articoli', [ 'as' => 'main_admin_articoli', 'uses' => 'App\Http\Controllers\mainAdminController@main_admin_articoli']);
	Route::post('main_admin_articoli', [ 'as' => 'main_admin_articoli', 'uses' => 'App\Http\Controllers\mainAdminController@main_admin_articoli']);

    Route::get('/manage-categories', [CategoryController::class, 'manage'])->name('categories.manage');
    Route::get('/categories/get-packaging', [CategoryController::class, 'getPackagingForMolecule'])->name('categories.getPackaging');
    Route::get('/categories/get-pack-qty', [CategoryController::class, 'getPackQtyForPackaging'])->name('categories.getPackQty');
    Route::post('/categories/associate-packaging', [CategoryController::class, 'associatePackaging'])->name('categories.associatePackaging');
    Route::post('/categories/dissociate-packaging', [CategoryController::class, 'dissociatePackaging'])->name('categories.dissociatePackaging');
    Route::post('/categories/associate-pack-qty', [CategoryController::class, 'associatePackQty'])->name('categories.associatePackQty');
    Route::post('/categories/dissociate-pack-qty', [CategoryController::class, 'dissociatePackQty'])->name('categories.dissociatePackQty');
    Route::post('/categories/store-packaging', [CategoryController::class, 'storePackaging'])->name('categories.storePackaging');
    Route::post('/categories/store-pack-qty', [CategoryController::class, 'storePackQty'])->name('categories.storePackQty');

    Route::post('update_order', [ 'as' => 'update_order', 'uses' => 'App\Http\Controllers\mainAdminController@update_order']);
        
    Route::post('update_art', [ 'as' => 'update_art', 'uses' => 'App\Http\Controllers\mainAdminController@update_art']);

    Route::post('update_art_liof', [ 'as' => 'update_art_liof', 'uses' => 'App\Http\Controllers\mainAdminController@update_art_liof']);

    Route::post('refill_art', [ 'as' => 'refill_art', 'uses' => 'App\Http\Controllers\mainAdminController@refill_art']);

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


// Rotte per la gestione dell'allestimento
Route::middleware('auth')->group(function () {
    Route::get('allestimento', [AllestimentoController::class, 'index'])->name('allestimento.index');
    Route::post('allestimento/get-packaging', [AllestimentoController::class, 'getPackaging'])->name('allestimento.getPackaging');
    Route::post('allestimento/get-pack-qty', [AllestimentoController::class, 'getPackQty'])->name('allestimento.getPackQty');
    Route::post('allestimento/get-data', [AllestimentoController::class, 'getAllestimentoData'])->name('allestimento.getData');
    Route::post('allestimento/refill', [AllestimentoController::class, 'refillAllestimento'])->name('allestimento.refill');
    Route::post('allestimento/save', [AllestimentoController::class, 'saveAllestimento'])->name('allestimento.save');
});
