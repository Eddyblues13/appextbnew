@extends('emails.layouts.master')

@section('content')
    <h2>Welcome to Appex Trust Bank!</h2>
    <p>Hello {{ $user->name }},</p>
    <p>We are thrilled to have you on board. Your account has been successfully created. You can now log in to manage your finances, make transfers, and access all our premium banking services.</p>
    
    <div class="data-box text-center">
        <p style="text-transform: uppercase; color: #888; font-size: 12px; font-weight: 600;">Your New Account Number</p>
        <p style="font-size: 28px; color: #3037ff; font-weight: bold; letter-spacing: 2px; margin-bottom: 0;">{{ $user->account_number }}</p>
    </div>
    
    <div class="text-center">
        <a href="{{ route('login') }}" class="button">Login to Your Account</a>
    </div>
    
    <p>If you did not create this account, please contact our support team immediately.</p>
    <p>Best Regards,<br><strong>Appex Trust Bank Team</strong></p>
@endsection
