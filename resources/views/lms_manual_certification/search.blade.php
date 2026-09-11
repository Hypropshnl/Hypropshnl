<table class="table table-bordered table-hover table-striped">
    <thead>
    <tr>
        <th><input type="checkbox" onclick="toggleme(this,'kid_checkbox_search');" id="parent_check_search" name="check_all" class="" /></th>
        <th>Name</th>
        <th>Department</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="search_{{$data->id}}" class="kid_checkbox_search" />
        </td>
        <td>
            <a href="{{route('profile', ['uid' => $data->uid])}}">
                <span class="">{{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}</span>
            </a>
        </td>
        <td>{{$data->department->dept_name}}</td>
        <td>{{$data->email}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
