@extends('emails.layouts.master')

@section('content')
    <h2>Transaction Notification</h2>
    <p>Dear {{ $user->name }},</p>
    <p>Your account has been {{ $transactionType }}ed with the following details:</p>
    
    <div class="data-box">
        <p><strong>Amount:</strong> {{ $user->currency ?? '$' }}{{ number_format($amount, 2) }}</p>
        <p><strong>Category:</strong> {{ $type }}</p>
        <p><strong>Type:</strong> {{ $transactionType }}</p>
    </div>
    
    <p>Thank you for using our service!</p>
    <p>Kind Regards,<br><strong>Appex Trust Bank</strong></p>
@endsection