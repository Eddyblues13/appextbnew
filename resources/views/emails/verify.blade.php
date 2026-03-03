@extends('emails.layouts.master')

@section('content')
    <h2>Welcome to Appex Trust Bank</h2>
    <p><strong>Confirm Your Registration</strong></p>
    <p>Your registration is successful and you are just a step away from verifying your account.</p>
    <p>Here is your activation code:</p>
    
    <div class="data-box text-center">
        <p style="font-size: 28px; color: #3037ff; font-weight: bold; letter-spacing: 2px; margin-bottom: 0;">{{ $validToken }}</p>
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