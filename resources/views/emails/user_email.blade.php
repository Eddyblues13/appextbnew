@extends('emails.layouts.master')

@section('content')
    {!! $data !!}
    
    <p style="margin-top: 40px; border-top: 1px solid #EAEAEC; padding-top: 20px; font-size: 14px;">
        If you have any questions or need assistance with the registration process, please don't hesitate to ask at 
        <a href="mailto:support@appextb.com">support@appextb.com</a>.
    </p>
@endsection