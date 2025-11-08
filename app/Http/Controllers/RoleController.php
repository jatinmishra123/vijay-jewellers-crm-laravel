<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct()
    {
        // केवल Admin ही RoleController access कर सकता है
        $this->middleware(['auth', 'role:Admin']);
    }

    /**
     * List of roles
     */
    public function index()
    {
        $roles = Role::all();
        $user = auth()->user();

        $permissionOptions = $this->permissionOptions();

        return view('admin.roles.index', compact('roles', 'permissionOptions', 'user'));
    }

    /**
     * Show create role form
     */
    public function create()
    {
        $permissionOptions = $this->permissionOptions();
        $roleOptions = $this->roleOptions(false); // false = Admin exclude

        return view('admin.roles.create', compact('permissionOptions', 'roleOptions'));
    }

    /**
     * Store role
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $permissions = [];
        if ($request->has('permissions')) {
            foreach ($request->permissions as $key => $value) {
                if ($value === 'true' || $value === true) {
                    $permissions[$key] = true;
                }
            }
        }

        Role::create([
            'name' => $request->name,
            'permissions' => $permissions,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }


    /**
     * Show role details
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Edit role form
     */
    public function edit(Role $role)
    {
        $permissionOptions = $this->permissionOptions();
        $roleOptions = $this->roleOptions(false); // Admin ko dropdown me mat dikhana

        return view('admin.roles.edit', compact('role', 'permissionOptions', 'roleOptions'));
    }

    /**
     * Update role
     */
    public function update(Request $request, Role $role)
    {
        dd($request->method(), $request->all());

        $validator = Validator::make($request->all(), [
            'permissions' => 'nullable|array',
            'permissions.*' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $permissions = [];
        if ($request->has('permissions')) {
            foreach ($request->permissions as $key => $value) {
                if ($value === 'true' || $value === true) {
                    $permissions[$key] = true;
                }
            }
        }

        $role->update([
            'permissions' => $permissions,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }



    /**
     * Delete role
     */
    public function destroy(Role $role)
    {
        $defaultRoles = $this->roleOptions(true); // true = include Admin

        if (in_array($role->name, $defaultRoles)) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete default roles.');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete role. There are users assigned to this role.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }

    /**
     * Permission options
     */
    private function permissionOptions()
    {
        return [
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
    }

    /**
     * Role options
     * @param bool $includeAdmin
     * @return array
     */
    private function roleOptions($includeAdmin = false)
    {
        $roles = ['Admin', 'Manager', 'Executive', 'Accounts', 'Marketing'];

        if (!$includeAdmin) {
            // Admin ko list se hata do
            $roles = array_filter($roles, fn($r) => $r !== 'Admin');
        }

        return $roles;
    }
}
