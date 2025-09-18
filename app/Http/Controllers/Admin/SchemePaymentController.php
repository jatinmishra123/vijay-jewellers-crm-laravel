<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchemePayment;
use App\Models\LuckyDraw;
use Illuminate\Http\Request;
use App\Exports\SchemePaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class SchemePaymentController extends Controller
{
    // List all scheme payments with summary cards
    public function index()
    {
        $schemePayments = SchemePayment::with(['customer', 'scheme'])->latest()->get();

        $summary = [
            'total' => $schemePayments->count(),
            'successful' => $schemePayments->where('status', 'success')->count(),
            'failed' => $schemePayments->where('status', 'failed')->count(),
            'pending' => $schemePayments->where('status', 'pending')->count(),
        ];

        return view('admin.scheme_payments.index', compact('schemePayments', 'summary'));
    }

    // Delete single record (admin action)
    public function destroy(SchemePayment $schemePayment)
    {
        $schemePayment->delete();

        return redirect()->route('admin.scheme_payments.index')
            ->with('success', 'Payment record deleted successfully.');
    }

    // Export CSV / Excel
    public function export(Request $request)
    {
        $type = $request->get('type', 'excel');
        $fileName = 'scheme_payments_' . date('Y_m_d_H_i_s');

        if ($type === 'csv') {
            return Excel::download(new SchemePaymentsExport, $fileName . '.csv');
        }

        return Excel::download(new SchemePaymentsExport, $fileName . '.xlsx');
    }

    // ✅ Generate Lucky Draw Coupons for early payments
    public function generateLuckyDrawCoupons()
    {
        $payments = SchemePayment::where('status', 'success')
            ->whereRaw('DATEDIFF(due_date, paid_at) >= 10') // paid 10+ days before due date
            ->get();

        foreach ($payments as $payment) {
            // Skip if coupon already exists
            if (LuckyDraw::where('scheme_payment_id', $payment->id)->exists()) {
                continue;
            }

            LuckyDraw::create([
                'customer_id' => $payment->customer_id,
                'scheme_id' => $payment->scheme_id,
                'scheme_payment_id' => $payment->id,
                'coupon_code' => 'LD-' . Str::upper(Str::random(8)),
                'lucky_draw_amount' => 100, // Example amount
                'status' => 'pending'
            ]);
        }

        return redirect()->back()->with('success', 'Lucky Draw coupons generated successfully.');
    }
}
