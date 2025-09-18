<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\SchemeMember;
use App\Models\Scheme;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Check if user has a role assigned
        if (!$user->role) {
            auth()->logout();
            return redirect()->route('admin.login')
                ->with('error', 'Your account does not have a valid role assigned. Please contact administrator.');
        }

        $roles = Role::all(); // For Admin dashboard

        // Role-based dashboard
        if ($user->hasRole('Admin')) {
            return $this->adminDashboard($user, $roles);

        } elseif ($user->hasRole('Manager')) {
            return $this->managerDashboard($user);
        } elseif ($user->hasRole('Executive')) {
            return $this->executiveDashboard($user);
        } elseif ($user->hasRole('Accounts')) {
            return $this->accountsDashboard($user);
        } elseif ($user->hasRole('Marketing')) {
            return $this->marketingDashboard($user);
        }

        auth()->logout();
        return redirect()->route('admin.login')
            ->with('error', 'Your role does not have access to the dashboard.');
    }

    private function adminDashboard($user, $roles)
    {
        $stats = [
            'total_customers' => Customer::count(),
            'total_sales' => Sale::whereDate('sale_date', today())->sum('amount'),
            'new_members' => SchemeMember::whereDate('joined_date', today())->count(),
            'scheme_collection' => SchemeMember::whereDate('joined_date', today())
                ->sum(DB::raw('(SELECT total_amount FROM schemes WHERE schemes.id = scheme_members.scheme_id) / (SELECT duration FROM schemes WHERE schemes.id = scheme_members.scheme_id)')),
            'total_schemes' => Scheme::where('status', 'active')->count(),
            'total_payments' => SchemeMember::whereDate('joined_date', today())->count(),
            'profit' => Sale::whereDate('sale_date', today())->sum('amount') * 0.2
        ];

        return view('admin.dashboard', compact('user', 'stats', 'roles'));
    }

    private function managerDashboard($user)
    {
        $stats = [
            'total_customers' => Customer::count(),
            'total_sales' => Sale::whereDate('sale_date', today())->sum('amount'),
            'new_members' => SchemeMember::whereDate('joined_date', today())->count(),
            'total_schemes' => Scheme::where('status', 'active')->count(),
        ];

        return view('admin.dashboard', compact('user', 'stats'));
    }

    private function executiveDashboard($user)
    {
        $stats = [
            'my_customers' => Customer::where('agent_id', $user->id)->count(),
        ];

        return view('admin.dashboard', compact('user', 'stats'));
    }

    private function accountsDashboard($user)
    {
        $stats = [
            'total_sales' => Sale::whereDate('sale_date', today())->sum('amount'),
            'scheme_collection' => SchemeMember::whereDate('joined_date', today())
                ->sum(DB::raw('(SELECT total_amount FROM schemes WHERE schemes.id = scheme_members.scheme_id) / (SELECT duration FROM schemes WHERE schemes.id = scheme_members.scheme_id)')),
            'total_payments' => SchemeMember::whereDate('joined_date', today())->count(),
        ];

        return view('admin.dashboard', compact('user', 'stats'));
    }

    private function marketingDashboard($user)
    {
        $stats = [
            'total_customers' => Customer::count(),
        ];

        return view('admin.dashboard', compact('user', 'stats'));
    }
}
