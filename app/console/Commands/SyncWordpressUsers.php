<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;

class SyncWordpressUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:sync-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync users from WordPress into local CRM customers table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🚀 Starting WordPress User Sync...");

        $page = 1;
        $totalImported = 0;

        try {
            do {
                $response = Http::withBasicAuth(env('WP_USER'), env('WP_APP_PASSWORD'))
                    ->get(env('WP_API_URL') . '/users', [
                        'per_page' => 20,
                        'page' => $page,
                        'context' => 'edit'
                    ]);

                if ($response->failed()) {
                    $this->error("❌ WordPress API request failed. Status: " . $response->status());
                    Log::error('WordPress API failed', [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    return Command::FAILURE;
                }

                $users = $response->json();
                if (empty($users)) {
                    break;
                }

                foreach ($users as $user) {
                    $customer = Customer::updateOrCreate(
                        ['wp_id' => $user['id']],
                        [
                            'username' => $user['slug'] ?? null,
                            'name' => $user['name'] ?? null,
                            'email' => $user['email'] ?? ($user['slug'] . '@dummy.local'),
                            'role' => $user['roles'][0] ?? null,
                            'is_active' => true,
                            'verification_status' => Customer::VERIFICATION_APPROVED,
                        ]
                    );

                    $this->line("✅ Synced user: {$customer->name} ({$customer->email})");
                    $totalImported++;
                }

                $page++;
            } while (true);

            $this->info("🎉 Sync completed! Total users imported/updated: $totalImported");

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("💥 Exception: " . $e->getMessage());
            Log::error('WordPress sync exception', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return Command::FAILURE;
        }
    }
}
