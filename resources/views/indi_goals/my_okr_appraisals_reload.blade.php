<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

            </th>

            <th>Unit Goal Set</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Employee Deadline</th>
            <th>Reviewer Deadline</th>
            <th>Manage</th>
            <th>Survey</th>
        </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td><a href="{{route('okr_employee_appraisal_user_goal',
            ['userId' => Auth::user()->id,'deptId' => Auth::user()->dept_id,'goalSetId' => $data->id])}}">{{$data->goal_name}}
            </a>
        </td>
        <td>{{$data->start_date}}</td>
        <td>{{$data->end_date}}</td>
        <td>{{$data->employee_deadline}}</td>
        <td>{{$data->reviewer_deadline}}</td>
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>
            <a class="btn btn-info" href="{{route('okr_employee_appraisal_user_goal',
            ['userId' => Auth::user()->id,'deptId' => Auth::user()->dept_id,'goalSetId' => $data->id])}}">Manage
            </a>
        </td>
        <td>
            @if(!empty($data->survey_id))
            <a class="btn btn-default"
            href="{{ url('survey_form/'.$data->surveyData->survey_id.'/'.$data->survey_id.\App\Helpers\Utility::authLink('temp_user')) }}">
            Take Survey
            </a>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>