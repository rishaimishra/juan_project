<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContractorController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\UserController;

Route::post('/leads', [LeadController::class, 'store']);

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
Route::post('/add-contractors',[ContractorController::class, 'add_contractor']);
Route::post('/add-leads',[ContractorController::class, 'add_leads']);

Route::post('/file_call',[ContractorController::class, 'call_file']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/paises', [ContractorController::class, 'getPaises']); // API for countries
Route::get('/provincias/{id}', [ContractorController::class, 'getProvincias']); 
Route::post('/add-user-with-job-api', [UserController::class, 'userWithJobCreateApi']);
