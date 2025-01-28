<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Middleware\SetLocale; // Make sure to import your middleware
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\LeadsController;

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

Route::get('/cache-clear', function () {
    try {
        Artisan::call('optimize:clear');
        return "The storage link has been created successfully.";
    } catch (\Exception $e) {
        return "An error occurred: " . $e->getMessage();
    }
});

Route::get('/migrate_fresh', [ContractorController::class, 'fresh']);
Route::get('/localisation/{locale}', function ($locale) {
    if (!in_array($locale, config('localisation.locales'))) {
        abort(400);
    }

    session(['localization' => $locale]);
    return redirect()->back(); // Change to your actual view
})->name('localization');

Route::middleware(SetLocale::class)->group(function () {
    // Route for the home page
    Route::get('/', function () {
        return redirect()->route('login');
    });

    //user crud
    Route::get('/add-user', [UserController::class, 'index'])->name('user.index');
    Route::post('/add-user', [UserController::class, 'create'])->name('user.create');
    Route::get('/add-user-with-job', [UserController::class, 'userWithJobIndex'])->name('user.userWithJobIndex');
    Route::post('/add-user-with-job', [UserController::class, 'userWithJobCreate'])->name('user.userWithJobCreate');

    
    //contractor crud
    Route::get('/add-contractors', [ContractorController::class, 'index'])->name('contractor.index');
    Route::post('/add-contractors', [ContractorController::class, 'create'])->name('contractor.create');
    Route::get('/get_contractor_email', [ContractorController::class, 'get_contractor_email'])->name('get-contractor-email');
    Route::get('/get-states/{country_id}', [ContractorController::class, 'getStatesByCountry'])->name('getStatesByCountry');
    Route::get('/get-allstates/{country_id}', [ContractorController::class, 'getallStates'])->name('getallStates');
    Route::get('/test', function () {
        return 'asdf';
    });

    Route::post('/test', function () {
        return 'asdf';
    });
});


Auth::routes();
Route::post('/custom-logout', [AuthController::class, 'customLogout'])->name('custom-logout');

Route::get('/user-login', [AuthController::class, 'login'])->name('user-login');
Route::get('/contractor-login', [AuthController::class, 'contractor_login_page'])->name('contractor-login');
Route::post('/contractor-login', [AuthController::class, 'contractor_login'])->name('auth.login.contractor');
Route::get('/forget_password', [AuthController::class, 'forget_password'])->name('forget-password');
Route::post('/send_forget_password', [AuthController::class, 'send_forget_password'])->name('send-forget-password');
Route::post('/login-user', [AuthController::class, 'user_login'])->name('login-user');
Route::middleware(['auth', 'adminType'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/delete_contractor/{id}', [HomeController::class, 'delete_contractor'])->name('delete_contractor');
    Route::get('/get_seller_data', [ContractorController::class, 'getAllsellersData'])->name('getAllsellersData');
    Route::get('/get_users', [ContractorController::class, 'get_users'])->name('get_users');
    Route::get('/admin_approve/{id}', [AuthController::class, 'admin_approve'])->name('admin_approve');
    Route::get('/admin_reject/{id}', [AuthController::class, 'admin_reject'])->name('admin_reject');
    Route::get('/admin_approve_opp/{id}', [OpportunityController::class, 'admin_approve_opp'])->name('admin_approve_opp');
    Route::get('/admin_reject_opp/{id}', [OpportunityController::class, 'admin_reject_opp'])->name('admin_reject_opp');
    Route::get('/admin_edit_opportunity/{id}', [OpportunityController::class, 'admin_edit_opportunity'])->name('admin_edit_opportunity');
    Route::post('/admin_update_opportunity', [OpportunityController::class, 'admin_update_opportunity'])->name('admin_update_opportunity');
    Route::get('/get_opportunity_list', [OpportunityController::class, 'admin_opportunity_list'])->name('getadminopp');
    Route::get('/show_opp_contractors/{id}', [OpportunityController::class, 'show_opportunity_contractors'])->name('show_opportunity_contractors');
    Route::get('/contractor-send-message/{oppId}/{con_id}', [OpportunityController::class, 'admin_contractor_message_show'])->name('show_contrctor_message_admin');
    Route::get('/get_leads', [LeadsController::class, 'index'])->name('get_leads');
    Route::get('/get_invoice', [InvoiceController::class, 'get_invoice'])->name('get_invoice');
});
Route::middleware(['auth', 'contractorType'])->group(function () {
    Route::get('/see-contractor-opportunity/{id}', [OpportunityController::class, 'see_contractor'])->name('see-contractor-opportunity');
    Route::get('/reject-contractor-opportunity/{id}', [OpportunityController::class, 'reject_opportunity'])->name('reject-contractor-opportunity');
    Route::get('/invoice_generate/{id}', [OpportunityController::class, 'invoice_generate'])->name('invoice_generate');
    Route::get('/list', [InvoiceController::class, 'list'])->name('invoice-list');
    Route::get('/paypal/payment/{amount}/{id}', [InvoiceController::class, 'createPayment'])->name('paypal.payment');
    // Route::get('/paypal/card-payment/{amount}/{id}', [InvoiceController::class, 'createCardPayment'])->name('paypal.card-payment');
    Route::get('/paypal/success', [InvoiceController::class, 'success'])->name('paypal.success');
    Route::get('/card/success/{id}', [InvoiceController::class, 'Cardsuccess'])->name('card.success');

    Route::get('/paypal/cancel', [InvoiceController::class, 'cancel'])->name('paypal.cancel');
    Route::post('/generate-hash', [InvoiceController::class, 'generateHash'])->name('generate.hash');
    // Route::get('download_invoice_contractor/{id}', [InvoiceController::class, 'download_invoice_contractor'])->name('download_invoice_contractor');
    Route::get('/contractor-message-opportunity/{id}/{oppId}', [OpportunityController::class, 'contractor_message_opportunity'])->name('contractor-message-opportunity');
    Route::post('/send-message-contractor', [OpportunityController::class, 'send_message_contractor'])->name('send-message-contractor');
});

Route::middleware(['auth', 'userOrContractor'])->group(function () {
    Route::get('/user-dashboard', [AuthController::class, 'user_dashboard_page'])->name('users-dashboard');
    Route::get('/edit-profile/{id}', [AuthController::class, 'edit_profile'])->name('edit-profile');
    Route::post('/update-profile', [AuthController::class, 'update_profile'])->name('update-profile');
    Route::get('/edit-contractor-profile/{id}', [AuthController::class, 'edit_contractor_profile'])->name('edit-contractor-profile');
    Route::post('/update-contractor-profile', [AuthController::class, 'update_contractor_profile'])->name('update-contractor-profile');
});
Route::middleware(['auth', 'userType'])->group(function () {
    Route::get('/create-opportunity', [OpportunityController::class, 'create'])->name('create-opportunity');
    Route::get('/see-opportunity/{id}', [OpportunityController::class, 'see'])->name('see-opportunity');
    Route::post('/store-opportunity', [OpportunityController::class, 'store'])->name('store-opportunity');
    Route::post('/update-opportunity', [OpportunityController::class, 'update'])->name('update-opportunity');
    Route::get('/chat-opportunity/{id}', [OpportunityController::class, 'chat_opportunity'])->name('chat-opportunity');

    Route::get('/message-opportunity/{id}/{oppId}', [OpportunityController::class, 'message_opportunity'])->name('message-opportunity');
    Route::post('/send-message', [OpportunityController::class, 'send_message'])->name('send-message');
});
