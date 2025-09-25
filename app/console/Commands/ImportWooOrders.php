<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Sale;
use Illuminate\Support\Facades\Log;

class ImportWooOrders extends Command
{
    protected $signature = 'woo:import {--status=}';
    protected $description = 'Import WooCommerce orders into sales table';

    public function handle()
    {
        $status = $this->option('status'); // optional: completed, processing etc.
        $page = 1;
        $perPage = 100;
        $totalImported = 0;

        $this->info('Starting WooCommerce import...');

        do {
            $orders = $this->fetchOrders($page, $perPage, $status);

            if (empty($orders)) {
                break;
            }

            foreach ($orders as $order) {
                try {
                    $this->saveOrder($order);
                    $totalImported++;
                } catch (\Throwable $e) {
                    $this->error("Failed to save order {$order['id']}: " . $e->getMessage());
                    Log::error('Woo import saveOrder error', ['order' => $order, 'error' => $e->getMessage()]);
                }
            }

            $page++;
        } while (count($orders) === $perPage);

        $this->info("Import finished. Total processed: {$totalImported}");
    }

    private function fetchOrders($page = 1, $perPage = 100, $status = null)
    {
        $query = ['per_page' => $perPage, 'page' => $page];
        if ($status)
            $query['status'] = $status;

        $response = Http::withBasicAuth(
            config('services.woocommerce.key'),
            config('services.woocommerce.secret')
        )
            ->timeout(60)
            ->retry(2, 1000)
            ->get(rtrim(config('services.woocommerce.url'), '/') . '/wp-json/wc/v3/orders', $query);

        if ($response->failed()) {
            $body = $response->body();
            $status = $response->status();
            $this->error("WooCommerce API error ({$status}): " . substr($body, 0, 300));
            Log::error('Woo fetchOrders failed', ['status' => $status, 'body' => $body]);
            return [];
        }

        return $response->json() ?: [];
    }

    private function saveOrder(array $order)
    {
        $billing = $order['billing'] ?? [];
        $items = array_map(function ($it) {
            return [
                'product_id' => $it['product_id'] ?? null,
                'name' => $it['name'] ?? null,
                'qty' => $it['quantity'] ?? 0,
                'subtotal' => $it['subtotal'] ?? '0.00',
                'total' => $it['total'] ?? '0.00',
            ];
        }, $order['line_items'] ?? []);

        Sale::updateOrCreate(
            ['wp_order_id' => $order['id']],
            [
                'order_number' => $order['number'] ?? $order['id'],
                'status' => $order['status'] ?? null,
                'customer_name' => trim(($billing['first_name'] ?? '') . ' ' . ($billing['last_name'] ?? '')),
                'customer_email' => $billing['email'] ?? null,
                'total' => $order['total'] ?? 0,
                'currency' => $order['currency'] ?? null,
                'items' => $items,
                'billing' => $billing,
                'shipping' => $order['shipping'] ?? [],
            ]
        );
    }
}
