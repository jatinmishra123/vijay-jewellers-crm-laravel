<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordpressUserSyncController;
use App\Http\Controllers\WooCommerceOrderSyncController;
use App\Http\Controllers\ProductSchemeSyncController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 🔹 Public test route (API health check)
Route::get('/test', fn() => response()->json(['message' => 'API working fine ✅']));
Route::get('/sync-schemes', [ProductSchemeSyncController::class, 'syncSchemes']);

// =======================
// 📌 TEMP Public Routes for Testing (⚠️ no auth)
// =======================
// ⚠️ Sirf testing ke liye use karo, confirm hone ke baad hata dena
Route::get('/wp-sync-test', [WordpressUserSyncController::class, 'syncUsers']);
Route::get('/wc-sync-test', [WooCommerceOrderSyncController::class, 'syncOrders']);

// =======================
// 📌 Admin-only routes (auth required)
// =======================
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {

    // =======================
    // 📌 WordPress Integration
    // =======================
    Route::prefix('wordpress')->name('admin.wordpress.')->group(function () {
        // ✅ WordPress users sync (CRM customers table me save hoga)
        Route::post('/sync-users', [WordpressUserSyncController::class, 'syncUsers'])
            ->name('sync.users');

        // ✅ WooCommerce Orders Sync (use GET for import/read)
        Route::get('/sync-orders', [WooCommerceOrderSyncController::class, 'syncOrders'])
            ->name('sync.orders');
    });

    // =======================
    // 📌 WooCommerce Integration (future)
    // =======================
});

// =======================
// 📌 Debug route for WooCommerce ENV check
// =======================
Route::get('/wc-test-env', function () {
    return response()->json([
        'store_url' => config('services.woocommerce.url'),
        'consumer_key' => config('services.woocommerce.key') ? 'SET ✅' : 'MISSING ❌',
        'consumer_secret' => config('services.woocommerce.secret') ? 'SET ✅' : 'MISSING ❌',
    ]);
});
