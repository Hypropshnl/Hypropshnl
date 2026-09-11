<table class="table table-bordered table-hover table-striped tbl_scroll" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

        </th>
        <th>View</th>
        <th>Download MOA</th>
        <th>Download Bank Reference</th>
        <th>Download ISO</th>
        <th>Download HSE Policy</th>
        <th>Company Profile</th>
        <th>Name</th>
        <th>Contact Name</th>
        <th>Phone No</th>
        <th>Email</th>
        <th>Annual Turnover</th>
        <th>Approval Status</th>
        <th>Approved By</th>
        <th>Address</th>
        <th>Response Message(s)</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)

    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

        </td>
        <td>
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('vendor_pool_view') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-eye fa-2x"></i></a>
        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        
        <td>
            @if(!empty($data->memo))
            <a target="_blank" href="<?php echo URL::to('vendor_pool_download_attachment?file='); ?>{{$data->memo}}">
                <i class="fa fa-files-o fa-2x"></i>
            </a>
            <button id="file_1_{{$data->id}}" class="btn btn-outline-primary btn-view"
                    data-file-url="{{ asset('files/'.$data->memo) }}" onclick="previewFile('<?php echo 'file_1_'.$data->id; ?>');">
                <i class="fa fa-eye me-2"></i>
            </button>
            @endif
        </td>
        <td>
            @if(!empty($data->refrence_docs))
            <a target="_blank" href="<?php echo URL::to('vendor_pool_download_attachment?file='); ?>{{$data->refrence_docs}}">
                <i class="fa fa-files-o fa-2x"></i>
            </a>
            <button id="file_2_{{$data->id}}" class="btn btn-outline-primary btn-view"
                    data-file-url="{{ asset('files/'.$data->refrence_docs) }}" onclick="previewFile('<?php echo 'file_2_'.$data->id; ?>');">
                <i class="fa fa-eye me-2"></i>
            </button>
            @endif
        </td>
        <td>
            @if(!empty($data->hse_policy_docs))
            <a target="_blank" href="<?php echo URL::to('vendor_pool_download_attachment?file='); ?>{{$data->hse_policy_docs}}">
                <i class="fa fa-files-o fa-2x"></i>
            </a>
            <button id="file_3_{{$data->id}}" class="btn btn-outline-primary btn-view"
                    data-file-url="{{ asset('files/'.$data->hse_policy_docs) }}" onclick="previewFile('<?php echo 'file_3_'.$data->id; ?>');">
                <i class="fa fa-eye me-2"></i>
            </button>
            @endif
        </td>
        <td>
            @if(!empty($data->qa_docs))
            <a target="_blank" href="<?php echo URL::to('vendor_pool_download_attachment?file='); ?>{{$data->qa_docs}}">
                <i class="fa fa-files-o fa-2x"></i>
            </a>
            <button id="file_4_{{$data->id}}" class="btn btn-outline-primary btn-view"
                    data-file-url="{{ asset('files/'.$data->qa_docs) }}" onclick="previewFile('<?php echo 'file_4_'.$data->id; ?>');">
                <i class="fa fa-eye me-2"></i>
            </button>
            @endif
        </td>
        <td>
            @if(!empty($data->company_profile))
            <a target="_blank" href="<?php echo URL::to('vendor_pool_download_attachment?file='); ?>{{$data->company_profile}}">
                <i class="fa fa-files-o fa-2x"></i>
            </a>
            <button id="file_5_{{$data->id}}" class="btn btn-outline-primary btn-view"
                    data-file-url="{{ asset('files/'.$data->company_profile) }}" onclick="previewFile('<?php echo 'file_5_'.$data->id; ?>');">
                <i class="fa fa-eye me-2"></i>
            </button>
            @endif
        </td>
        <td>
            {{$data->company_name}}
        </td>
        <td>{{$data->contact_name}}</td>
        <td>{{$data->phone}}</td>
        <td>{{$data->email}}</td>
        <td>
            {{$data->annual_turnover}}
        </td>
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
            @if($data->deny_reason != '')
                Denied by {{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}
                    Reason: {{$data->deny_reason}}
            @endif
        </td>
        <td>{{$data->address}}</td>
        <td>
            @include('includes/general_response_view')
        </td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>

        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

    </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>