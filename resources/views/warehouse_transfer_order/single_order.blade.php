@extends('layouts.letter_head')

@section('content')

<div class="container">
    <div class="row">
        <table class="table table-bordered table-hover table-striped" id="">
            <thead>
            <tr>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Transfer Order QR Code</td>
                <td>Inventory Item QR Code</td>
                
            <tr>                
                <td>@include('includes.qr_code_link',['dataId'=>$data->order_id, 'type' => 'warehouse'])</td>
                <td>@include('includes.qr_code_link',['dataId'=>$data->inventory_id, 'type' => 'inventory'])</td>
            </tr>
            </tbody>
        </table>
        
        <table class="table table-bordered table-hover table-striped" id="">
            <thead>
            <tr>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Order ID #</td>
                <td>{{$data->order_id}}</td>
            <tr>
                <td>Inventory Item</td>
                <td>{{$data->inventory->item_name}}&nbsp;({{$data->inventory->item_no}})</td>
            </tr>
            <tr>
                <td>Created By</td>            
                <td>{{$data->user_c->firstname}} &nbsp; {{$data->user_c->lastname}}</td>
            </tr>
            <tr>
                <td>Approved By</td>            
                <td>{{$data->approve_user->firstname}} &nbsp; {{$data->approve_user->lastname}}</td>
            </tr>
            <tr>
                <td>Approval Status</td>
                <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
                    {{Utility::approveStatus($data->approval_status)}}
                    
                </td>           
            </tr>
            <tr>
                <td>Order Status</td>
                <td class="{{\App\Helpers\Utility::statusIndicator($data->order_status)}}">
                    {{Utility::defaultStatus($data->order_status)}}
                    
                </td>           
            </tr>
            </tbody>
        </table>

        <table class="table table-bordered table-hover table-striped" id="">
            <thead>
            <tr>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Transfer Quantity</td>
                <td>{{$data->transfer_quantity}}</td>
            <tr>
                <td>Return Quantity</td>
                <td>{{$data->return_quantity}}</td>
            </tr> 
                <td>Post Date</td>
                <td>{{\App\Helpers\Utility::standardDate($data->created_at)}}</td>
            </tr>
            <tr>
                <td>Due Date</td>
                <td>{{\App\Helpers\Utility::standardDate($data->due_date)}}</td>
            </tr>
            </tbody>
        </table>



        <table class="table table-bordered table-hover table-striped" id="">
            <thead>
            <tr>

                <th>From Warehouse</th>
                <th>From Zone</th>
                <th>From Bin</th>

            </tr>
            </thead>
            <tbody>

            <tr>

                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>{{$data->fromWarehouse->name}} ({{$data->fromWarehouse->code}})</td>
                <td>{{$data->fromZone->name}}</td>
                <td>{{$data->fromBin->code}}</td>
                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
            </tbody>
        </table>
        
        

        <table class="table table-bordered table-hover table-striped" id="">
            <thead>
                @if($data->location_status == 1)
                    <tr>

                        <th>To Warehouse</th>
                        <th>To Zone</th>
                        <th>To Bin</th>

                    </tr>
                @else
                    <tr><th>Custom Location</th></tr>
                @endif
            </thead>
            <tbody>

            <tr>
                @if($data->location_status == 1)
                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                    <td>{{$data->toWarehouse->name}} ({{$data->toWarehouse->code}})</td>
                    <td>{{$data->toZone->name}}</td>
                    <td>{{$data->toBin->code}}</td>
                    <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                @else
                    <td>{{$data->custom_location}}</td>
                @endif
            </tr>
            </tbody>
        </table>

        <table class="table table-bordered table-hover table-striped" id="">
            <thead>
            <tr>

                <th>Return Warehouse</th>
                <th>Return Zone</th>
                <th>Return Bin</th>

            </tr>
            </thead>
            <tbody>

            <tr>

                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>{{$data->returnWarehouse->name}} ({{$data->returnWarehouse->code}})</td>
                <td>{{$data->returnZone->name}}</td>
                <td>{{$data->returnBin->code}}</td>
                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
            </tbody>
        </table>


    </div>

    @if($data->approval_status == Utility::APPROVED && $data->order_status == Utility::TICKET_STATUS[1] && $data->approval_status != Utility::DENIED)
    <div class="container row">
        <form name="" id="updateOrderMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group">
                                Return Quantity
                            <div class="form-line">
                                <input type="number" class="form-control" value="" name="return_quantity" placeholder="Return Quantity">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                                Order Status
                            <div class="form-line">
                                <select class="form-control" name="order_status" placeholder="order_status" required>
                                    <option value="{{$data->order_status}}">{{Utility::defaultStatus($data->order_status)}}</option>
                                    @foreach(Utility::TICKET_STATUS as $key => $var)
                                        <option value="{{$key}}">{{$var}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            Input Password (Request User)
                            <div class="form-line">
                                <input type="password" class="form-control" value="" name="password" placeholder="Password">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <input type="hidden" name="return_whse" value="{{$data->return_whse}}" >
            <input type="hidden" name="return_zone" value="{{$data->return_zone}}" >
            <input type="hidden" name="return_bin" value="{{$data->return_bin}}" >
            <input type="hidden" name="inventory_id" value="{{$data->inventory_id}}" >

            <input type="hidden" name="user_id" value="{{$data->created_by}}" >
            <input type="hidden" name="edit_id" value="{{$data->id}}" ><hr>

            <button type="button"  onclick="submitDefaultNoFormModal('updateOrderMainForm','<?php echo url('warehouse_transfer_order_update'); ?>','',
                    '','<?php echo csrf_token(); ?>')"
                    class="btn btn-info waves-effect">
                Update Transfer Order
            </button><hr>
        </form>
    </div>
    @else

    @endif

</div>

@endsection