<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th><input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check" name="check_all" class="" /></th>
        <th>Name</th>
        <th>Course</th>
        <th>Email</th>
        <th>View</th>
        <th>QR Code</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="{{$data->user_id}}_assigned" class="kid_checkbox" />
        </td>
        <td>
            @if($data->user_type == Utility::P_USER)
                <a href="{{route('profile', ['uid' => $data->userData->uid])}}">
                    <span class="">{{$data->userData->title}}&nbsp;{{$data->userData->firstname}}&nbsp;{{$data->userData->othername}}&nbsp;{{$data->userData->lastname}}</span>
                </a>
            @elseif($data->user_type == Utility::T_USER)
                <a href="{{route('temp_user_profile', ['id' => $data->userData->uid])}}">
                    <span class="">{{$data->userData->firstname}}&nbsp;{{$data->userData->lastname}}</span>
                </a>
            @endif
        </td>
        <td>{{$data->offlineCourse->goal_name}}</td>
        <td>{{$data->userData->email}}</td>
        <td>
            <a href="{{ route('view_lms_manual_certification_certificate', ['uid' => $data->uuid]) }}" target="_blank" class="btn btn-sm btn-primary">
                <i class="fa fa-eye"></i> View
            </a>
        </td>
        <td class="text-center">
            @if(!empty($data->uid))
                {!! QrCode::size(80)->generate(route('view_lms_manual_certification_certificate', ['uid' => $data->uid])) !!}
            @endif
        </td>
        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@if(!empty($mainData))
<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>
@endif
