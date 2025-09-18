<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::all();
        $user = auth()->user();

        // Define permission options for forms
        $permissionOptions = [
            'manage_users' => 'Manage Users',
            'manage_roles' => 'Manage Roles',
            'view_all_customers' => 'View All Customers',
            'view_all_schemes' => 'View All Schemes',
            'manage_coupons' => 'Manage Coupons',
            'view_reports' => 'View Reports',
            'delete_records' => 'Delete Records',
            'modify_records' => 'Modify Records',
            'add_customers' => 'Add Customers',
            'view_own_customers' => 'View Own Customers',
            'generate_tokens' => 'Generate Tokens',
            'view_schemes' => 'View Schemes',
            'view_payments' => 'View Payments',
            'view_invoices' => 'View Invoices',
            'send_promotions' => 'Send Promotions',
            'send_lucky_draws' => 'Send Lucky Draws',
            'approve_coupons' => 'Approve Coupons',
            'approve_schemes' => 'Approve Schemes'
        ];

        return view('admin.roles.index', compact('roles', 'permissionOptions', 'user'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissionOptions = [
            'manage_users' => 'Manage Users',
            'manage_roles' => 'Manage Roles',
            'view_all_customers' => 'View All Customers',
            'view_all_schemes' => 'View All Schemes',
            'manage_coupons' => 'Manage Coupons',
            'view_reports' => 'View Reports',
            'delete_records' => 'Delete Records',
            'modify_records' => 'Modify Records',
            'add_customers' => 'Add Customers',
            'view_own_customers' => 'View Own Customers',
            'generate_tokens' => 'Generate Tokens',
            'view_schemes' => 'View Schemes',
            'view_payments' => 'View Payments',
            'view_invoices' => 'View Invoices',
            'send_promotions' => 'Send Promotions',
            'send_lucky_draws' => 'Send Lucky Draws',
            'approve_coupons' => 'Approve Coupons',
            'approve_schemes' => 'Approve Schemes'
        ];

        return view('admin.roles.create', compact('permissionOptions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare permissions array
        $permissions = [];
        foreach ($request->permissions as $key => $value) {
            if ($value === 'true' || $value === true) {
                $permissions[$key] = true;
            }
        }

        Role::create([
            'name' => $request->name,
            'permissions' => $permissions,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $permissionOptions = [
            'manage_users' => 'Manage Users',
            'manage_roles' => 'Manage Roles',
            'view_all_customers' => 'View All Customers',
            'view_all_schemes' => 'View All Schemes',
            'manage_coupons' => 'Manage Coupons',
            'view_reports' => 'View Reports',
            'delete_records' => 'Delete Records',
            'modify_records' => 'Modify Records',
            'add_customers' => 'Add Customers',
            'view_own_customers' => 'View Own Customers',
            'generate_tokens' => 'Generate Tokens',
            'view_schemes' => 'View Schemes',
            'view_payments' => 'View Payments',
            'view_invoices' => 'View Invoices',
            'send_promotions' => 'Send Promotions',
            'send_lucky_draws' => 'Send Lucky Draws',
            'approve_coupons' => 'Approve Coupons',
            'approve_schemes' => 'Approve Schemes'
        ];

        return view('admin.roles.edit', compact('role', 'permissionOptions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
            'permissions.*' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare permissions array
        $permissions = [];
        foreach ($request->permissions as $key => $value) {
            if ($value === 'true' || $value === true) {
                $permissions[$key] = true;
            }
        }

        $role->update([
            'name' => $request->name,
            'permissions' => $permissions,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        // Prevent deletion of default roles
        $defaultRoles = ['Admin', 'Manager', 'Executive', 'Accounts', 'Marketing'];
        if (in_array($role->name, $defaultRoles)) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete default roles.');
        }

        // Check if any users are assigned to this role
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete role. There are users assigned to this role.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}