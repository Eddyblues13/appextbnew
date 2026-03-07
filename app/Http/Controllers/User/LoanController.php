<?php

namespace App\Http\Controllers\User;

use App\Models\Loan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SavingsBalance;
use App\Models\CheckingBalance;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'occupation' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1000',
            'message' => 'required|string|max:1000',
        ]);

        $loan = new Loan();
        $loan->user_id = Auth::id();
        $loan->occupation = $request->occupation;
        $loan->amount = $request->amount;
        $loan->message = $request->message;
        $loan->reference = Str::random(10);
        $loan->status = 'pending';
        $loan->save();

        return redirect()->back()->with('success', 'Loan application submitted successfully.');
    }

    public function index()
    {
        $user = Auth::user();
        $data['loans'] = Loan::where('user_id', $user->id)->latest()->get();
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

        return view('user.loan', $data);
    }
}
