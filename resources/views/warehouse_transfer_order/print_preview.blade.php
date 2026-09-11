@extends('layouts.letter_head_internal')

@section('content')

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
            <td>Status</td>
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

@endsection