<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SchemeMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin|Manager|Accounts']);
    }

    public function salesReport(Request $request)
    {
        $date = $request->date ?? today()->format('Y-m-d');

        $totalSales = Sale::whereDate('sale_date', $date)->sum('amount');

        $productWiseSales = Sale::whereDate('sale_date', $date)
            ->select('product_type', DB::raw('SUM(amount) as total_sales'))
            ->groupBy('product_type')
            ->get();

        $topProducts = Sale::whereDate('sale_date', $date)
            ->select('product_name', DB::raw('SUM(amount) as total_sales'))
            ->groupBy('product_name')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();

        return view('reports.sales', compact('totalSales', 'productWiseSales', 'topProducts', 'date'));
    }

    public function schemeReport(Request $request)
    {
        $date = $request->date ?? today()->format('Y-m-d');

        // नए members count
        $newMembers = SchemeMember::whereDate('joined_date', $date)->count();

        // total collection (schemes join करके)
        $totalCollection = DB::table('scheme_members')
            ->join('schemes', 'scheme_members.scheme_id', '=', 'schemes.id')
            ->whereDate('scheme_members.joined_date', $date)
            ->sum(DB::raw('schemes.total_amount / schemes.duration'));

        return view('reports.schemes', compact('newMembers', 'totalCollection', 'date'));
    }

}