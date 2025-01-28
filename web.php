<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Middleware\SetLocale; // Make sure to import your middleware
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

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

Route::get('/migrate_fresh', [ContractorController::class, 'fresh']);
 // Route for the home page
 Route::get('/',function(){
    return 'WELCOME TO BIDINPROJECT';
});
Route::get('/login', function () {
    return 'WELCOME TO BIDINPROJECT';// Redirect to your custom login or any other page
});



Route::get('/localisation/{locale}', function ($locale) {

    if (!in_array($locale, config('localisation.locales'))) {
        abort(400);
    }

    session(['localization'=>$locale]);
    return redirect()->back(); // Change to your actual view
})->name('localization');

Route::middleware(SetLocale::class)->group(function ()  {
    // Route for the home page
    Route::get('/',function(){
        return 'WELCOME TO BIDINPROJECT';
    });
    //user crud
    Route::get('/add-user',[UserController::class, 'index'])->name('user.index');
    Route::post('/add-user',[UserController::class, 'create'])->name('user.create');


    //contractor crud
    Route::get('/add-contractors',[ContractorController::class, 'index'])->name('contractor.index');
    Route::post('/add-contractors',[ContractorController::class, 'create'])->name('contractor.create');
    Route::get('/get-states/{country_id}', [ContractorController::class, 'getStatesByCountry'])->name('getStatesByCountry');
    Route::get('/get-allstates/{country_id}', [ContractorController::class, 'getallStates'])->name('getallStates');
    Route::get('/test', function () {
        return 'asdf';
    });

    Route::post('/test', function () {
        return 'asdf';
    });

});




// Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/delete_contractor/{id}', [HomeController::class, 'delete_contractor'])->name('delete_contractor');
Route::get('/get_seller_data', [ContractorController::class, 'getAllsellersData'])->name('getAllsellersData');

