<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin|Accounts']);
    }

    /**
     * List all sales with optional search and AJAX support
     */
    public function index(Request $request)
    {
        $query = Sale::query();

        // Search by product name or type
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                    ->orWhere('product_type', 'like', "%{$search}%");
            });
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get today's date
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Calculate daily sales statistics
        $dailySales = $this->getDailySales($today);
        $yesterdaySales = $this->getDailySales($yesterday);

        // Calculate product-wise sales
        $productWiseSales = $this->getProductWiseSales($today);

        // Get top selling products
        $topSellingProducts = $this->getTopSellingProducts($today);

        // Calculate percentage changes
        $percentageChanges = [
            'total_sales' => $this->calculatePercentageChange($dailySales->total_sales ?? 0, $yesterdaySales->total_sales ?? 0),
            'online_sales' => $this->calculatePercentageChange($dailySales->online_sales ?? 0, $yesterdaySales->online_sales ?? 0),
            'offline_sales' => $this->calculatePercentageChange($dailySales->offline_sales ?? 0, $yesterdaySales->offline_sales ?? 0),
            'avg_order_value' => $this->calculatePercentageChange($dailySales->avg_order_value ?? 0, $yesterdaySales->avg_order_value ?? 0),
        ];

        // If AJAX request, return partial table only
        if ($request->ajax()) {
            return view('admin.sales.partials.table', compact('sales'))->render();
        }

        return view('admin.sales.index', compact(
            'sales',
            'dailySales',
            'yesterdaySales',
            'productWiseSales',
            'topSellingProducts',
            'percentageChanges'
        ));
    }

    /**
     * Get daily sales statistics
     */
    private function getDailySales($date)
    {
        return Sale::whereDate('sale_date', $date)
            ->select(
                DB::raw('COALESCE(SUM(amount), 0) as total_sales'),
                DB::raw('COALESCE(SUM(CASE WHEN sale_type = "online" THEN amount ELSE 0 END), 0) as online_sales'),
                DB::raw('COALESCE(SUM(CASE WHEN sale_type = "offline" THEN amount ELSE 0 END), 0) as offline_sales'),
                DB::raw('COALESCE(COUNT(*), 0) as total_orders'),
                DB::raw('COALESCE(AVG(amount), 0) as avg_order_value')
            )
            ->first();
    }

    /**
     * Get product-wise sales breakdown
     */
    private function getProductWiseSales($date)
    {
        return Sale::whereDate('sale_date', $date)
            ->select(
                'product_type',
                DB::raw('COALESCE(SUM(amount), 0) as total_amount'),
                DB::raw('COALESCE(COUNT(*), 0) as total_sales')
            )
            ->groupBy('product_type')
            ->get();
    }

    /**
     * Get top selling products
     */
    private function getTopSellingProducts($date, $limit = 5)
    {
        return Sale::whereDate('sale_date', $date)
            ->select(
                'product_name',
                'product_type',
                DB::raw('COALESCE(AVG(amount), 0) as avg_price'),
                DB::raw('COALESCE(SUM(quantity), 0) as total_quantity'),
                DB::raw('COALESCE(SUM(amount), 0) as total_amount')
            )
            ->groupBy('product_name', 'product_type')
            ->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Calculate percentage change
     */
    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    /**
     * Delete a sale
     */
    public function destroy(Request $request, $id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            $message = 'Sale record not found.';
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => $message]);
            return redirect()->route('admin.sales.index')->with('error', $message);
        }

        try {
            $sale->delete();
            $message = 'Sale record deleted successfully.';
            if ($request->ajax())
                return response()->json(['success' => true, 'message' => $message]);
            return redirect()->route('admin.sales.index')->with('success', $message);
        } catch (\Exception $e) {
            $message = 'Failed to delete sale.';
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => $message]);
            return redirect()->back()->with('error', $message);
        }
    }
}