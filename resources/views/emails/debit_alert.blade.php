@extends('emails.layouts.master')

@section('content')
    <h2>Greetings, {{ $user['full_name'] }}!</h2>
    
    <div class="text-center">
        <p>Your account has been Debited with</p>
        <div class="amount-highlight">{{ $user['currency'] }}{{ $user['amount'] }}</div>
    </div>
    
    <p>Details of the transaction are shown below:</p>
    
    <div class="data-box">
        <p><strong>Account Number:</strong> {{ $user['account_number'] }}</p>
        <p><strong>Account Name:</strong> {{ $user['account_name'] }}</p>
        <p><strong>Description:</strong> {{ $user['description'] }}</p>
        <p><strong>Total Amount:</strong> {{ $user['currency'] }}{{ $user['amount'] }}</p>
        <p><strong>Reference:</strong> {{ $user['ref'] }}</p>
        <p><strong>Date:</strong> {{ $user['date'] }}</p>
        <p><strong>Available Balance:</strong> {{ $user['currency'] }}{{ $user['balance'] }}</p>
    </div>
    
    <div class="security-tips">
        <p style="font-weight: bold; margin-bottom: 5px;">Security Tips:</p>
        <ul>
            <li>Never give your login access to anyone.</li>
            <li>This message is automated, do not reply.</li>
        </ul>
    </div>
    
    <p style="margin-top: 20px;">Kind Regards,<br><strong>Appex Trust Bank</strong></p>
@endsection