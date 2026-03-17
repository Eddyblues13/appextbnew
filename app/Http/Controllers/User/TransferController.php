<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SavingsBalance;
use App\Models\CheckingBalance;
use App\Models\TransferHistory;
use Illuminate\Support\Facades\DB;
use App\Models\WireTransferHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class TransferController extends Controller
{
    public function showForm($type)
    {


        $validTypes = ['wire', 'local', 'internal', 'paypal', 'crypto', 'skrill'];

        if (!in_array($type, $validTypes)) {
            abort(404);
        }



        $user = Auth::user();
        $data['user'] = Auth::user();
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



        return view("user.transfer.{$type}",  $data);
    }

    public function processTransfer(Request $request)
    {
        $transferType = $request->type;
        $validationRules = $this->getValidationRules($transferType);

        $validated = $request->validate($validationRules);
        $user = Auth::user();

        // Check if user account is activated for withdrawals
        if (!$user->is_activated) {
            return back()->with('error', 'Please contact support to activate your account for withdrawals first.');
        }

        DB::beginTransaction();
        try {
            $account = $validated['account'];
            $amount = $validated['amount'];

            // Fetch current balance
            $balance = ($account === 'savings')
                ? SavingsBalance::where('user_id', $user->id)->sum('amount')
                : CheckingBalance::where('user_id', $user->id)->sum('amount');

            if ($amount > $balance) {
                throw ValidationException::withMessages(['amount' => 'Insufficient funds in the selected account.']);
            }

            // Store data in session for tax confirmation
            Session::put('transfer_data', [
                'type' => $transferType,
                'validated' => $validated,
                'details' => $this->getTransferDetails($transferType, $validated)
            ]);

            DB::commit();

            $user = Auth::user();
            $data['savings_balance'] = SavingsBalance::where('user_id', $user->id)->sum('amount');
            $data['checking_balance'] = CheckingBalance::where('user_id', $user->id)->sum('amount');

            $data['currentMonth'] = Carbon::now()->format('M Y'); // Example: "Feb 2025"

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

            // Redirect to tax confirmation form
            //return view('user.transfer.tax-form', compact('transferType', 'amount'), $data);
            // Redirect to IMF confirmation form
            return redirect()->route('transfer.confirmImf', [
                'transferType' => $transferType,
                'amount' => $amount
            ])->with($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }




    public function confirmImf(Request $request)
    {
        $transferData = session('transfer_data');

        if (!$transferData) {
            return redirect()->route('home')->with('error', 'Session expired, please start over.');
        }

        if ($request->isMethod('post')) {
            $user = Auth::user();
            
            // Validate IMF Code
            $request->validate([
                'imf_code' => 'required|string'
            ]);

            if ($request->imf_code !== $user->imf_code) {
                return back()->with('error', 'Invalid IMF Code. Please try again or contact support.');
            }

            // If transfer wasn't already created in this session flow
            if (!isset($transferData['transfer_id'])) {
                $account = $transferData['validated']['account'];
                $amount = $transferData['validated']['amount'];

                // Deduct amount from selected account by adding a debit transaction
                if ($account === 'savings') {
                    SavingsBalance::create([
                        'user_id' => $user->id,
                        'amount' => -$amount,
                        'type' => 'debit',
                        'status' => 'active',
                        'description' => 'Transfer withdrawal: ' . strtoupper($transferData['type'])
                    ]);
                } else {
                    CheckingBalance::create([
                        'user_id' => $user->id,
                        'amount' => -$amount,
                        'type' => 'debit',
                        'status' => 'active',
                        'description' => 'Transfer withdrawal: ' . strtoupper($transferData['type'])
                    ]);
                }

                $reference = $this->generateReference();

                $transfer = TransferHistory::create([
                    'reference' => $reference,
                    'user_id' => $user->id,
                    'type' => $transferData['type'],
                    'amount' => $amount,
                    'currency' => $user->currency,
                    'from_account' => $account,
                    'details' => json_encode($transferData['details']),
                    'status' => 'pending'
                ]);
                
                $transferData['transfer_id'] = $transfer->id;
                $transferData['reference'] = $reference;
                session()->put('transfer_data', $transferData);
            }

            // We keep transfer_data in session
            return redirect()->route('transfer.showIdCardForm')->with('success', 'Your transaction is pending. As the final stage, please upload your ID Card.');
        }

        $user = Auth::user();
        $data['savings_balance'] = SavingsBalance::where('user_id', $user->id)->sum('amount');
        $data['checking_balance'] = CheckingBalance::where('user_id', $user->id)->sum('amount');

        $data['currentMonth'] = Carbon::now()->format('M Y'); // Example: "Feb 2025"

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

        // Show the IMF code form with retained data
        return view('user.transfer.imf-form', compact('transferData'), $data);
    }

    public function showIdCardForm()
    {
        $transferData = session('transfer_data');

        if (!$transferData) {
            return redirect()->route('home')->with('error', 'Session expired, please start over.');
        }

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

        return view('user.transfer.id-card-form', compact('transferData'), $data);
    }

    public function uploadIdCard(Request $request)
    {
        $transferData = session('transfer_data');

        if (!$transferData || !isset($transferData['transfer_id'])) {
            return redirect()->route('home')->with('error', 'Session expired, please start over.');
        }

        $request->validate([
            'id_card_number' => 'required|string',
        ]);

        $user = Auth::user();

        // Verify the ID card number matches what admin set
        if ($request->id_card_number !== $user->id_card_number) {
            return back()->with('error', 'Invalid ID Card Number. Please try again or contact support.');
        }

        $account = $transferData['validated']['account'];
        $amount = $transferData['validated']['amount'];
        $reference = $transferData['reference'];

        session()->forget('transfer_data');

        // Store receipt data in session temporarily
        $receiptData = [
            'reference' => $reference,
            'date' => now()->format('Y-m-d H:i:s'),
            'amount' => $amount,
            'currency' => $user->currency,
            'account_type' => $account,
            'recipient' => $transferData['details']['name'] ?? $transferData['details']['email'] ?? $transferData['details']['wallet_address'] ?? 'N/A',
            'recipient_account' => $transferData['details']['acct'] ?? $transferData['details']['wallet_address'] ?? 'N/A',
            'bank_name' => $transferData['details']['bank'] ?? 'N/A',
            'user' => $user
        ];

        session()->flash('receipt_data', $receiptData);

        return redirect()->route('transfer.receipt')->with('success', 'ID Card verified successfully. Your withdrawal request is pending approval.');
    }

    private function generateReference()
    {
        return 'TX-' . time() . '-' . Str::upper(Str::random(6));
    }


    public function showReceipt()
    {
        if (!session()->has('receipt_data')) {
            return redirect()->route('home')->with('error', 'No receipt data found.');
        }

        $receiptData = session('receipt_data');
        return view('user.transfer.receipt', compact('receiptData'));
    }

    private function getValidationRules($type)
    {
        $baseRules = [
            'type' => 'required|in:wire,local,internal,paypal,crypto,skrill',
            'account' => 'required|in:savings,checking',
            'amount' => 'required|numeric|min:0.01',
            //'pin' => 'required|digits:4'
        ];

        $typeRules = [
            'wire' => [
                'name' => 'required|string|max:255',
                'acct' => 'required|regex:/^[A-Za-z0-9]+$/',
                'bank' => 'required|string|max:255',
                'swift' => 'nullable|string',
                'routing' => 'required|numeric',
                'address' => 'nullable|string|max:500',
                'remarks' => 'nullable|string|max:255'
            ],
            'local' => [
                'name' => 'required|string|max:255',
                'acct' => 'required|regex:/^[A-Za-z0-9]+$/',
                'bank' => 'required|string|max:255',
                'remarks' => 'nullable|string|max:255'
            ],
            'internal' => [
                'acct' => 'required|regex:/^[A-Za-z0-9]+$/',
                'routing' => 'required|numeric',
            ],
            'paypal' => [
                'email' => 'required|email',
            ],
            'crypto' => [
                'name' => 'required|string|max:255',
                'wallet_address' => 'required|string|max:255',
                'crypto_type' => 'required|string|in:bitcoin,ethereum,usdt',
            ],
            'skrill' => [
                'email' => 'required|email',
            ]
        ];

        return array_merge($baseRules, $typeRules[$type] ?? []);
    }

    private function getTransferDetails($type, $validated)
    {
        $typeDetails = [
            'wire' => [
                'name' => $validated['name'] ?? null,
                'acct' => $validated['acct'] ?? null,
                'bank' => $validated['bank'] ?? null,
                'swift' => $validated['swift'] ?? null,
                'routing' => $validated['routing'] ?? null,
                'address' => $validated['address'] ?? null,
                'remarks' => $validated['remarks'] ?? null
            ],
            'local' => [
                'name' => $validated['name'] ?? null,
                'acct' => $validated['acct'] ?? null,
                'bank' => $validated['bank'] ?? null,
                'remarks' => $validated['remarks'] ?? null
            ],
            'internal' => [
                'acct' => $validated['acct'] ?? null,
                'routing' => $validated['routing'] ?? null,
            ],
            'paypal' => [
                'email' => $validated['email'] ?? null,
            ],
            'crypto' => [
                'name' => $validated['name'] ?? null,
                'wallet_address' => $validated['wallet_address'] ?? null,
                'crypto_type' => $validated['crypto_type'] ?? null,
            ],
            'skrill' => [
                'email' => $validated['email'] ?? null,
            ]
        ];

        return $typeDetails[$type] ?? [];
    }


    public function success()
    {
        return redirect()->route('home')->with('success', 'Transfer completed successfully.');
    }
}
