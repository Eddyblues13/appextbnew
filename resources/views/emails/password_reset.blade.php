@extends('emails.layouts.master')

@section('content')
    <h2>Password Reset Request</h2>
    <p>Hello,</p>
    <p>We received a request to reset your password. Click the button below to set a new password. This link will expire in 60 minutes.</p>
    
    <div class="text-center">
        <a href="{{ $url }}" class="button">Reset Password</a>
    </div>
    
    <p style="font-size: 14px; color: #888;">If you did not request a password reset, no further action is required. Your password will remain unchanged.</p>
    
    <p style="font-size: 14px; color: #888; overflow-wrap: break-word; word-break: break-all;">
        If the button above doesn't work, copy and paste this link into your browser:<br>
        <a href="{{ $url }}">{{ $url }}</a>
    </p>
    
    <p>Best Regards,<br><strong>Appex Trust Bank Team</strong></p>
@endsection
