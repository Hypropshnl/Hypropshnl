@extends('mail_views.mail_layout')

@section('content')

    <table>
        <thead>
            <th style="text-align: center;">
                <b>Quote Proposal</b>
            </th>
        </thead>
    </table>

    <table>
        <thead>
            <th>All responses/messages must be submitted exclusively via the link below. Email response/messages will not be accepted.</th>
        </thead>
        <tbody>
            <tr>
                <td><a href='{{$quoteResponseUrl}}'>Click here to Respond</a></td>
            </tr>
            <tr>
                <td><a href='{{$quoteResponseUrl}}'>{{$quoteResponseUrl}}</a></td>
            </tr>
        </tbody>
    </table>

    <table class="table table-responsive">
        <thead><th></th></thead>
        <tbody>
        <tr>
            <td>Message: {{$itemDetail->custom_message}}</td>
        </tr>
        </tbody>
    </table>

    <table class="table table-responsive">
        <thead></thead>
        <tbody>
        <tr>
            <td>RFQ Number: {{$itemDetail->rfqDetail->rfq_no}}</td>
            <td></td>
        </tr>
        </tbody>
    </table><hr/>

    <table class="table table-responsive">
        <thead>
            <td>Account Name</td>
            <td>Description</td>
            <td>Rate ({{$itemDetail->currencyData->code}}){{$itemDetail->currencyData->symbol}}</td>
            <td>Sub Total ({{$itemDetail->currencyData->code}}){{$itemDetail->currencyData->symbol}}</td>
        </thead>
        <tbody>

        @foreach($itemComponents as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_name}}</td>
                    <td>{{$data->rfqDetail->rfq_desc}}</td>
                    <td>{{$data->rate}}</td>
                    <td>{{$data->amount}}</td>
                </tr>
            @endif

        @endforeach

        </tbody>
    </table><hr/>

    <table class="table table-responsive">
        <thead>
        <td>Item</td>
        <td>Description</td>
        <td>Quantity</td>
        <td>Unit Measure</td>
        <td>Rate ({{$itemDetail->currencyData->code}}){{$itemDetail->currencyData->symbol}}</td>
        <td>Sub Total ({{$itemDetail->currencyData->code}}){{$itemDetail->currencyData->symbol}}</td>
        </thead>
        <tbody>
        @php $totalSum = 0; @endphp
        @foreach($itemComponents as $data)
            @php $bomItem = (!empty($data->bomData)) ? 'Click to view Bill of Materials' : '' ; @endphp
            @if($data->item_id != '' && !empty($data->rate) && $data->rate >= 0)
            @php $totalSum += $data->amount; @endphp
                <tr onclick="idDisplayClass('bom_{{$data->id}}');">
                    <td>
                        {{$data->itemData->item_name}} ({{$data->itemData->item_no}})
                        <h6>{{$bomItem}}</h6>
                    </td>
                    <td>{{$data->item_desc}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->rfqDetail->unit_measurement}}</td>
                    <td>{{Utility::numberFormat($data->rate)}}</td>
                    <td>{{Utility::numberFormat($data->amount)}}</td>
                </tr>
                @include('includes.display_bom_items',['bomData' => $data->bomData, 'data' => $data])
            @endif
                
        @endforeach
            <tr><td></td><td></td><td></td><td></td><td>Discount({{$itemDetail->discount_perct}}%):</td><td>{{Utility::numberFormat($itemDetail->discount)}}</td></tr>
            <tr><td></td><td></td><td></td><td></td><td>Tax({{$itemDetail->tax_perct}}%):</td><td>{{Utility::numberFormat($itemDetail->tax)}}</td></tr>
            <tr><td></td><td></td><td></td><td></td><td>Total Sum:</td><td>{{Utility::numberFormat($totalSum)}}</td></tr>
        </tbody>
    </table><hr/>

    

    
    


@endsection