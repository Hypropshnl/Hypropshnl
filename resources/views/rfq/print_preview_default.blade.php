@extends('layouts.letter_head_internal')

@section('content')
<div class="body">

    <table class="table-bordered ">
        <thead>
            <th ></th>
            <th></th>
        </thead>
        <tbody>
            @php $poMails = (!empty($po->mails)) ? explode(',', $po->mails) : [] @endphp
            @php $rfqNumber = (empty($po->rfq_no) ? $po->id : $po->rfq_no) @endphp
        <tr>
            <td><div >RFQ Number: {{$rfqNumber}}</div></td>
            <td>Project : {{$po->project->project_name}}</td>
        </tr>
        <tr>
            <td>Copy : {{$po->mail_copy}}</td>
            <td>Vendor Contact(s)</td>
        </tr>
        @foreach($poMails as $mail)
            <tr>
                <td></td>
                <td>{{$mail}}</td>
            </tr>
        @endforeach

        </tbody>
    </table><hr/>

    <table class="table-bordered">
        <thead>
        <td>Account Name</td>
        <td>Description</td>
        <td>Rate </td>
        </thead>
        <tbody>

        @foreach($poData as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_zname}}</td>
                    <td>{{$data->rfq_desc}}</td>
                    <td></td>
                </tr>
            @endif

        @endforeach

        </tbody>
    </table><hr/>

    <table class="table-bordered ">
        <thead>
        <td >Item</td>
        <td >Description</td>
        <td>Quantity</td>
        <td>Unit Measure</td>
        <td>Rate </td>
        </thead>
        <tbody>
        @foreach($poData as $data)
            @php $bomItem = (count($data->bomData) >0) ? 'Click to view Bill of Materials' : '' ; @endphp
            @if($data->item_id != '')
                <tr onclick="idDisplayClass('bom_{{$data->id}}');">
                    <td>
                        <div style="width:300px;">{{$data->inventory->item_name}} ({{$data->inventory->item_no}})</div>
                        <h6>{{$bomItem}}</h6>
                    </td>
                    <td><div style="width:300px;">{{$data->rfq_desc}}</div></td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->unit_measurement}}</td>
                    <td></td>
                </tr>
                @include('includes.display_bom_items',['bomData' => $data->bomData, 'data' => $data])
            @endif

        @endforeach
        </tbody>
    </table><hr/>

    <table class="table table-responsive">
        <thead><th></th></thead>
        <tbody>
        <tr>
            <td>{!!$po->message!!}</td>
        </tr>
        </tbody>
    </table>

    
</div>
@endsection