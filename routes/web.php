<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\Admin\LuckyDrawController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ManageController;

use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\SchemePaymentController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PayphiController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

// =====================
// 🏛️ ADMIN ROUTES
// =====================
Route::prefix('admin')->group(function () {
    // Login / Logout
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Protected routes
    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Customers
        Route::group(['middleware' => ['auth', 'role:Admin|Manager|Executive']], function () {
            Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
            Route::get('/customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
            Route::post('/customers', [CustomerController::class, 'store'])->name('admin.customers.store');
            Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit');
            Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');
            Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');
            Route::get('/customers/duplicates', [CustomerController::class, 'duplicates'])->name('admin.customers.duplicates');
            Route::post('/customers/{customer}/verify', [CustomerController::class, 'updateVerification'])->name('admin.customers.verify');
        });

        // Schemes
        Route::middleware(['auth', 'role:Admin,Manager'])->group(function () {
            Route::resource('schemes', SchemeController::class)->names('admin.schemes');
        });

        // Sales
        Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
            Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
            Route::delete('sales/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');
        });

        // Exports
        Route::prefix('admin/exports')->middleware(['auth', 'role:Admin|Manager'])->group(function () {
            Route::get('/dashboard', [ExportController::class, 'dashboard'])->name('admin.exports.dashboard');
            Route::get('/pdf/{type}', [ExportController::class, 'downloadPdf'])->name('exports.pdf');
            Route::get('/excel/{type}', [ExportController::class, 'downloadExcel'])->name('exports.excel');
            Route::get('/csv/{type}', [ExportController::class, 'downloadCsv'])->name('exports.csv');
            Route::post('/email/{type}', [ExportController::class, 'sendEmailReport'])->name('exports.email');
            Route::post('/whatsapp/{type}', [ExportController::class, 'sendWhatsAppReport'])->name('exports.whatsapp');
        });

        // Reports
        Route::prefix('reports')->group(function () {
            Route::get('schemes', [ReportController::class, 'schemeReport'])->name('admin.reports.schemes');
        });

        // Payments
        Route::prefix('/payments')->group(function () {
            Route::get('/', [PaymentsController::class, 'index'])->name('payments.index');
            Route::get('/payments/export/{type}', [PaymentsController::class, 'export'])->name('payments.export');
            Route::post('/payments/initiate', [PaymentsController::class, 'initiatePayment'])->name('payments.initiate');
            Route::post('/payments/callback', [PaymentsController::class, 'paymentCallback'])->name('payments.callback');
        });

        // Lucky Draw
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/lucky-draws', [LuckyDrawController::class, 'index'])->name('lucky_draws.index');
            Route::delete('/lucky-draws/{luckyDraw}', [LuckyDrawController::class, 'destroy'])->name('lucky_draws.destroy');
            Route::get('/lucky-draws/export', [LuckyDrawController::class, 'export'])->name('lucky_draws.export');
            Route::post('/lucky-draws/{luckyDraw}/add-reward', [LuckyDrawController::class, 'addReward'])->name('lucky_draws.add_reward');
        });

        // Scheme Payments

Route::prefix('admin')->name('admin.')->group(function () {

    // List Page
    Route::get('/scheme-payments', [SchemePaymentController::class, 'index'])
        ->name('scheme_payments.index');

    // Create Form Page
    Route::get('/scheme-payments/create', [SchemePaymentController::class, 'create'])
        ->name('scheme_payments.create');

    // Form Submit (store)
    Route::post('/scheme-payments/store', [SchemePaymentController::class, 'store'])
        ->name('scheme_payments.store');

    // Delete
    Route::delete('/scheme-payments/{schemePayment}', [SchemePaymentController::class, 'destroy'])
        ->name('scheme_payments.destroy');

    // Export CSV/Excel
    Route::get('/scheme-payments/export', [SchemePaymentController::class, 'export'])
        ->name('scheme_payments.export');

    // Generate Lucky Draw Coupons
    Route::get('/scheme-payments/generate-lucky-draw', [SchemePaymentController::class, 'generateLuckyDrawCoupons'])
        ->name('scheme_payments.generate_lucky_draw');
});


        // Roles
        Route::name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
            Route::resource('roles', RoleController::class)->except(['show']);
        });
    });
});


// ===================================================
// 💳 PAYPHI PAYMENT GATEWAY ROUTES (FINAL CLEAN VERSION)
// ===================================================



// 🧾 Checkout form
// 🧾 Checkout form
Route::get('/payphi/checkout', [PayphiController::class, 'showCheckout'])->name('payphi.checkout');

// 💳 Initiate Payment
Route::post('/payphi/initiate', [PayphiController::class, 'initiatePayment'])
    ->name('payphi.initiate');

// 🔁 Callback Route (CSRF disabled)
Route::match(['GET', 'POST'], '/payphi/callback', [PayphiController::class, 'paymentCallback'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('payphi.callback');


// 🧩 Debug Route - To check .env configuration
Route::get('/payphi-debug', function () {
    return [
        'merchant' => env('PAYPHI_MERCHANT_ID', 'not found'),
        'hash' => env('PAYPHI_HASH_KEY', 'not found'),
        'sale_url' => env('PAYPHI_SALE_URL', 'not found'),
        'return_url' => env('PAYPHI_RETURN_URL', 'not found'),
    ];
});
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::put('/contacts/{customer_id}/conversation', [ContactController::class, 'saveConversation'])->name('contacts.saveConversation');
    Route::delete('/contacts/conversation/{id}', [ContactController::class, 'deleteConversation'])->name('contacts.deleteConversation');
});

// ✅ Success Page
Route::get('/payphi/success', function () {
    $data = session('data', []);
    return view('payphi_success', compact('data'));
})->name('payphi.success');

// ❌ Failure Page
Route::get('/payphi/failure', function () {
    $data = session('data', []);
    $error = session('error', 'Payment Failed');
    return view('payphi_failure', compact('data', 'error'));
})->name('payphi.failure');

// 🧩 Debug Route (for .env test)
Route::get('/payphi-debug', function () {
    return [
        'merchant' => env('PAYPHI_MERCHANT_ID', 'not found'),
        'hash' => env('PAYPHI_HASH_KEY', 'not found'),
        'sale_url' => env('PAYPHI_SALE_URL', 'not found'),
        'return_url' => env('PAYPHI_RETURN_URL', 'not found'),
    ];
});
Route::prefix('admin')->name('admin.')->group(function () {

    /** -------------------------------
     *  SCHEME SETTINGS ROUTES
     * ------------------------------- */
    Route::get('/manage/settings', [ManageController::class, 'settings'])
        ->name('manage.settings');

    Route::post('/manage/settings/store', [ManageController::class, 'settingsStore'])
        ->name('manage.settings.store');

    Route::get('/manage/settings/{id}/edit', [ManageController::class, 'settingsEdit'])
        ->name('manage.settings.edit');

    Route::put('/manage/settings/{id}', [ManageController::class, 'settingsUpdate'])
        ->name('manage.settings.update');

    Route::delete('/manage/settings/{id}', [ManageController::class, 'settingsDestroy'])
        ->name('manage.settings.destroy');


    /** -------------------------------
     *  MANAGE CUSTOMER SCHEME ROUTES
     * ------------------------------- */
    Route::get('/manage/{id}/pdf', [ManageController::class, 'downloadPdf'])
    ->name('manage.pdf');
    Route::get('/manage/create', [ManageController::class, 'create'])
        ->name('manage.create');

    Route::post('/manage/store', [ManageController::class, 'store'])
        ->name('manage.store');


    Route::get('/manage', [ManageController::class, 'index'])
        ->name('manage.index');

    Route::get('/manage/{id}', [ManageController::class, 'show'])
        ->name('manage.show');
Route::get('admin/customers', [App\Http\Controllers\Admin\ManageController::class, 'create123'])
    ->name('manage.customers');

    Route::get('/manage/{id}/edit', [ManageController::class, 'edit'])
        ->name('manage.edit');

    Route::put('/manage/{id}/update', [ManageController::class, 'update'])
        ->name('manage.update');

    Route::delete('/manage/{id}/delete', [ManageController::class, 'destroy'])
        ->name('manage.delete');
});


Route::get('/', function () {
    return redirect()->route('admin.login');
});
