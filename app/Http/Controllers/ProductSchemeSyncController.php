<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Scheme;
use Carbon\Carbon;

class ProductSchemeSyncController extends Controller
{
    public function syncSchemes()
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

        try {
            $endpoint = $storeUrl . "/wp-json/wc/v3/products";
            $response = Http::withBasicAuth($ck, $cs)
                ->timeout(60)
                ->get($endpoint, ['per_page' => 50]);

            if ($response->failed()) {
                Log::error("❌ WooCommerce Products API failed", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'WooCommerce products fetch failed',
                    'status' => $response->status(),
                    'body' => $response->body(),
                ], 500);
            }

            $products = $response->json();
            $imported = 0;

            Log::info("📦 WooCommerce Products Fetched", [
                'count' => count($products),
                'sample' => $products[0] ?? 'no products',
            ]);

            foreach ($products as $product) {
                try {
                    // सिर्फ Scheme Product category वाले products
                    if (!empty($product['categories']) && collect($product['categories'])->pluck('name')->contains('Scheme Product')) {

                        Log::info("🛠 Saving Scheme Product", [
                            'id' => $product['id'],
                            'name' => $product['name'],
                            'price' => $product['price'] ?? null,
                            'status' => $product['status'] ?? null,
                        ]);

                        Scheme::updateOrCreate(
                            ['name' => $product['name']], // unique key
                            [
                                // Strip HTML from description so only plain text saves
                                'description' => strip_tags($product['description'] ?? ''),

                                'duration' => $this->extractDuration($product['price_html'] ?? ''),
                                'total_amount' => $product['price'] ?? 0,
                                'status' => $product['status'] ?? 'publish',
                                'updated_at' => Carbon::now(),
                            ]
                        );

                        $imported++;
                    }
                } catch (\Throwable $inner) {
                    Log::error("❌ Failed to save scheme product", [
                        'product' => $product['id'] ?? null,
                        'error' => $inner->getMessage(),
                        'line' => $inner->getLine(),
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'imported' => $imported,
                'message' => "✅ Synced {$imported} schemes from WooCommerce products",
            ]);
        } catch (\Throwable $e) {
            Log::error("❌ WooCommerce Scheme Sync Exception", [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    private function extractDuration($priceHtml)
    {
        // example: "₹3,000.00 / month for 9 months"
        if (preg_match('/for\s+(\d+)\s+months?/', $priceHtml, $matches)) {
            return (int) $matches[1];
        }
        return null;
    }
}
