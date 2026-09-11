<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox_assigned');" id="parent_check_assigned"

                    name="check_all_assigned" class="" />
            </th>
            <th>Name</th>
            <th>Department</th>
            <th>Appraisal</th>
            <th>Profile</th>
        </tr>
    </thead>
    <tbody>

    @foreach($mainData as $data)
    <tr>
        <td scope="row">

            <input value="{{$data->user_id}}" type="checkbox" id="{{$data->id}}_assigned" class="kid_checkbox_assigned" />

        </td>

        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

        <td>
            <a href="{{route('profile', ['uid' => $data->userData->uid])}}">
                <span class="">{{$data->userData->title}}&nbsp;{{$data->userData->firstname}}&nbsp;{{$data->userData->othername}}&nbsp;{{$data->userData->lastname}}</span>
            </a>
        </td>
        <td>
            {{$data->department->dept_name}}
        </td>
        <td>
            <a target="_blank" href="{{route('okr_employee_appraisal_user_goal',
            ['userId' => $data->user_id,'deptId' => $data->userData->dept_id,'goalSetId' => $data->unit_goal_series_id])}}">Appraise Employee
            </a>
        </td>
        <td>
            <a href="{{route('profile', ['uid' => $data->userData->uid])}}" target="_blank"><span class="">View Profile</span></a>
        </td>
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

    </tr>
    @endforeach

    </tbody>

</table>