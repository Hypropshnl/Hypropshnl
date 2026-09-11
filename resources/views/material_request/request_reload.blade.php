<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

            </th>
            <th>Attachment</th>
            <th>Default Preview</th>
            <th>Assign</th>
            <th>MR Number</th>
            <th>Assigned User</th>
            <th>Due date</th>
            <th>Approval Status</th>
            <th>Approved by</th>
            <th>Response Message(s)</th>
            <th>Created by</th>
            <th>Updated by</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        @if($data->complete_status == 0)
            @if($data->approval_view == 1 && $data->deny_reason == '')
                @if($data->next_user == Auth::user()->id)
                    <tr>
                        <td scope="row">
                            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                        </td>
                        <td>
                            <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_material_request_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                        </td>
                        <td>
                            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('material_request_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Preview</a>
                        </td>
                        <td>
                            <a style="cursor: pointer;" onclick="fetchHtml2('{{$data->id}}','edit_mini_content','editMiniModal','<?php echo url('edit_material_request_mini_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                        </td>
                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                    
                        <td>{{$data->mr_number}}</td>
                        <td>{{$data->assigned->firstname}} {{$data->assigned->lastname}}</td>
                        <td>{{$data->due_date}}</td>
                        <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
                            @if($data->approval_status === 1)
                                Request Approved
                            @endif
                            @if($data->approval_status === 0)
                                Processing Request
                            @endif
                            @if($data->approval_status === 2)
                                Request Denied
                            @endif
                        </td>
                        <td>
                            @if($data->approved_users != '')
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                    <th>Name</th>
                                    <th>Reason</th>
                                    </thead>
                                    <tbody>
                                    @foreach($data->approved_by as $users)
                                        <tr>
                                            <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                                            <td>Approved</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        @if($data->deny_reason != '')
                                            <td>{{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}</td>
                                            <td>Denied: {{$data->deny_reason}}</td>
                                        @endif
                                    </tr>
                                    </tbody>
                                </table>
                            @endif
                        </td>
                        <td>
                            @include('includes/general_response_view')
                        </td>
                        <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
                        <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
                        <td>{{$data->created_at}} </td>
                        <td>{{$data->updated_at}}</td>
                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                        <input type="hidden" id="vendorDisplay" value="{{$data->vendor}}">

                    </tr>
                @endif
            @endif
        @endif
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>