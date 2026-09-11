<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

            </th>
            <th>Manage</th>
            <th>Attachment</th>
            <th>Name</th>
            <th>Course</th>
            <th>Category</th>
            <th>Status</th>
            <th>Created by</th>
            <th>Updated by</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Logo</th>
        </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

        </td>
        <td>
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_lms_topic_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
        <td>
            <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_lms_topic_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

        <td>{{$data->name}}</td>
        <td>{{$data->course->name}}</td>
        <td>{{$topicCategory[$data->category_id]}}</td>
        <td>
            @if($data->active_status == \App\Helpers\Utility::STATUS_ACTIVE)
                <span class="alert-success" style="color:white">ACTIVE</span>
            @else
                <span class="alert-danger" style="color:white">INACTIVE</span>
            @endif
        </td>
        <td>{{$data->user_c->firstname}} {{$data->user_c->firstname}}</td>
        <td>{{$data->user_u->updated_by}} {{$data->user_u->lastname}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>
        <td><img src="{{ asset('images/'.$data->photo) }}"  alt="User" /></td>
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

    </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>