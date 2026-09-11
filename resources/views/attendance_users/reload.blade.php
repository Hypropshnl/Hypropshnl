<table class="table table-bordered table-hover table-striped" id="main_table">

    <thead>

    <tr>

        <th>

            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_assigned');" id="parent_check_assigned"

                name="check_all" class="" />



        </th>
        <th>Name</th>
        <th>Time Schedule</th>
        <th>Department</th>
        <th>Email</th>
        <th>Gender</th>
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

            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}_assigned" class="kid_checkbox_assigned" />

        </td>

        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

        <td>

            <a href="{{route('profile', ['uid' => $data->userData->uid])}}">

                <span class="">{{$data->userData->title}}&nbsp;{{$data->userData->firstname}}&nbsp;{{$data->userData->othername}}&nbsp;{{$data->userData->lastname}}</span>

            </a>

        </td>
        <td>{{$data->schedule->name}}</td>
        <td>
                {{$data->department->dept_name}}
        </td>
        <td>{{$data->userData->email}}</td>

        <td>{{$data->userData->sex}}</td>
        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

    </tr>
    @endforeach

    </tbody>

</table>
@if(!empty($mainData))
<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>
@endif