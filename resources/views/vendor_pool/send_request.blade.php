@extends('mail_views.mail_layout')

@section('content')


@if($data->type == 'next_approval')
   
    <p>
        Hello {{$data->name}}, {{$data->sender_name}} has requested to be an approved vendor<br> 
        Please action this request.

    </p>
   

@endif

@if($data->type == 'request_approved')

    Hello, the request made by {{$data->sender_name}} to be an approved vendor has been approved.<br>
    We look forward to working with you. Thank you.

@endif

@if($data->type == 'request_denied')

    Hello, the request made by {{$data->sender_name}} to become an approved vendor has been denied.<br>
    {{$data->desc}}

@endif

@endsection