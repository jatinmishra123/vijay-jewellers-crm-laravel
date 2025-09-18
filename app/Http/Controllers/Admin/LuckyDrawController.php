<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LuckyDraw;
use Illuminate\Http\Request;
use App\Exports\LuckyDrawExport;
use Maatwebsite\Excel\Facades\Excel;

class LuckyDrawController extends Controller
{
    public function index(Request $request)
    {
        $query = LuckyDraw::with(['customer', 'scheme', 'schemePayment']);

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('coupon_code', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Apply reward status filter
        if ($request->has('reward_status') && !empty($request->reward_status)) {
            $query->where('reward_status', $request->reward_status);
        }

        $luckyDraws = $query->latest()->paginate(10);

        // Get summary counts (using a separate query to avoid pagination issues)
        $summaryQuery = LuckyDraw::query();
        $summary = [
            'total' => $summaryQuery->count(),
            'pending' => $summaryQuery->clone()->where('status', 'pending')->count(),
            'used' => $summaryQuery->clone()->where('status', 'used')->count(),
            'cancelled' => $summaryQuery->clone()->where('status', 'cancelled')->count(),
            'reward_pending' => $summaryQuery->clone()->where('reward_status', 'pending')->count(),
            'reward_sent' => $summaryQuery->clone()->where('reward_status', 'sent')->count(),
        ];

        return view('admin.lucky_draws.index', compact('luckyDraws', 'summary'));
    }

    public function destroy(LuckyDraw $luckyDraw)
    {
        $luckyDraw->delete();

        return redirect()->route('admin.lucky_draws.index')
            ->with('success', 'Lucky Draw coupon deleted successfully.');
    }

    public function addReward(Request $request, $id)
    {
        $request->validate([
            'reward_type' => 'required|string|max:50',
            'reward_value' => 'required|string|max:255',
            'reward_message' => 'required|string',
        ]);

        $luckyDraw = LuckyDraw::findOrFail($id);

        $luckyDraw->update([
            'reward_type' => $request->reward_type,
            'reward_value' => $request->reward_value,
            'reward_message' => $request->reward_message,
            'reward_status' => 'sent',
            'rewarded_at' => now(),
        ]);

        // Here you would typically integrate with your SMS gateway
        $this->sendRewardSMS($luckyDraw);

        return response()->json([
            'success' => true,
            'message' => 'Reward added and SMS sent successfully!'
        ]);
    }

    private function sendRewardSMS(LuckyDraw $luckyDraw)
    {
        // Implement your SMS gateway integration here
        // This is a placeholder for actual SMS sending logic

        $customerPhone = optional($luckyDraw->customer)->phone;
        $message = $luckyDraw->reward_message;

        if ($customerPhone) {
            // Example: Integration with Twilio, Nexmo, or your SMS provider
            // SMS::send($customerPhone, $message);

            // Log the SMS sending (you might want to create a separate table for SMS logs)
            \Log::info("SMS sent to {$customerPhone}: {$message}");
        }

        return true;
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'excel');
        $fileName = 'lucky_draws_' . date('Y_m_d_H_i_s');

        if ($type === 'csv') {
            return Excel::download(new LuckyDrawExport, $fileName . '.csv');
        }
        return Excel::download(new LuckyDrawExport, $fileName . '.xlsx');
    }
}