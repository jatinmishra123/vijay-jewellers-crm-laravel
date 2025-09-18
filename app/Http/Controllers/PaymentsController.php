<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['customer', 'sale'])
            ->orderBy('payment_date', 'desc')
            ->get();

        $todayPayments = $payments->where('payment_date', now()->format('Y-m-d'));

        $summary = [
            'total_today' => $todayPayments->count(),
            'successful' => $todayPayments->where('status', 'Successful')->count(),
            'failed' => $todayPayments->where('status', 'Failed')->count(),
            'pending' => $todayPayments->where('status', 'Pending')->count(),
            'by_method' => $todayPayments->groupBy('method')->map->count()->toArray(), // <-- fix here
        ];

        return view('payments.index', compact('payments', 'summary'));
    }


    public function export($type)
    {
        $fileName = 'payments_' . date('Ymd_His') . '.' . $type;

        if ($type == 'csv') {
            return Excel::download(new PaymentsExport, $fileName, \Maatwebsite\Excel\Excel::CSV);
        } else if ($type == 'excel') {
            return Excel::download(new PaymentsExport, $fileName, \Maatwebsite\Excel\Excel::XLSX);
        }
    }
}
