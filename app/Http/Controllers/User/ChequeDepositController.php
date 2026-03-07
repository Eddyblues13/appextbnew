<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\ChequeDeposit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SavingsBalance;
use App\Models\CheckingBalance;
use Carbon\Carbon;

class ChequeDepositController extends Controller
{

    public function create()
    {
        $user = Auth::user();
        $data['savings_balance'] = SavingsBalance::where('user_id', $user->id)->sum('amount');
        $data['checking_balance'] = CheckingBalance::where('user_id', $user->id)->sum('amount');

        $data['currentMonth'] = Carbon::now()->format('M Y'); 

        $data['totalSavingsCredit'] = SavingsBalance::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('type', 'credit')
            ->sum('amount');

        $data['totalSavingsDebit'] = SavingsBalance::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('type', 'debit')
            ->sum('amount');



        $data['totalCheckingCredit'] = CheckingBalance::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('type', 'credit')
            ->sum('amount');


        $data['totalCheckingDebit'] = CheckingBalance::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('type', 'debit')
            ->sum('amount');
            
        return view('user.cheque-deposit', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'back' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'message' => 'nullable|string|max:500',
        ]);

        // Handle file uploads
        $frontPath = $request->file('front')->store('uploads/deposits', 'public');
        $backPath = $request->file('back')->store('uploads/deposits', 'public');

        // Store deposit details
        ChequeDeposit::create([
            'user_id' => Auth::id(),
            'front' => $frontPath,
            'back' => $backPath,
            'remarks' => $request->message,
        ]);

        return back()->with('success', 'Deposit uploaded successfully.');
    }
}
