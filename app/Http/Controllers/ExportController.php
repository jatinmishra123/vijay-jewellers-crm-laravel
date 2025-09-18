<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CustomersExport;
use App\Exports\SalesExport;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Payment;
use Carbon\Carbon;

class ExportController extends Controller
{
    // Show Dashboard
    public function dashboard()
    {
        $today = \Carbon\Carbon::today();

        $todayCustomers = \App\Models\Customer::whereDate('created_at', $today)->count();
        $todaySales = \App\Models\Sale::whereDate('sale_date', $today)->sum('amount');
        $todayPayments = \App\Models\Payment::whereDate('payment_date', $today)->sum('amount');

        return view('admin.exports.dashboard', compact(
            'todayCustomers',
            'todaySales',
            'todayPayments'
        ));
    }


    // Download PDF Report
    public function downloadPdf($type)
    {
        if ($type === 'customers') {
            $customers = Customer::with('sales')
                ->orderBy('created_at', 'desc')
                ->get();

            $stats = [
                'today_new' => Customer::whereDate('created_at', today())->count(),
                'active_count' => Customer::where('is_active', 1)->count(),
                'inactive_pending_count' => Customer::where(function ($q) {
                    $q->where('is_active', 0)
                        ->orWhere('verification_status', 'pending');
                })->count(),
            ];

            $data = [
                'customers' => $customers,
                'stats' => $stats,
            ];

            return PDF::loadView('admin.exports.customers-pdf', $data)
                ->download('customers-report-' . \Carbon\Carbon::today()->format('Y-m-d') . '.pdf');
        }

        // For other types (sales/payments) you can keep your existing logic
        $data = $this->getExportData($type);
        return PDF::loadView('admin.exports.pdf.' . $type, $data)
            ->download($type . '-report-' . \Carbon\Carbon::today()->format('Y-m-d') . '.pdf');
    }




    // Download Excel Report
    public function downloadExcel($type)
    {
        $exportClass = $this->getExportClass($type);
        return Excel::download(new $exportClass, $type . '-report-' . Carbon::today()->format('Y-m-d') . '.xlsx');
    }

    // Download CSV Report
    public function downloadCsv($type)
    {
        $exportClass = $this->getExportClass($type);
        return Excel::download(new $exportClass, $type . '-report-' . Carbon::today()->format('Y-m-d') . '.csv');
    }

    // Send Email Report
    public function sendEmailReport($type)
    {
        $data = $this->getExportData($type);
        $pdf = PDF::loadView('admin.exports.pdf.' . $type, $data);

        \Mail::send('emails.daily-report', $data, function ($message) use ($pdf, $type) {
            $message->to(config('mail.admin_email'))
                ->subject('Daily ' . ucfirst($type) . ' Report - ' . Carbon::today()->format('M j, Y'))
                ->attachData($pdf->output(), $type . '-report-' . Carbon::today()->format('Y-m-d') . '.pdf');
        });

        return response()->json(['success' => true, 'message' => 'Email report sent successfully']);
    }

    // Send WhatsApp Report
    public function sendWhatsAppReport($type)
    {
        $data = $this->getExportData($type);
        $message = $this->generateWhatsAppMessage($type, $data);

        $this->sendWhatsApp(config('services.twilio.admin_number'), $message);

        return response()->json(['success' => true, 'message' => 'WhatsApp report sent successfully']);
    }

    // Get export data based on type
    private function getExportData($type)
    {
        $today = Carbon::today();

        switch ($type) {
            case 'customers':
                return [
                    'customers' => Customer::with('sales')->whereDate('created_at', $today)->get(),
                    'total_today' => Customer::whereDate('created_at', $today)->count(),
                    'total_active' => Customer::where('is_active', 'active')->count(),
                    'type' => 'customers'
                ];

            case 'sales':
                return [
                    'sales' => Sale::with('customer')->whereDate('sale_date', $today)->get(),
                    'total_today' => Sale::whereDate('sale_date', $today)->count(),
                    'total_amount' => Sale::whereDate('sale_date', $today)->sum('amount'),
                    'type' => 'sales'
                ];

            case 'payments':
                return [
                    'payments' => Payment::with(['customer', 'sale'])->whereDate('payment_date', $today)->get(),
                    'total_today' => Payment::whereDate('payment_date', $today)->count(),
                    'total_collected' => Payment::whereDate('payment_date', $today)->sum('amount'),
                    'type' => 'payments'
                ];

            default:
                return [];
        }
    }

    // Get export class based on type
    private function getExportClass($type)
    {
        $classes = [
            'customers' => CustomersExport::class,
            'sales' => SalesExport::class,
            'payments' => PaymentsExport::class,
        ];

        return $classes[$type] ?? CustomersExport::class;
    }

    // Generate WhatsApp message
    private function generateWhatsAppMessage($type, $data)
    {
        $message = "📊 *Daily " . ucfirst($type) . " Report*\n";
        $message .= "📅 " . Carbon::today()->format('M j, Y') . "\n\n";

        switch ($type) {
            case 'customers':
                $message .= "👥 New Customers: " . $data['total_today'] . "\n";
                $message .= "✅ Active Customers: " . $data['total_active'] . "\n";
                break;

            case 'sales':
                $message .= "🛍️ Total Sales: " . $data['total_today'] . "\n";
                $message .= "💰 Total Amount: ₹" . number_format($data['total_amount'], 2) . "\n";
                break;

            case 'payments':
                $message .= "💳 Payments Received: " . $data['total_today'] . "\n";
                $message .= "💰 Amount Collected: ₹" . number_format($data['total_collected'], 2) . "\n";
                break;
        }

        $message .= "\nView detailed report: " . url('/admin/exports/dashboard');

        return $message;
    }

    // Send WhatsApp message
    private function sendWhatsApp($to, $message)
    {
        try {
            $twilio = new \Twilio\Rest\Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $twilio->messages->create(
                "whatsapp:" . $to,
                [
                    "from" => "whatsapp:" . config('services.twilio.from'),
                    "body" => $message
                ]
            );

            return true;
        } catch (\Exception $e) {
            \Log::error('WhatsApp message failed: ' . $e->getMessage());
            return false;
        }
    }
}
