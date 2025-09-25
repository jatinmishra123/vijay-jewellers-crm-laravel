<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\Admin\LuckyDrawController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\SchemePaymentController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PayphiController;

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->group(function () {

    // Login / Logout
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Protected routes (only for logged-in users)
    Route::middleware('auth')->group(function () {

        // Dashboard (all authenticated users)
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // routes/web.php
        Route::group(['middleware' => ['auth', 'role:Admin|Manager|Executive']], function () {
            // Customer routes
            Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
            Route::get('/customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
            Route::post('/customers', [CustomerController::class, 'store'])->name('admin.customers.store');
            Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit');
            Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');
            Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');
            Route::get('/customers/duplicates', [CustomerController::class, 'duplicates'])
                ->name('admin.customers.duplicates')
                ->middleware('auth');

            // Verification route
            Route::post('/customers/{customer}/verify', [CustomerController::class, 'updateVerification'])
                ->name('admin.customers.verify');
        });

        Route::middleware(['auth', 'role:Admin,Manager'])->group(function () {
            Route::resource('schemes', SchemeController::class)->names('admin.schemes');
        });


        Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
            Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
            Route::delete('sales/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');
        });



        Route::prefix('admin/exports')->middleware(['auth', 'role:Admin|Manager'])->group(function () {
            Route::get('/dashboard', [ExportController::class, 'dashboard'])->name('admin.exports.dashboard');

            Route::get('/pdf/{type}', [ExportController::class, 'downloadPdf'])->name('exports.pdf');
            Route::get('/excel/{type}', [ExportController::class, 'downloadExcel'])->name('exports.excel');
            Route::get('/csv/{type}', [ExportController::class, 'downloadCsv'])->name('exports.csv');

            Route::post('/email/{type}', [ExportController::class, 'sendEmailReport'])->name('exports.email');
            Route::post('/whatsapp/{type}', [ExportController::class, 'sendWhatsAppReport'])->name('exports.whatsapp');
        });


        // Reports (all logged-in users can see, or restrict if needed)
        Route::prefix('reports')->group(function () {
            Route::get('schemes', [ReportController::class, 'schemeReport'])->name('admin.reports.schemes');
        });
        Route::prefix('/payments')->group(function () {
            Route::get('/', [PaymentsController::class, 'index'])->name('payments.index');
            Route::get('/payments/export/{type}', [PaymentsController::class, 'export'])->name('payments.export');
            Route::post('/payments/initiate', [PaymentsController::class, 'initiatePayment'])->name('payments.initiate');
            Route::post('/payments/callback', [PaymentsController::class, 'paymentCallback'])->name('payments.callback');

        });

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/lucky-draws', [LuckyDrawController::class, 'index'])->name('lucky_draws.index');
            Route::delete('/lucky-draws/{luckyDraw}', [LuckyDrawController::class, 'destroy'])->name('lucky_draws.destroy');
            Route::get('/lucky-draws/export', [LuckyDrawController::class, 'export'])->name('lucky_draws.export');
            Route::post('/lucky-draws/{luckyDraw}/add-reward', [LuckyDrawController::class, 'addReward'])->name('lucky_draws.add_reward');
        });





        // Sales (Admin only)
        // Route::middleware('role:Admin')->group(function () {
        //     Route::get('sales', [SalesController::class, 'index'])->name('admin.sales.index');
        // });

        Route::prefix('admin')->name('admin.')->group(function () {

            // Scheme Payments List
            Route::get('/scheme-payments', [SchemePaymentController::class, 'index'])
                ->name('scheme_payments.index');

            // Delete single scheme payment
            Route::delete('/scheme-payments/{schemePayment}', [SchemePaymentController::class, 'destroy'])
                ->name('scheme_payments.destroy');

            // Export scheme payments (CSV / Excel)
            Route::get('/scheme-payments/export', [SchemePaymentController::class, 'export'])
                ->name('scheme_payments.export');

            // ✅ Generate Lucky Draw Coupons for early payments
            Route::get('/scheme-payments/generate-lucky-draw', [SchemePaymentController::class, 'generateLuckyDrawCoupons'])
                ->name('scheme_payments.generate_lucky_draw');
        });


        // Role Management (Admin only)
        Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
            Route::resource('roles', RoleController::class)->except(['show']);
        });

    });
});

Route::get('/payphi/checkout', [PayphiController::class, 'showCheckout'])->name('payphi.checkout');
Route::post('/payphi/initiate', [PayphiController::class, 'initiatePayment'])->name('payphi.initiate');
Route::post('/payphi/callback', [PayphiController::class, 'paymentCallback'])->name('payphi.callback');

Route::get('/payphi-debug', function () {
    return [
        'merchant' => env('PAYPHI_MERCHANT_ID', 'not found'),
        'aggregator' => env('PAYPHI_AGGREGATOR_ID', 'not found'),
        'hash' => env('PAYPHI_HASH_KEY', 'not found'),
        'sale_url' => env('PAYPHI_SALE_URL', 'not found')
    ];
});



// Default route redirect to admin dashboard
Route::get('/', function () {
    return redirect()->route('admin.login');
});


