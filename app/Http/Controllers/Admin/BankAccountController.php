<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of bank accounts
     */
    public function index()
    {
        $bankAccounts = BankAccount::orderBy('is_active', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.bank-accounts.index', compact('bankAccounts'));
    }

    /**
     * Show the form for creating a new bank account
     */
    public function create()
    {
        return view('admin.bank-accounts.create');
    }

    /**
     * Store a newly created bank account
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'swift_code' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // If this is set as active, deactivate others
        if ($request->has('is_active') && $request->is_active) {
            BankAccount::query()->update(['is_active' => false]);
        }

        BankAccount::create($validated);

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Bank account added successfully!');
    }

    /**
     * Show the form for editing a bank account
     */
    public function edit(BankAccount $bankAccount)
    {
        return view('admin.bank-accounts.edit', compact('bankAccount'));
    }

    /**
     * Update the specified bank account
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'swift_code' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // If this is set as active, deactivate others
        if ($request->has('is_active') && $request->is_active) {
            BankAccount::query()->update(['is_active' => false]);
        }

        $bankAccount->update($validated);

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Bank account updated successfully!');
    }

    /**
     * Activate a bank account
     */
    public function activate(BankAccount $bankAccount)
    {
        $bankAccount->setActive();

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Bank account activated successfully!');
    }

    /**
     * Remove the specified bank account
     */
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Bank account deleted successfully!');
    }
}
