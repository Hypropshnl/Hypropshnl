<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th><input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check" name="check_all" class="" /></th>
        <th>Name</th>
        <th>Cert Name</th>
        <th>Company Name</th>
        <th>Heading</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Design</th>
        <th>Preview Template</th>
        <th>Preview Logo</th>
        <th>Preview Stamp</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td><input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" /></td>
            <td>{{$data->name}}</td>
            <td>{{$data->cert_name}}</td>
            <td>{{$data->company_name}}</td>
            <td>{{$data->heading}}</td>
            <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
            <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <td><a class="btn btn-sm btn-primary" target="_blank" href="{{route('certificate_template_design', ['id' => $data->id])}}"><i class="fa fa-edit"></i> Design Template</a></td>
            <td>
                @if($data->template_doc)
                    <button id="file1_{{$data->id}}" type="button" class="btn btn-sm btn-primary" 
                    data-file-url="{{ asset('files/'.$data->template_doc) }}" onclick="previewFile('<?php echo 'file1_'.$data->id; ?>');">
                        <i class="fa fa-eye"></i> Preview
                    </button>
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </td>
            <td>
                @if($data->logo)
                    <button id="file2_{{$data->id}}" type="button" class="btn btn-sm btn-primary" 
                    data-file-url="{{ asset('files/'.$data->logo) }}" onclick="previewFile('<?php echo 'file2_'.$data->id; ?>');">
                        <i class="fa fa-eye"></i> Preview
                    </button>
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </td>
            <td>
                @if($data->stamp)
                    <button id="file3_{{$data->id}}" type="button" class="btn btn-sm btn-primary" 
                    data-file-url="{{ asset('files/'.$data->stamp) }}" onclick="previewFile('<?php echo 'file3_'.$data->id; ?>');">
                        <i class="fa fa-eye"></i> Preview
                    </button>
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </td>
            <td><a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_certificate_template_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="pagination pull-right">{!! $mainData->render() !!}</div>


