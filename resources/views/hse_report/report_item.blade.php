

@extends('layouts.letter_head_internal')

@section('content')

    <table class="table-bordered table-hover table-striped">
        <thead></thead>
        <tbody>
        <tr>
            <td>
            Report Type : -
            @if($data->report_type != 0)
            {{\App\Helpers\Utility::HSE_REPORT_TYPE[$data->report_type]}}
            @endif
            </td>
            <td>Source Type:-{{$data->source->source_name}}</td>
            <td>
                Reported By:- 
                @if($data->created_by != 0)
                {{$data->user_c->firstname}}&nbsp;{{$data->user_c->lastname}}
                @else
                {{$data->reported_by}}
                @endif
            </td>
            <td>Reported at:-{{$data->created_at}}</td>
        </tr>

        <tr>
            <td>Location:-{{$data->location}}</td>
            <td>Date of Occurrence:-{{$data->report_date}}</td>
            <td>Reviewed By:- {{$data->reviewed_by}}</td>
            <td>Reviewed at:-{{$data->reviewed_at}}</td>
        </tr>

        <tr>
            <td><h5>Details:</h5> {!!$data->report_details!!}</td>
            <td><h5>Action Taken:</h5> {{$data->action_taken}}</td>
            <td>Approved By:- {{$data->approved_by}}</td>
            <td>Approved at:-{{$data->approved_at}}</td>
        </tr>

        <tr>
            <td><h5>Response/Causes:</h5> {!! $data->response !!}</td>
            <td><h5>Proposed Remedial Actions :</h5> {{$data->remedial_actions}}</td>
            <td>Time of Occurrence:-{{$data->time}}</td>
        </tr>

        </tbody>
    </table><hr/>

@endsection
