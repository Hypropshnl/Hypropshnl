<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

            </th>

            <th>Name</th>
            <th>Clock In</th>
            <th>Comment In</th>
            <th>Clock In Photo</th>
            <th>Status</th>
            <th>Late/Shift Request</th>
            <th>Request Reason</th>
            <th>Clock Out</th>
            <th>Comment Out</th>
            <th>Clock Out Photo</th>
            <th>Day</th>
            <th>Date</th>
            <th>Work Hr(s)</th>
            <th>Over Time(hrs)</th>
            <th>Regular Hr(s)</th>
            <th>Time Schedule</th>
        </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
        <td>{{$data->clock_in}}</td>
        <td>{{$data->comment}}</td>
        <td><img src="{{ asset('images/'.$data->clock_in_photo) }}" class="" width="100" height="100"  alt="User" /></td>
        <td>{{Utility::ATTENDANCE_TIME_REQUEST[$data->attendance_status]}}</td>
        <td>{{Utility::ATTENDANCE_TIME_REQUEST[$data->timeRequest->type]}}</td>
        <td>{{$data->timeRequest->reason}}</td>
        <td>{{$data->clock_in}}</td>
        <td>{{$data->comment}}</td>
        <td><img src="{{ asset('images/'.$data->clock_in_photo) }}" class="" width="100" height="100"  alt="User" /></td>
        <td>{{Utility::getDay($data->day)}}</td>
        <td>{{$data->date}}</td>
        <td>{{$data->total_hours}}</td>
        <td>{{$data->overtime}}</td>
        <td>{{$data->regular_hours}}</td>
        <td>{{$data->schedule->name}}</td>
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
    </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>