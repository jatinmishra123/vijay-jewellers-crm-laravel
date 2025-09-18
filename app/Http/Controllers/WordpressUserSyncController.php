<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Customer;

class WordpressUserSyncController extends Controller
{
    public function syncUsers()
    {
        $page = 1;
        $totalImported = 0;

        do {
            // WordPress API request
            $response = Http::withBasicAuth(env('WP_USER'), env('WP_APP_PASSWORD'))
                ->get(env('WP_API_URL') . '/users', [
                    'per_page' => 10,
                    'page' => $page
                ]);

            if ($response->failed()) {
                // Agar API fail ho jaaye to log kar lo, debug ke liye
                // dd($response->status(), $response->body());
                return response()->json(['success' => false], 500);
            }

            $users = $response->json();

            foreach ($users as $user) {
                Customer::updateOrCreate(
                    ['email' => $user['email'] ?? $user['slug'] . "@dummy.local"], // email missing hone par dummy
                    [
                        'username' => $user['slug'],
                        'name' => $user['name'],
                        'email' => $user['email'] ?? $user['slug'] . "@dummy.local",
                        'role' => $user['roles'][0] ?? null,
                    ]
                );
                $totalImported++;
            }

            $page++;
        } while (!empty($users));

        // ✅ Sync complete, koi message frontend me nahi bhejna
        return response()->json(['success' => true]);
        // agar aap chaho to sirf HTTP 200 bhi return kar sakte ho: return response()->noContent();
    }
}
