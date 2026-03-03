@extends('emails.layouts.master')

@section('content')
    <h2>Welcome to Appex Trust Bank!</h2>
    <p>{!! $vmessage !!}</p>
    <p>Kind Regards,<br><strong>Appex Trust Bank</strong></p>
@endsection