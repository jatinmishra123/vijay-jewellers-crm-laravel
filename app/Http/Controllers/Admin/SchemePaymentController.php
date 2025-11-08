<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchemePayment;
use App\Models\LuckyDraw;
use App\Models\Customer;
use App\Models\Scheme;
use Illuminate\Http\Request;
use App\Exports\SchemePaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class SchemePaymentController extends Controller
{
    // List all scheme payments with summary cards
    public function index()
    {
        $schemePayments = SchemePayment::with(['customer', 'scheme'])->latest()->paginate(10);

        $summary = [
            'total'       => SchemePayment::count(),
            'successful'  => SchemePayment::where('status', 'success')->count(),
            'failed'      => SchemePayment::where('status', 'failed')->count(),
            'pending'     => SchemePayment::where('status', 'pending')->count(),
        ];

        return view('admin.scheme_payments.index', compact('schemePayments', 'summary'));
    }


    public function create()
{
    $customers = Customer::select('id', 'name')->orderBy('name')->get();
    $schemes = Scheme::select('id', 'name')->orderBy('name')->get();

    return view('admin.scheme_payments.create', compact('customers', 'schemes'));
}



    // ✅ Store New Payment Record
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'       => 'required|exists:customers,id',
            'scheme_id'         => 'required|exists:schemes,id',
            'amount'            => 'required|numeric',
            'payment_duration'  => 'required|string',
            'status'            => 'required|in:pending,success,failed',
            'method'            => 'nullable|string',
            'notes'             => 'nullable|string',
            'due_date'          => 'required|date',
            'paid_at'           => 'nullable|date'
        ]);

        SchemePayment::create([
            'customer_id'       => $request->customer_id,
            'scheme_id'         => $request->scheme_id,
            'amount'            => $request->amount,
            'payment_duration'  => $request->payment_duration,
            'status'            => $request->status,
            'method'            => $request->method,
            'notes'             => $request->notes,
            'due_date'          => $request->due_date,
            'paid_at'           => $request->paid_at,
        ]);

        return redirect()->route('admin.scheme_payments.index')
            ->with('success', 'Payment added successfully.');
    }


    // Delete single record
    public function destroy(SchemePayment $schemePayment)
    {
        $schemePayment->delete();

        return redirect()->route('admin.scheme_payments.index')
            ->with('success', 'Payment record deleted successfully.');
    }


    // Export Excel / CSV
    public function export(Request $request)
    {
        $type = $request->get('type', 'excel');
        $fileName = 'scheme_payments_' . date('Y_m_d_H_i_s');

        if ($type === 'csv') {
            return Excel::download(new SchemePaymentsExport, $fileName . '.csv');
        }

        return Excel::download(new SchemePaymentsExport, $fileName . '.xlsx');
    }


    // ✅ Generate Lucky Draw Coupons
    public function generateLuckyDrawCoupons()
    {
        $payments = SchemePayment::where('status', 'success')
            ->whereRaw('DATEDIFF(due_date, paid_at) >= 10')
            ->get();

        foreach ($payments as $payment) {

            if (LuckyDraw::where('scheme_payment_id', $payment->id)->exists()) {
                continue;
            }

            LuckyDraw::create([
                'customer_id'         => $payment->customer_id,
                'scheme_id'           => $payment->scheme_id,
                'scheme_payment_id'   => $payment->id,
                'coupon_code'         => 'LD-' . Str::upper(Str::random(8)),
                'lucky_draw_amount'   => 100,
                'status'              => 'pending'
            ]);
        }

        return redirect()->back()->with('success', 'Lucky Draw coupons generated successfully.');
    }
}
