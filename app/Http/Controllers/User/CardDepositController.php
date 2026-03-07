<?php

namespace App\Http\Controllers\User;

use App\Models\CardDeposit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SavingsBalance;
use App\Models\CheckingBalance;
use Carbon\Carbon;

class CardDepositController extends Controller
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
            
        return view('user.card-deposit', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'account' => 'required',
            'amount' => 'required|numeric|min:1',
            'cardType' => 'required',
            'cardName' => 'required|string|max:255',
            'cardNumber' => 'required|string|max:16',
            'cardExp' => 'required|string|max:7',
            'cardCvv' => 'required|string|max:4',
        ]);

        CardDeposit::create([
            'user_id' => Auth::id(),
            'account' => $request->account,
            'amount' => $request->amount,
            'cardType' => $request->cardType,
            'cardName' => $request->cardName,
            'cardNumber' => $request->cardNumber,
            'cardExp' => $request->cardExp,
            'cardCvv' => $request->cardCvv,
        ]);

        return redirect()->back()->with('success', 'Deposit request submitted successfully.');
    }
}
