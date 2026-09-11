@extends('mail_views.mail_layout')

@section('content')


@if($data->type == 'next_approval')
   
    <p>
        Hello {{$data->name}}, {{$data->sender_name}} made a request contained below<br>
        {{$data->desc}}, Total Amount = {{Utility::numberFormat($data->amount)}}. Please action this request.

    </p>
   

@endif

@if($data->type == 'request_approved')

    Hello, the request made by {{$data->sender_name}} has been approved.<br>
    {{$data->desc}}, Total Amount = {{Utility::numberFormat($data->amount)}}.

@endif

@if($data->type == 'request_denied')

    Hello, the request made by {{$data->sender_name}} has been denied.<br>
    {{$data->desc}}, Total Amount = {{Utility::numberFormat($data->amount)}}

@endif

@endsection