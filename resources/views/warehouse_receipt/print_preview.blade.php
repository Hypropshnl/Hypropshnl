@extends('layouts.letter_head_internal')

@section('content')

<table class="table-bordered table-hover table-striped">
        <thead></thead>
        <tbody>
        <tr>
            <td>Vendor: {{$po->vendorCon->name}}</td>
            <td>Vendor Invoice No.:{{$po->vendor_invoice_no}}</td>
            <td>Billing Address: {{$po->vendorCon->address}}</td>
            
        </tr>
        <tr>
            @php $poNumber = (empty($po->po_number) ? $po->id : $po->po_number) @endphp
            <td>PO Number: {{$poNumber}}</td>
            <td>Ship to city: {{$po->ship_to_city}}</td>
            <td>Ship to address: {{$po->ship_address}}</td>
        </tr>
        <tr>
        <td>Vendor Mails : {{$po->mails}}</td>
        <td>Mail Copy : {{$po->mail_copy}}</td>
        <td>Project : {{$po->project->project_name}}</td>
        </tr>

        </tbody>
    </table><hr/>

    <table class="table-bordered table-hover table-striped">
        <thead>
        <th>Warehouse</th>
        <th>Inventory Item</th>
        <th>Item Desc</th>
        <th>Quantity</th>
        <th>Quantity to receive</th>
        <th>Quantity to Cross-Dock</th>
        <th>Quantity Received</th>
        <th>Quantity Outstanding</th>
        <th>Unit of Measurement</th>
        <th>Status</th>
        <th>Created by</th>
        <th>Created at</th>
        <th>Updated by</th>
        <th>Updated at</th>
        </thead>
        <tbody>

            <td>{{$data->warehouse->name}}</td>
            <td>{{$data->inventory->item_name}}</td>
            <td>{{$data->poItem->po_desc}}</td>
            <td>{{$data->qty}}</td>
            <td>{{$data->qty_to_receive}}</td>
            <td>{{$data->qty_to_cross_dock}}</td>
            <td>{{$data->qty_received}}</td>
            <td>{{$data->qty_outstanding}}</td>
            <td>{{$data->unit_measurement}}</td>
            <td class="{{\App\Helpers\Utility::statusIndicator($data->work_status)}}">
                @if($data->work_status == Utility::STATUS_ACTIVE)
                    Complete
                @else
                    Processing
                @endif
            </td>
            <td>
                @if($data->created_by != '0')
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @endif
            </td>
            <td>{{$data->created_at}}</td>
            <td>
                @if($data->updated_by != '0')
                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                @endif
            </td>
            <td>{{$data->updated_at}}</td>

        </tbody>
    </table><hr/>


@endsection