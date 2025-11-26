<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manage;
use App\Models\Scheme;
use App\Models\SchemeSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;   // <-- IMPORTANT

class ManageController extends Controller
{
    protected $rules = [
        'kij' => 'nullable|string|max:255',
        'mobile_number' => 'nullable|string|max:15',
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'father_name' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'city_village' => 'nullable|string|max:255',
        'gender' => 'nullable|string',
        'marital_status' => 'nullable|string',
        'date_of_birth' => 'nullable|date',
        'aadhar_number' => 'nullable|max:20',
        'pan_number' => 'nullable|max:20',
        'scheme_name' => 'nullable|string|max:255',
        'scheme_emi_amount' => 'nullable|numeric',
        'scheme_emi_plan' => 'nullable|numeric',
        'nominee_name' => 'nullable|string|max:255',
        'nominee_relation' => 'nullable|string|max:255',
        'user_group' => 'nullable|string|max:255',
        'staff_id' => 'nullable|numeric',
        'other_information' => 'nullable|string',
    ];

    public function downloadPdf($id)
    {
        $s = Manage::findOrFail($id);

        return Pdf::loadView('admin.manage.pdf_report', compact('s'))
            ->download('customer-' . $s->id . '.pdf');
    }


    public function create()
    {
        return view('admin.manage.create');
    }


    public function store(Request $request)
    {
        $rules = array_merge($this->rules, [
            'profile_image_upload' => 'nullable|image|max:2048',
            'pan_card_upload' => 'nullable|mimes:jpg,png,pdf|max:4096',
            'aadhar_card_upload' => 'nullable|mimes:jpg,png,pdf|max:4096',
            'start_date' => 'required|date',
        ]);

        $request->validate($rules);

        // -------- AUTO END DATE FIX --------
        $months = (int) $request->scheme_emi_plan;
        $start = Carbon::parse($request->start_date);
        $end = $start->copy()->addMonths($months);

        $data = $request->except(['profile_image_upload', 'pan_card_upload', 'aadhar_card_upload']);

        $data['start_date'] = $start->format('Y-m-d');
        $data['end_date'] = $end->format('Y-m-d');

        // Uploads
        if ($request->hasFile('profile_image_upload')) {
            $data['profile_image'] = $request->profile_image_upload->store('uploads/profile', 'public');
        }
        if ($request->hasFile('pan_card_upload')) {
            $data['pan_card'] = $request->pan_card_upload->store('uploads/pan', 'public');
        }
        if ($request->hasFile('aadhar_card_upload')) {
            $data['aadhar_card'] = $request->aadhar_card_upload->store('uploads/aadhar', 'public');
        }

        Manage::create($data);

        return redirect()->route('admin.manage.index')->with('success', 'Saved');
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $city = $request->city;
        $state = $request->state;
        $address = $request->address;
        $tab = $request->tab;

        $query = Manage::query();

        /* ============================
           SEARCH FILTERS (Your Old Logic)
        ============================ */
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kij', "like", "%$search%")
                    ->orWhere('first_name', "like", "%$search%")
                    ->orWhere('last_name', "like", "%$search%")
                    ->orWhere('mobile_number', "like", "%$search%")
                    ->orWhere('scheme_name', "like", "%$search%");
            });
        }

        if ($city) {
            $query->where('city_village', 'like', "%$city%");
        }

        if ($state) {
            $query->where('state', 'like', "%$state%");
        }

        if ($address) {
            $query->where(function ($q) use ($address) {
                $q->where('city_village', 'like', "%$address%")
                    ->orWhere('state', 'like', "%$address%")
                    ->orWhere('country', 'like', "%$address%");
            });
        }

        /* ============================
           REPORT FILTER LOGIC
        ============================ */
        $today = now()->format('Y-m-d');

        if ($tab === 'closed-report') {
            // END_DATE < TODAY
            $query->whereDate('end_date', '<', $today);
        }

        if ($tab === 'current-report') {
            // TODAY BETWEEN START AND END DATE
            $query->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today);
        }

        if ($tab === 'due-date-report') {
            // END_DATE = TODAY
            $query->whereDate('end_date', '=', $today);
        }

        if ($tab === 'today-closing-report') {
            // END_DATE = TODAY (same logic, you can customize)
            $query->whereDate('end_date', '=', $today);
        }

        /* ============================
           PAGINATION
        ============================ */
        $manages = $query->latest()->paginate(10);

        return view('admin.manage.index', compact('manages'));
    }


    public function show($id)
    {
        $manage = Manage::findOrFail($id);
        return view('admin.manage.show', compact('manage'));
    }


    public function edit($id)
    {
        $manage = Manage::findOrFail($id);
        return view('admin.manage.edit', compact('manage'));
    }


    public function update(Request $request, $id)
    {
        $manage = Manage::findOrFail($id);

        $rules = array_merge($this->rules, [
            'profile_image_upload' => 'nullable|image|max:2048',
            'pan_card_upload' => 'nullable|mimes:jpg,png,pdf|max:4096',
            'aadhar_card_upload' => 'nullable|mimes:jpg,png,pdf|max:4096',
            'start_date' => 'nullable|date',
        ]);

        $request->validate($rules);

        $data = $request->except(['profile_image_upload', 'pan_card_upload', 'aadhar_card_upload']);

        // ------ AUTO UPDATE END DATE FIX ------
        if ($request->start_date && $request->scheme_emi_plan) {
            $months = (int) $request->scheme_emi_plan;
            $start = Carbon::parse($request->start_date);
            $end = $start->copy()->addMonths($months);

            $data['start_date'] = $start->format('Y-m-d');
            $data['end_date'] = $end->format('Y-m-d');
        }

        // Uploads
        if ($request->hasFile('profile_image_upload')) {
            $manage->profile_image = $request->profile_image_upload->store('uploads/profile', 'public');
        }
        if ($request->hasFile('pan_card_upload')) {
            $manage->pan_card = $request->pan_card_upload->store('uploads/pan', 'public');
        }
        if ($request->hasFile('aadhar_card_upload')) {
            $manage->aadhar_card = $request->aadhar_card_upload->store('uploads/aadhar', 'public');
        }

        $manage->update($data);

        return back()->with('success', 'Updated');
    }


    public function destroy($id)
    {
        $manage = Manage::findOrFail($id);
        $manage->delete();
        return back()->with('success', 'Deleted');
    }


    // ---------------- SETTINGS PART ----------------
    public function create123()
    {
        return view('admin.manage.customers');
    }

    public function settings(Request $request)
    {
        $activeTab = $request->get('tab', 'general');

        $schemes = Scheme::select('id', 'name')->get();
        $settings = SchemeSetting::latest()->paginate(10);

        return view('admin.manage.settings', compact('activeTab', 'schemes', 'settings'));
    }

    public function settingsStore(Request $request)
    {
        $data = $request->validate([
            'scheme_id' => 'nullable|integer',
            'scheme_name' => 'nullable|string|max:255',
            'scheme_plan' => 'nullable|string|max:100',
            'cash_metal' => 'nullable|string|max:50',
            'user_group' => 'nullable|string|max:100',
            'no_of_users' => 'nullable|integer',
            'no_of_emi' => 'nullable|integer',
            'emi_amt' => 'nullable|numeric',
            'multiple_amount' => 'nullable|string',
            'start_token_no' => 'nullable|integer',
            'end_token_no' => 'nullable|integer',
            'bonus_amount' => 'nullable|numeric',
            'interest_type' => 'nullable|in:%,flat',
            'emi_late_fee' => 'nullable|numeric',
            'convert_bonus_to_gold' => 'nullable|boolean',
            'late_fee_days' => 'nullable|integer',
            'gold_bonus_percent' => 'nullable|numeric',
            'diamond_bonus_percent' => 'nullable|numeric',
            'gold_mkg_discount' => 'nullable|numeric',
            'diamond_mkg_discount' => 'nullable|numeric',
            'emi_rows' => 'nullable|array',
        ]);

        $data['convert_bonus_to_gold'] = $request->has('convert_bonus_to_gold') ? 1 : 0;

        $emiRows = [];
        foreach ($request->emi_rows ?? [] as $row) {
            if (!empty($row['emi_no'])) {
                $emiRows[] = [
                    'emi_no' => $row['emi_no'],
                    'discount' => $row['discount'] ?? 0,
                    'bonus' => $row['bonus'] ?? 0,
                ];
            }
        }

        $data['emi_rows'] = $emiRows;

        SchemeSetting::create($data);

        return redirect()->route('admin.manage.settings')->with('success', 'Scheme Added');
    }


    public function settingsEdit($id)
    {
        $setting = SchemeSetting::findOrFail($id);
        $schemes = Scheme::select('id', 'name')->get();
        return view('admin.manage.settings_edit', compact('setting', 'schemes'));
    }


    public function settingsUpdate(Request $request, $id)
    {
        $setting = SchemeSetting::findOrFail($id);

        $data = $request->validate([
            'scheme_id' => 'nullable|integer',
            'scheme_name' => 'nullable|string|max:255',
            'scheme_plan' => 'nullable|string|max:100',
            'cash_metal' => 'nullable|string|max:50',
            'user_group' => 'nullable|string|max:100',
            'no_of_users' => 'nullable|integer',
            'no_of_emi' => 'nullable|integer',
            'emi_amt' => 'nullable|numeric',
            'multiple_amount' => 'nullable|string',
            'start_token_no' => 'nullable|integer',
            'end_token_no' => 'nullable|integer',
            'bonus_amount' => 'nullable|numeric',
            'interest_type' => 'nullable|in:%,flat',
            'emi_late_fee' => 'nullable|numeric',
            'convert_bonus_to_gold' => 'nullable|boolean',
            'late_fee_days' => 'nullable|integer',
            'gold_bonus_percent' => 'nullable|numeric',
            'diamond_bonus_percent' => 'nullable|numeric',
            'gold_mkg_discount' => 'nullable|numeric',
            'diamond_mkg_discount' => 'nullable|numeric',
            'emi_rows' => 'nullable|array',
        ]);

        $data['convert_bonus_to_gold'] = $request->has('convert_bonus_to_gold') ? 1 : 0;

        $emiRows = [];
        foreach ($request->emi_rows ?? [] as $row) {
            if (!empty($row['emi_no'])) {
                $emiRows[] = [
                    'emi_no' => $row['emi_no'],
                    'discount' => $row['discount'] ?? 0,
                    'bonus' => $row['bonus'] ?? 0,
                ];
            }
        }

        $data['emi_rows'] = $emiRows;

        $setting->update($data);

        return redirect()->route('admin.manage.settings')->with('success', 'Updated Successfully');
    }


    public function settingsDestroy($id)
    {
        SchemeSetting::findOrFail($id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
