@extends('mail_views.mail_layout')

@section('content')


@if($data->type == 'next_approval')
    
    <p>
        Hello {{$data->name}}, {{$data->sender_name}} made a request for RFQ Bid Analysis approval<br>
        Please visit the portal to action this request.

    </p>
   

@endif

@if($data->type == 'request_approved')

    Hello, the request made by {{$data->sender_name}} has been approved.<br>
    {{$data->desc}}.

@endif

@if($data->type == 'request_denied')

    Hello, the request made by {{$data->sender_name}} has been denied.<br>
    {{$data->desc}}

@endif

@endsection