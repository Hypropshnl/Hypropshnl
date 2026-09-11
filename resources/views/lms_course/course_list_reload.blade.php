@foreach($mainData as $data)
@php $departments = json_decode($data->department_id) @endphp
@if(in_array(Auth::user()->dept_id,$departments))
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <a href="{{route('lms_course_item', ['course_id' => $data->id])}}" data-sub-html="{{$data->name}} ({{$data->code}})">
        <img class="img-responsive thumbnail" src="{{ asset('files/'.$data->photo) }}">
    </a>
    <div>
        <h4><a href="{{route('lms_course_item', ['course_id' => $data->id])}}">{{$data->name}} ({{$data->code}})</a></h4>
        <span>Category: {{$data->category->name}}</span>
        
    </div>
    <div>
        @if($courseArr > 0 && in_array($data->id, $courseArr))
            <span class="pull-left btn btn-success">In Progress</span>
        @else
            <span class="pull-left btn "><a href="{{route('lms_course_item_enroll', ['course_id' => $data->id])}}">Enroll</a></span>
            <span class="pull-left btn "><a href="{{route('lms_course_item', ['course_id' => $data->id])}}">Overview</a></span>
        @endif
    </div>
</div>
@endif
@endforeach

<div class=" pagination pull-right">
{!! $mainData->render() !!}
</div>