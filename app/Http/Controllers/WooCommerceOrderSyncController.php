<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Scheme;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WooCommerceOrderSyncController extends Controller
{
    public function syncOrders()
    {
        $storeUrl = rtrim(config('services.woocommerce.url'), '/');
        $ck = config('services.woocommerce.key');
        $cs = config('services.woocommerce.secret');

        if (empty($storeUrl) || empty($ck) || empty($cs)) {
            return response()->json([
                'success' => false,
                'message' => '❌ WooCommerce API credentials missing in .env',
            ], 500);
        }

        $page = 1;
        $perPage = 50;
        $imported = 0;

        try {
            do {
                $endpoint = $storeUrl . "/wp-json/wc/v3/orders";
                $response = Http::withBasicAuth($ck, $cs)
                    ->timeout(120)
                    ->retry(3, 2000)
                    ->get($endpoint, [
                        'per_page' => $perPage,
                        'page' => $page,
                    ]);

                if ($response->failed()) {
                    Log::error("❌ WooCommerce API failed", [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    break;
                }

                $orders = $response->json();
                if (empty($orders))
                    break;

                foreach ($orders as $order) {
                    try {
                        Log::info("🛒 Processing Order", [
                            'order_id' => $order['id'],
                            'customer_id' => $order['customer_id'],
                            'status' => $order['status'],
                            'total' => $order['total'],
                        ]);

                        // --------------------
                        // 1. Scheme / Product Info
                        // --------------------
                        $schemeId = null;
                        $schemeName = null;
                        $schemeDuration = null;
                        $schemeAmount = null;

                        if (!empty($order['line_items'])) {
                            $firstItem = $order['line_items'][0];

                            $schemeName = $firstItem['name'] ?? null;
                            $schemeAmount = isset($firstItem['total'])
                                ? (float) $firstItem['total']
                                : (float) ($firstItem['price'] ?? 0);

                            // ✅ case-insensitive match
                            $scheme = Scheme::whereRaw('LOWER(name) = ?', [strtolower($schemeName)])->first();

                            if ($scheme) {
                                $schemeId = $scheme->id;
                                $schemeDuration = $scheme->duration;
                                $schemeAmount = $scheme->total_amount ?? $schemeAmount;
                            }
                        }

                        // --------------------
                        // 2. Save / Update Customer
                        // --------------------
                        $customerId = null;

                        // अगर customer_id missing है (guest order) तो भी save करो
                        $customerKey = !empty($order['customer_id']) ? $order['customer_id'] : 'guest-' . $order['id'];

                        $customer = Customer::updateOrCreate(
                            ['woo_id' => $customerKey],
                            [
                                'wp_id' => $order['id'],
                                'name' => trim(($order['billing']['first_name'] ?? '') . ' ' . ($order['billing']['last_name'] ?? '')),
                                'first_name' => $order['billing']['first_name'] ?? null,
                                'last_name' => $order['billing']['last_name'] ?? null,
                                'email' => $order['billing']['email'] ?? null,
                                'mobile' => $order['billing']['phone'] ?? null,
                                'address' => trim(($order['billing']['address_1'] ?? '') . ' ' . ($order['billing']['address_2'] ?? '')),
                                'role' => 'customer',
                                'is_active' => 1,
                                'registered_date' => !empty($order['date_created'])
                                    ? Carbon::parse($order['date_created'])
                                    : now(),
                                'verification_status' => 'pending',
                                'payment_status' => $order['status'],

                                // ✅ Always save scheme info
                                'scheme_id' => $schemeId,
                                'scheme' => $schemeName,
                                'scheme_duration' => $schemeDuration,
                                'scheme_total_amount' => $schemeAmount,
                            ]
                        );

                        $customerId = $customer->id;

                        Log::info("✅ Customer Saved/Updated with Scheme", [
                            'db_id' => $customerId,
                            'woo_id' => $order['customer_id'],
                            'scheme' => $schemeName,
                            'scheme_id' => $schemeId,
                            'duration' => $schemeDuration,
                            'amount' => $schemeAmount,
                        ]);

                        // --------------------
                        // 3. Save Sale Items
                        // --------------------
                        foreach ($order['line_items'] as $item) {
                            $payload = [
                                'product_type' => $item['variation_id'] ? 'variable' : 'simple',
                                'product_name' => $item['name'],
                                'amount' => (float) $item['total'],
                                'sale_date' => !empty($order['date_created']) ? Carbon::parse($order['date_created']) : now(),
                                'sale_type' => 'woocommerce',
                                'payment_status' => $order['status'],
                                'quantity' => (int) $item['quantity'],
                                'customer_id' => $customerId,
                            ];

                            Sale::updateOrCreate(
                                [
                                    'product_name' => $payload['product_name'],
                                    'sale_date' => $payload['sale_date'],
                                    'customer_id' => $payload['customer_id'],
                                ],
                                $payload
                            );

                            $imported++;
                        }

                    } catch (\Throwable $e) {
                        Log::error("❌ Failed to save Woo order", [
                            'error' => $e->getMessage(),
                            'order_id' => $order['id'] ?? null,
                        ]);
                    }
                }

                $page++;
            } while (count($orders) === $perPage);

            return response()->json([
                'success' => true,
                'imported' => $imported,
                'message' => "✅ Synced {$imported} WooCommerce order items successfully.",
            ]);

        } catch (\Throwable $e) {
            Log::error("❌ Woo sync exception", [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => '❌ Exception during Woo sync, check logs',
            ], 500);
        }
    }
}
