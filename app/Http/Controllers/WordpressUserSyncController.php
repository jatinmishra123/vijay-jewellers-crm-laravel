<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class WordpressUserSyncController extends Controller
{
    public function syncUsers(Request $request)
    {
        $page = 1;
        $perPage = 100;   // WP max = 100
        $maxPages = 50;   // safety limit
        $totalImported = 0;

        try {
            // ✅ Fetch credentials from .env
            $wpUrl = rtrim(config('services.wp.api_url'), '/');
            $wpUser = config('services.wp.username');
            $wpPass = config('services.wp.app_password');

            Log::info('🔑 WP Credentials Loaded', [
                'url' => $wpUrl,
                'user' => $wpUser,
                'pass' => $wpPass ? '****' : null,
            ]);

            if (empty($wpUrl) || empty($wpUser) || empty($wpPass)) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ WordPress API credentials missing in .env',
                ], 500);
            }

            do {
                $endpoint = $wpUrl . '/users';

                $response = Http::withBasicAuth($wpUser, $wpPass)->get($endpoint, [
                    'per_page' => $perPage,
                    'page' => $page,
                    'context' => 'edit',
                ]);

                if ($response->failed()) {
                    Log::error('❌ WP API request failed', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'page' => $page,
                    ]);
                    break;
                }

                $users = $response->json();

                Log::info("✅ WP API Response Page {$page}", [
                    'count' => is_array($users) ? count($users) : 0
                ]);

                if (empty($users) || !is_array($users)) {
                    break;
                }

                foreach ($users as $user) {
                    try {
                        $email = $user['email'] ?? null;

                        if (empty($email)) {
                            $email = ($user['slug'] ?? 'user') . '+' . $user['id'] . '@dummy.local';
                        }

                        // ✅ Find if user already exists
                        $existingCustomer = Customer::where('wp_id', $user['id'])->first();

                        $payload = [
                            'wp_id' => $user['id'],
                            'username' => $user['username'] ?? ($user['slug'] ?? null),
                            'name' => $user['name'] ?? ($user['slug'] ?? 'Unknown'),
                            'first_name' => $user['first_name'] ?? null,
                            'last_name' => $user['last_name'] ?? null,
                            'email' => $email,
                            'role' => $user['roles'][0] ?? 'customer',
                            'is_active' => true,
                            'verification_status' => Customer::VERIFICATION_APPROVED,
                            'created_at' => $user['registered_date'] ?? now(),
                        ];

                        // ✅ If new user, add random mtoken
                        if (!$existingCustomer) {
                            $payload['mtoken'] = Str::random(32);
                        }

                        Log::info("📌 Saving WP User", ['wp_id' => $payload['wp_id']]);

                        Customer::updateOrCreate(
                            ['wp_id' => $payload['wp_id']],
                            $payload
                        );

                        $totalImported++;

                        Log::info("✅ User Saved", ['wp_id' => $payload['wp_id']]);

                    } catch (\Throwable $e) {
                        Log::error('❌ Failed to save WP user', [
                            'error' => $e->getMessage(),
                            'user' => $user,
                        ]);
                    }
                }

                $page++;

                if ($page > $maxPages) {
                    Log::warning("⚠️ Stopped syncing because maxPages={$maxPages} reached");
                    break;
                }

            } while (true);

            return response()->json([
                'success' => true,
                'imported' => $totalImported,
                'message' => "✅ Synced {$totalImported} WordPress users successfully.",
            ]);

        } catch (\Throwable $e) {
            Log::error('❌ WP sync exception', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => '❌ Exception during sync, check logs',
            ], 500);
        }
    }
}
