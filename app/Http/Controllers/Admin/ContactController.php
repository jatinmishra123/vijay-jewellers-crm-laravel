<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerConversation;

class ContactController extends Controller
{
    // List customers with conversations
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%");
        }

        $customers = $query->with('conversations')->orderBy('id', 'desc')->paginate(10);

        return view('admin.contacts.index', compact('customers'));
    }

    // Save a new conversation message for a customer
    public function saveConversation(Request $request, $customer_id)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // ensure customer exists
        $customer = Customer::findOrFail($customer_id);

        CustomerConversation::create([
            'customer_id' => $customer->id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Conversation saved.');
    }

    // (optional) delete conversation
    public function deleteConversation($id)
    {
        $conv = CustomerConversation::findOrFail($id);
        $conv->delete();
        return back()->with('success', 'Conversation deleted.');
    }
}
