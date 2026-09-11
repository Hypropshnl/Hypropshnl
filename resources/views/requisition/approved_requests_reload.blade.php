<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

        </th>

        {{--<th>Manage</th>--}}
        <th>Preview</th>
        <th>Attachment</th>
        <th>Purchase Order</th>
        <th>Description</th>
        <th>Edited</th>
        <th>Response Message(s)</th>
        <th>Request Category</th>
        <th>Request Type</th>
        <th>Project Category</th>
        <th>Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Foreign Amount</th>
        <th>Transaction Type</th>
        <th>Material Request</th>
        <th>Requested by</th>
        <th>Department</th>
        <th>Approval Status</th>
        <th>Days with Finance</th>
        <th>Approved by</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        @php
        $financeDate = \Carbon\Carbon::parse($data->finance_date);
        $now = ($data->finance_status == Utility::STATUS_ACTIVE) ? $data->updated_at : now();
        $financeDays = (!empty($data->finance_date)) ? $financeDate->diffInDays($data->updated_at).' days' : '';
        $transType = (!empty($data->transaction_type)) ? $transactionTypes[$data->transaction_type] : 'Local';
        $foreignCurr = (Utility::currencyArrayItem('id') == $data->curr_id) ? '' : '('.$data->currencyDetail->code.')'.$data->currencyDetail->symbol;
        @endphp
        @if($data->complete_status == 1 && $data->finance_status == 1)
            @if($data->deny_reason == '')
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                @if($data->finance_status == \App\Helpers\Utility::STATUS_ACTIVE)
                    <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('request_print_preview') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o"></i>Preview</a>
                @endif
            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                @if(!empty($data->po_id))
                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->po_id}}','print_preview','printPreviewModal','<?php echo url('po_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Preview</a>
                @endif
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->req_desc}}</td>
            <td>
                @if($data->edit_request != '')
                    <?php $edited = json_decode($data->edit_request,true); ?>
                    @foreach($edited as $key => $val)
                        {{$key}} : {{$val}}<br>
                    @endforeach
                @endif
            </td>
            <td>
                @include('includes/general_response_view')
            </td>
            <td>{{$data->requestCat->request_name}}</td>
            <td>{{$data->requestType->request_type}}</td>
            <td>
                @if($data->proj_id != 0)
                    {{$data->project->project_name}}
                @endif
            </td>
            <td>{{Utility::numberFormat($data->amount)}}</td>
            <td>{{$foreignCurr}}{{Utility::numberFormat($data->foreign_amount)}}</td>
            <td>
                {{$transType}}
            </td>
            <td>{{$data->mrData->mr_number}}</td>
            <td>{{$data->requestUser->firstname}} &nbsp; {{$data->requestUser->lastname}}</td>
            <td>{{$data->department->dept_id}}</td>
            <td>
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
            <td>{{$financeDays}}</td>
            <td>
                @include('includes/approved_by')
            </td>
            <td>
                @if($data->created_by != '0')
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @endif
            </td>
            <td>
                @if($data->updated_by != '0')
                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                @endif
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
        @endif
        @endif
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>