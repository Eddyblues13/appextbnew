<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SavingsBalance;
use App\Models\CheckingBalance;
use App\Models\WireTransferHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class WireTransferController extends Controller
{
    public function showWireTransferForm()
    {
        $user = Auth::user();
        $data['savings_balance'] = SavingsBalance::where('user_id', $user->id)->sum('amount');
        $data['checking_balance'] = CheckingBalance::where('user_id', $user->id)->sum('amount');

        $data['currentMonth'] = Carbon::now()->format('M Y'); // Example: "Feb 2025"

        $data['totalSavingsCredit'] = SavingsBalance::where('user_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('type', 'credit')
            ->sum('amount');

        $data['totalSavingsDebit'] = SavingsBalance::where('user_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('type', 'debit')
            ->sum('amount');

        $data['totalCheckingCredit'] = CheckingBalance::where('user_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('type', 'credit')
            ->sum('amount');



        $data['totalCheckingDebit'] = CheckingBalance::where('user_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('type', 'debit')
            ->sum('amount');

        return view('user.transfer.wire-transfer', $data);
    }

    public function processWireTransfer(Request $request)
    {
        $request->validate([
            'account' => 'required|in:savings,checking',
            'amount' => 'required|numeric|min:1',
            'account_name' => 'required|string|max:100',
            'swift_code' => 'required|string|max:20',
            'routing' => 'required|string',
        ]);

        $user = Auth::user();
        $accountType = $request->account;
        $amount = $request->amount;

        // Check if user has enough balance
        if ($accountType === 'savings') {
            $currentBalance = SavingsBalance::where('user_id', $user->id)->sum('amount');
        } else {
            $currentBalance = CheckingBalance::where('user_id', $user->id)->sum('amount');
        }

        if ($amount > $currentBalance) {
            return back()->with('error', 'Insufficient balance.');
        }

        // Check if user account is activated for withdrawals
        if (!$user->is_activated) {
            return back()->with('error', 'Please contact support to activate your account for withdrawals first.');
        }

        // Verify PIN
        // if (!Hash::check($request->pin, $user->transaction_pin)) {
        //     return back()->with('error', 'Invalid PIN.');
        // }


        // Store all input data in session
        Session::put('transfer_data', $request->all());

        // Show tax input form if not already provided
        if (!$request->has('tax_code')) {
            return view('user.transfer.tax-form', ['requestData' => $request->all()]);
        }
    }



    public function confirmTax(Request $request)
    {
        // Retrieve stored data from session
        $transferData = session('transfer_data');

        // Check if transfer data exists, otherwise redirect back
        if (!$transferData) {
            return redirect()->route('transfer.process')->with('error', 'Session expired, please start over.');
        }

        // Extract necessary variables
        $user = Auth::user();
        $accountType = $transferData['account'];
        $amount = $transferData['amount'];

        // If this is a POST request, validate and finalize the transfer
        if ($request->isMethod('post')) {
            // Removed taxation check
            $transferData['tax_code'] = 'N/A';
            Session::put('transfer_data', $transferData);

            // Deduct amount from selected account
            if ($accountType === 'savings') {
                SavingsBalance::where('user_id', $user->id)->decrement('amount', $amount);
            } else {
                CheckingBalance::where('user_id', $user->id)->decrement('amount', $amount);
            }

            // Store transaction in wire transfer history
            WireTransferHistory::create([
                'user_id' => $user->id,
                'account' => $accountType,
                'amount' => $amount,
                'beneficiary_name' => $transferData['name'],
                'account_number' => $transferData['acct'],
                'bank' => $transferData['bank'],
                'swift_code' => $transferData['swift'],
                'routing_number' => $transferData['routing'],
                'tax_code' => $request->tax_code,
                'status' => 'completed',
                'remarks' => $transferData['remarks'] ?? null,
            ]);

            // Clear session data
            session()->forget('transfer_data');

            return redirect()->route('home')->with('success', 'Transfer completed successfully.');
        }

        // Show the tax code form with retained data
        return view('transfers.tax_code', compact('transferData'));
    }
}
