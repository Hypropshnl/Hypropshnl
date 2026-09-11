
@if($data->type == 'next_approval')
   
    <p>
        Hello {{$data->name}}, {{$data->sender_name}} made a leave request contained below<br>
        {{$data->desc}}. Please visit the portal to action this request.

    </p>
    

@endif

@if($data->type == 'request_approved')

    Hello, the leave request made by {{$data->sender_name}} has been approved.<br>
    {{$data->desc}}.

@endif

@if($data->type == 'request_denied')

    Hello, the leave request made by {{$data->sender_name}} has been denied.<br>
    {{$data->desc}}.

@endif