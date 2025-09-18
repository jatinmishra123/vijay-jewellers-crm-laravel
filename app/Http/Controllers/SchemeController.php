<?php

namespace App\Http\Controllers;

use App\Models\Scheme;
use Illuminate\Http\Request;

class SchemeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin|Manager']);
    }

    // List schemes with search & pagination
    public function index(Request $request)
    {
        $query = Scheme::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $schemes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.schemes.index', compact('schemes'));
    }

    // Show create form
    public function create()
    {
        return view('admin.schemes.create');
    }

    // Store new scheme
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:schemes,name',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
        ]);

        Scheme::create($request->all());

        return redirect()->route('admin.schemes.index')->with('success', 'Scheme created successfully.');
    }

    // Show edit form
    public function edit(Scheme $scheme)
    {
        return view('admin.schemes.edit', compact('scheme'));
    }

    // Update existing scheme
    public function update(Request $request, Scheme $scheme)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:schemes,name,' . $scheme->id,
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $scheme->update($request->all());

        return redirect()->route('admin.schemes.index')->with('success', 'Scheme updated successfully.');
    }

    // Delete scheme
    public function destroy(Scheme $scheme)
    {
        // Delete related members first
        $scheme->members()->delete();

        // Now delete the scheme
        $scheme->delete();

        return redirect()->route('admin.schemes.index')
            ->with('success', 'Scheme deleted successfully.');
    }

}
