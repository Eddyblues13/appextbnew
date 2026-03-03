@extends('emails.layouts.master')

@section('content')
    <p>Dear User,</p>
    <p>{!! nl2br(e($messageBody)) !!}</p>
    <p>Best Regards,<br><strong>Appex Trust Bank</strong></p>
@endsection