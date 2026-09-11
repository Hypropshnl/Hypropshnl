    <table class="table table-bordered table-hover table-striped tbl_order" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Attachment</th>
        <th>Preview</th>
        <th>Order ID</th>
        <th>Item</th>
        <th>Description</th>
        <th>Transfer Quantity</th>
        <th>Return Quantity</th>
        <th>Approval Status</th>
        <th>Order Status</th>
        <th>QrCode</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
    @if($data->created_by == Auth::user()->id ||in_array(Auth::user()->role,Utility::TOP_USERS) || $data->fromWarehouse->whse_manager == Auth::user()->id)
    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

        </td>
        <td>
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_warehouse_transfer_order_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
        <td>
            <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('warehouse_transfer_order_edit_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
        <td>
            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('warehouse_transfer_order_request_print_preview') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o"></i>Preview</a>
            
        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>{{$data->order_id}}</td>
        <td>
            <a href="{{route('warehouse_transfer_order_profile', ['order_id' => $data->order_id])}}" target="_blank">
                <span class="">{{$data->inventory->item_name}}&nbsp;{{$data->inventory->item_no}}</span>
            </a>
        </td>
        <td>{{$data->description}}</td>
        <td>{{$data->transfer_quantity}}</td>
        <td>{{$data->return_quantity}}</td>
        <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
            {{Utility::approveStatus($data->approval_status)}}
        </td>
        <td class="{{\App\Helpers\Utility::statusIndicator($data->order_status)}}">
            {{Utility::defaultStatus($data->order_status)}}
        </td>                                
        <td>@include('includes.qr_code_link',['dataId'=>$data->order_id, 'type' => 'warehouse'])</td>
        <td>{{$data->user_c->firstname}} &nbsp; {{$data->user_c->lastname}}</td>
        <td>{{$data->user_u->firstname}} &nbsp; {{$data->user_u->lastname}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>
        
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

    </tr>
    @endif
    @endforeach
    </tbody>
</table>
<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>

<script>
    $('.tbl_order').on('scroll', function () {
        $(".tbl_order > *").width($(".tbl_order").width() + $(".tbl_order").scrollLeft());
    });
</script>