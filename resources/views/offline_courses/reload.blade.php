<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th><input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check" name="check_all" class="" /></th>
        <th>Title</th>
        <th>Template</th>
        <th>Location</th>
        <th>Name One</th>
        <th>Name One Role</th>
        <th>Name Two</th>
        <th>Name Two Role</th>
        <th>Name One Sign</th>
        <th>Name Two Sign</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td><input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" /></td>
            <td>{{$data->title}}</td>
            <td>{{$data->certificateTemplate->name}}</td>
            <td>{{$data->location}}</td>
            <td>{{$data->name_one}}</td>
            <td>{{$data->name_one_role}}</td>
            <td>{{$data->name_two}}</td>
            <td>{{$data->name_two_role}}</td>
            <td>
                @if(!empty($data->name_one_sign))
                    <button id="file1_{{$data->id}}" type="button" class="btn btn-sm btn-primary" 
                    data-file-url="{{ asset('files/'.$data->name_one_sign) }}" onclick="previewFile('<?php echo 'file1_'.$data->id; ?>');">
                        <i class="fa fa-eye"></i> Preview
                    </button>
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </td>
            <td>
                @if(!empty($data->name_two_sign))
                    <button id="file2_{{$data->id}}" type="button" class="btn btn-sm btn-primary" 
                    data-file-url="{{ asset('files/'.$data->name_two_sign) }}" onclick="previewFile('<?php echo 'file2_'.$data->id; ?>');">
                        <i class="fa fa-eye"></i> Preview
                    </button>
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </td>
            <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
            <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <td><a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_offline_course_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="pagination pull-right">{!! $mainData->render() !!}</div>
