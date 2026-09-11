@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">All Comments</h4>
                </div>
                <div class="modal-body" id="edit_content" style="height:500px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Comment</h4>
                </div>
                <div class="modal-body" id="comment_content" style="height:400px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="convertModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Convert</h4>
                </div>
                <div class="modal-body" id="convert_content" style="height:500px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormClass('convertModal','convertQuoteForm','<?php echo url('rfq_bid_report_convert'); ?>','',
                            '','<?php echo csrf_token(); ?>',[
                            'inv_class_edit','item_desc_edit','warehouse_edit','quantity_edit','unit_cost_edit','unit_measure_edit',
                            'quantity_reserved_edit','quantity_received_edit','planned_edit','expected_edit','promised_edit','b_order_no_edit',
                            'b_order_line_no_edit','ship_status_edit','status_comment_edit','tax_edit','tax_perct_edit','tax_amount_edit',
                            'discount_perct_edit','discount_amount_edit','sub_total_edit','acc_class_edit','acc_desc_edit','acc_rate_edit',
                            'acc_tax_edit','acc_tax_perct_edit','acc_tax_amount_edit','acc_discount_perct_edit','acc_discount_amount_edit',
                            'acc_sub_total_edit','store_edit'
                            ],'mail_message_quote')"
                            class="btn btn-info waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

   
    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        RFQ Comparism Dashboard
                        @if(!empty($rfqReport) && $rfqReport->approval_status == Utility::STATUS_ACTIVE)
                         <button class="btn btn-success">Approved</button>
                        @endif
                    </h2>
                    
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <a class="btn btn-info" href="{{url('rfq_vendor_bids')}}">Back to RFQ Bids</a>
                        </li>
                        <li>
                            @if($rfqMain->created_by == Auth::user()->id || $rfqMain->assigned_user == Auth::user()->id)
                            <button class="btn btn-success" onclick="submitDefaultNoFormModal('submitApprovalForm','<?php echo url('rfq_bid_report_submit'); ?>','',
                            '','<?php echo csrf_token(); ?>')"><i class="fa fa-plus"></i>Submit for Approval</button>
                            @else
                            <a class="btn btn-info" href="{{url('rfq_bid_report_requests')}}">Back to Approval</a>
                            @endif
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>

                    </ul>
                </div>
                <div class=" " id="reload_data">
                                                            
                    <div class="table-container">
                        <div class="controls">
                            <div class="table-title">RFQ Information</div>
                            <div class="scroll-buttons">
                                <button id="" onclick="editForm('{{$rfqMain->id}}','edit_content','<?php echo url('rfq_bid_report_all_comments') ?>','<?php echo csrf_token(); ?>')" >View All Comments</button>
                                <button id="scroll-left" disabled>&larr; Scroll Left</button>
                                <button id="scroll-right">Scroll Right &rarr;</button>
                            </div>
                        </div>
                        
                        <div class="bid-table table-wrapper">
                            <div class="fixed-columns">
                                <table id="fixed-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="row clearfix">
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <div class="">
                                                                <select class="" name="" id=""><option value="">Item Details</option></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <div class="">
                                                                <input type="checkbox" disabled class="form-control" name="risk_description">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="fixed-body">
                                        
                                            <tr>
                                                <td>
                                                    <table>
                                                        <thead>
                                                            <th>Item</th>
                                                            <th>Quantity</th>
                                                            <th>Description</th>
                                                        </thead>
                                                        <tbody>
                                                            @php  $totalItems = 0; @endphp
                                                            @foreach ($rfqDetails as $data)
                                                            <tr>
                                                                @php  $totalItems+=$data->quantity; @endphp
                                                                <td>{{$data->inventory->item_name}} ({{$data->inventory->item_no}})</td>
                                                                <td>
                                                                    <input type="number" readonly class="form-control" value="{{$data->quantity}}">
                                                                </td>
                                                                <td>{{$data->rfq_desc}}</td>
                                                            </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td>Sub Total</td>
                                                                <td>
                                                                    <input type="number" name="" readonly class="form-control" >

                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                
                                                                <td>Discount</td>
                                                                <td>
                                                                    <input type="number" readonly class="form-control" value="">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                
                                                                <td>Tax</td>
                                                                <td>
                                                                    <input type="number" readonly class="form-control" value="">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                
                                                                <td>Total Items</td>
                                                                <td>
                                                                    <input type="number" readonly class="form-control" value="{{$totalItems}}">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Submitted @ </td>
                                                                <td>Email</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-sm-12">
                                                                        <select  class="form-control" disabled >
                                                                        </select>
                                                                            
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                   
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                
                                            </tr>
                                            
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="scrollable-columns">
                                <table id="scrollable-table">
                                    <thead>
                                        <tr id="head_tr">
                                            <th>
                                                <form onsubmit="false;" class="form form-horizontal form_suggest" method="post" enctype="multipart/form-data">
                                                <select class="" name="vendor" id=""><option selected value="">suggestion</option></select>
                                                <input type="hidden" name="check">
                                                </form>
                                            </th>
                                            @foreach ($rfqBid as $data)
                                            @php $checkStatus = ($data->selected_status == Utility::STATUS_ACTIVE) ? 'checked' : ''; @endphp
                                                <form onsubmit="false;" class="form form-horizontal form_main_{{$data->id}}" method="post" enctype="multipart/form-data">
                                                    <th>
                                                        <div class="row clearfix">
                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <div class="">
                                                                        <select name="select" class="" >
                                                                            <option value="{{$data->name}}">{{$data->name}}({{$data->currencyData->code}}({{$data->currencyData->symbol}}))</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <div class="">
                                                                        <input type="checkbox" {{$checkStatus}} class="form-control" name="check">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if($customQuotes->count() < 1)
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    @if($loop->last)
                                                                    <i id="btn_remove" onclick="addTableColumn('#scrollable-table thead #head_tr','#scrollable-table tbody #body_tr','#scrollable-table thead #btn_remove','{{$rfqMain->id}}','<?php echo url('rfq_bid_report_add_column'); ?>',500)"
                                                                    style="color:green" class="add-column-btn fa fa-plus-circle fa-2x pull-right"></i>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        
                                                    </th>
                                                </form>
                                            @endforeach

                                            <!-- CUSTOM QUOTES NOT SUBMITTED BY VENDORS -->
                                            @foreach ($customQuotes as $data)
                                            @php $checkStatus = ($data->selected_status == Utility::STATUS_ACTIVE) ? 'checked' : ''; @endphp
                                            <form onsubmit="false;" class="form form-horizontal form_custom_{{$data->id}}" method="post" enctype="multipart/form-data">
                                                <th>
                                                    <div class="row clearfix">
                                                        <div class="col-sm-8">
                                                            <div class="form-group">
                                                                <div class="">
                                                                    <select class="" name="vendor">
                                                                        <option value="{{$data->name}}">{{$data->name}}({{$data->currencyData->code}}({{$data->currencyData->symbol}}))</option>
                                                                        @if (!empty($rfqBid))
                                                                            @foreach($rfqBid as $val)
                                                                                <option value="{{$val->name}}">{{$val->name}}({{$val->email}})</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <div class="">
                                                                    <input type="checkbox" {{$checkStatus}} class="form-control" name="check">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($rfqMain->created_by == Auth::user()->id || $rfqMain->assigned_user == Auth::user()->id)
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                @if($loop->last)
                                                                <i id="btn_remove" onclick="addTableColumn('#scrollable-table thead #head_tr','#scrollable-table tbody #body_tr','#scrollable-table thead #btn_remove','{{$rfqMain->id}}','<?php echo url('rfq_bid_report_add_column'); ?>',500)"
                                                                style="color:green" class="add-column-btn fa fa-plus-circle fa-2x pull-right"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    
                                                </th>
                                            </form>
                                            @endforeach
                                            <!-- END OF CUSTOM QUOTES NOT SUBMITTED BY VENDORS -->
                                        </tr>
                                    </thead>
                                    <tbody id="scrollable-body">
                                        
                                        <tr id="body_tr">
                                            <td>
                                                
                                                <table>
                                                    <thead>
                                                        <th>Vendor</th>
                                                        <th>Unit Price</th>
                                                        <th>Amount</th>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        @php  $totalAmount = 0; @endphp
                                                        @foreach ($suggestData as $item)
                                                        @php  $totalAmount+= $item->amount; @endphp
                                                            <tr>
                                                                <td>{{$item->bidDetail->name}}</td>
                                                                <td>
                                                                    <form onsubmit="false;" class="form form-horizontal form_suggest" method="post" enctype="multipart/form-data">
                                                                    {{number_format((float)$item->rate, 2)}}
                                                                    <input type="hidden" name="unit_price[]" class="form-control" value="{{$item->rate}}">
                                                                    <input type="hidden" name="item_id[]" class="form-control" value="{{$item->item_id}}">
                                                                    <input type="hidden" name="qty[]" class="form-control" value="{{$item->quantity}}">
                                                                    <input type="hidden" name="item_desc[]" class="form-control" value="{{$item->item_desc}}">
                                                                    </form>
                                                                </td>
                                                                <td>
                                                                    <form onsubmit="false;" class="form form-horizontal form_suggest" method="post" enctype="multipart/form-data">
                                                                    <input type="text" name="" readonly class="form-control" value="{{number_format((float)$item->amount, 2)}}">
                                                                    <input type="hidden" name="item_amount[]" readonly class="form-control" value="{{$item->amount}}">
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            
                                                        @endforeach
                                                            <tr>
                                                                <td></td>
                                                                <td>Sub Total</td>
                                                                <td>
                                                                    <input type="text" name="" readonly class="form-control" value="{{number_format((float)$totalAmount, 2)}}">
                                                                    <input type="hidden" name="sub_total" readonly class="form-control" value="{{$totalAmount}}">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>Discount (%)</td>
                                                                <td>
                                                                    <form onsubmit="false;" class="form form-horizontal form_suggest" method="post" enctype="multipart/form-data">
                                                                    <input type="number" name="discount" readonly class="form-control" value="0">
                                                                    <input type="hidden" name="discount_perct" readonly class="form-control" value="0">
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>Tax (%)</td>
                                                                <td>
                                                                    <form onsubmit="false;" class="form form-horizontal form_suggest" method="post" enctype="multipart/form-data">
                                                                    <input type="number" name="tax" readonly class="form-control" value="0">
                                                                    <input type="hidden" name="tax_perct" readonly class="form-control" value="0">
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>Grand Total</td>
                                                                <td>
                                                                    <form onsubmit="false;" class="form form-horizontal form_suggest" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="grand_total" class="form-control" value="{{$totalAmount}}">
                                                                    <input type="text" name="" readonly class="form-control" value="{{number_format((float)$totalAmount, 2)}}">
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>No Date </td>
                                                                <td>No Email</td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>
                                                                    <form onsubmit="false;" class="form form-horizontal form_suggest" method="post" enctype="multipart/form-data">
                                                                    <div class="col-sm-12">
                                                                        <select  class="form-control show-tick" multiple id="" name="vendors[]" data-selected-text-format="count">
                                                                            <option value="0">Select Vendor(s)</option>
                                                                            @if (!empty($rfqBid))
                                                                                @foreach($rfqBid as $val)
                                                                                    <option value="{{$val->email}}">{{$val->name}}({{$val->email}})</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                    </form>
                                                                </td>
                                                                <td>
                                                                    
                                                                </td>
                                                            </tr>
                                                        
                                                            <tr>
                                                                <td></td>
                                                                <td>
                                                                    <form onsubmit="false;" class="form form-horizontal form_suggest" method="post" enctype="multipart/form-data">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-line">
                                                                            <textarea rows="10" cols="50" type="text" class="form-control" name="comment" placeholder="Comment"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" value="{{$rfqMain->id}}" name="rfqId" />
                                                                    </form>
                                                                </td>
                                                                <td>
                                                                    @if($rfqMain->assigned_user == Auth::user()->id || $rfqMain->created_by == Auth::user()->id)
                                                                    <button onsubmit="false" onclick="submitDefaultClassNoModal('form_suggest','<?php echo url('rfq_bid_report_create'); ?>','','','<?php echo csrf_token(); ?>')"
                                                                     class=" btn-info btn btn-sm">Save & Send</button>
                                                                    @else
                                                                    <button class="btn btn-default" disabled></button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>
                                                                    <button class="btn btn-default btn-sm" disabled >None</button>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-default btn-sm" disabled >None</button>
                                                                </td>
                                                            </tr>
                                                    </tbody>
                                                </table>
                                                
                                            </td>

                                            @foreach ($rfqBid as $data)
                                            
                                                <td>
                                                    <table>
                                                        <thead>
                                                            <th>Unit Price</th>
                                                            <th>Amount</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data->itemMany as $item)
                                                                <tr>
                                                                    <td>
                                                                        @php $itemRateMain = ($item->rate <= 0) ? '' : $item->rate; @endphp
                                                                        {{number_format((float)$itemRateMain, 2)}}
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" readonly class="form-control" value="{{number_format((float)$item->amount, 2)}}">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                                <tr>
                                                                    <td>Sub Total</td>
                                                                    <td>
                                                                        <input type="text" readonly class="form-control" value="{{number_format((float)$data->sub_total, 2)}}">

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Discount ({{$data->discount_perct}}%)</td>
                                                                    <td>
                                                                        <input type="text" readonly class="form-control" value="{{number_format((float)$data->discount, 2)}}">
                                                                        <input type="hidden" name="discount_perct" readonly class="form-control" value="{{$data->discount_perct}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tax ({{$data->tax_perct}}%)</td>
                                                                    <td>
                                                                        <input type="text" readonly class="form-control" value="{{number_format((float)$data->tax, 2)}}">
                                                                        <input type="hidden" name="tax_perct" readonly class="form-control" value="{{$data->tax_perct}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Grand Total</td>
                                                                    <td>
                                                                        @php $totalAmountMain = ($data->total_amount <= 0) ? '' : number_format((float)$data->total_amount, 2); @endphp
                                                                        <input type="hidden"  value="{{$data->total_amount}}">
                                                                        <input type="text" readonly class="form-control" value="{{$totalAmountMain}}">

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{$data->created_at}}</td>
                                                                    <td>{{$data->email}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-sm-12">
                                                                            <select  class="form-control" disabled >
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <form onsubmit="false;" class="form_main_{{$data->id}} form form-horizontal" method="post" enctype="multipart/form-data">
                                                                            
                                                                            <div class="col-sm-12">
                                                                                <div class="form-line">
                                                                                    <textarea rows="10" cols="50" type="text" class="form-control" name="comment" placeholder="Comment"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" value="{{$data->id}}" name="rfq_bid_id" />
                                                                            <input type="hidden" value="{{$rfqMain->id}}" name="rfq_id" />
                                                                            <input type="hidden" value="{{$data->email}}" name="vendor_mail" />
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                    @if($rfqMain->assigned_user == Auth::user()->id || $rfqMain->created_by == Auth::user()->id)
                                                                        <button class="btn btn-info btn-sm" onclick="submitDefaultClassNoModal('form_main_{{$data->id}}','<?php echo url('rfq_bid_report_update'); ?>','','','<?php echo csrf_token(); ?>')"
                                                                        >Save and Send</button>
                                                                    @else
                                                                    <button class="btn btn-default" disabled></button>
                                                                    @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-info btn-sm"  onclick="fetchHtml('{{$data->id}}','comment_content','commentModal','<?php echo url('rfq_bid_report_comments') ?>','<?php echo csrf_token(); ?>')">Show Comments</button>
                                                                    </td>
                                                                    <td>
                                                                        @if($data->selected_status == Utility::STATUS_ACTIVE && ($rfqMain->created_by == Auth::user()->id || $rfqMain->assigned_user == Auth::user()->id) && !empty($rfqReport) && $rfqReport->approval_status == Utility::STATUS_ACTIVE)
                                                                        <button class="btn btn-info btn-sm" onclick="fetchHtml2('{{$data->id}}','convert_content','convertModal','<?php echo url('rfq_bid_report_convert_form') ?>','<?php echo csrf_token(); ?>')">
                                                                            Convert Quote to PO
                                                                        </button>
                                                                        @else
                                                                        <button disabled class="btn btn-default btn-sm">Convert Quote to PO</button>
                                                                        @endif
                                                                    </td>
                                                                    
                                                                </tr>

                                                        </tbody>
                                                    </table>
                                                </td>
                                            @endforeach

                                             <!-- CUSTOM QUOTES NOT SUBMITTED BY VENDORS -->
                                            @foreach ($customQuotes as $data)
                                                <td>
                                                    <table>
                                                        <thead>
                                                            <th>Unit Price</th>
                                                            <th>Amount</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data->customMany as $item)
                                                                <tr>
                                                                    <td>
                                                                        @php $itemRate = ($item->rate <= 0) ? '' : $item->rate; @endphp
                                                                        {{number_format((float)$itemRate,2)}}
                                                                        <input type="hidden" name="item_rate[]" class="form-control" value="{{$item->rate}}">
                                                                        <input type="hidden" name="item_id[]" class="form-control" value="{{$item->item_id}}">
                                                                        <input type="hidden" name="item_qty[]" class="form-control" value="{{$item->quantity}}">
                                                                    </td>
                                                                    <td>
                                                                        @php $itemAmount = ($item->amount <= 0) ? '' : $item->amount; @endphp
                                                                        <input type="hidden" name="item_amount[]" value="{{$item->amount}}">
                                                                        <input type="text" name="" readonly class="form-control" value="{{$itemAmount}}">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                                <tr>
                                                                    <td>Sub Total</td>
                                                                    <td>
                                                                        <input type="text" name="" readonly class="form-control" value="{{number_format((float)$data->sub_total,2)}}">
                                                                        <input type="hidden" name="sub_total" readonly class="form-control" value="{{$data->sub_total}}">

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Discount ({{$data->discount_perct}}%)</td>
                                                                    <td>
                                                                        <input type="hidden" name="discount" readonly class="form-control" value="{{$data->discount}}">
                                                                        <input type="text" name="" readonly class="form-control" value="{{number_format((float)$data->discount,2)}}">
                                                                        <input type="hidden" name="discount_perct" readonly class="form-control" value="{{$data->discount_perct}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tax ({{$data->tax_perct}}%)</td>
                                                                    <td>
                                                                        <input type="text" name="" readonly class="form-control" value="{{number_format((float)$data->tax,2)}}">
                                                                        <input type="hidden" name="tax" class="form-control" value="{{$data->tax}}">
                                                                        <input type="hidden" name="tax_perct" readonly class="form-control" value="{{$data->tax_perct}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Grand Total</td>
                                                                    <td>
                                                                        @php $totalAmountCustom = ($data->total_amount <= 0) ? '' : number_format((float)$data->total_amount, 2); @endphp
                                                                        <input type="hidden" name="grand_total"  value="{{$data->total_amount}}">
                                                                        <input type="text" name="" readonly class="form-control" value="{{$totalAmountCustom}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{$data->created_at}}</td>
                                                                    <td>{{$data->email}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                    <form onsubmit="false;" class="form form-horizontal form_custom_{{$data->id}}" method="post" enctype="multipart/form-data">
                                                                        @php $vendorMails = json_decode($data->vendor_mails); @endphp
                                                                        <div class="col-sm-12">
                                                                            <select  class="form-control show-tick" multiple id="" name="vendors[]" data-selected-text-format="count">
                                                                                <option value="">Select Vendor(s)</option>
                                                                                @if (!empty($vendorMails))
                                                                                    @foreach($vendorMails as $mail)
                                                                                        <option value="{{$mail}}">{{$mail}}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                                
                                                                        </div>
                                                                    </form>
                                                                    </td>
                                                                    <td>
                                                                        
                                                                    </td>
                                                                </tr>
                                                            
                                                                <tr>
                                                                    <td>
                                                                        <form onsubmit="false;" class="form_custom_{{$data->id}} form form-horizontal" method="post" enctype="multipart/form-data">
                                                                            
                                                                            <div class="col-sm-12">
                                                                                <div class="form-line">
                                                                                    <textarea rows="10" cols="50" type="text" class="form-control" name="comment" placeholder="Comment"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" value="{{$data->id}}" name="rfq_bid_id" />
                                                                            <input type="hidden" value="{{$rfqMain->id}}" name="rfq_id" />
                                                                            <input type="hidden" value="{{$data->email}}" name="vendor_mail" />
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        @if($rfqMain->assigned_user == Auth::user()->id || $rfqMain->created_by == Auth::user()->id)
                                                                        <button onsubmit="false" class="btn btn-info btn-sm" onclick="submitDefaultClassNoModal('form_custom_{{$data->id}}','<?php echo url('rfq_bid_report_update'); ?>','','','<?php echo csrf_token(); ?>')"
                                                                        >Save and Send</button>
                                                                        @else
                                                                        <button class="btn btn-default" disabled></button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-info btn-sm" onclick="fetchHtml('{{$data->id}}','comment_content','commentModal','<?php echo url('rfq_bid_report_comments') ?>','<?php echo csrf_token(); ?>')">Show Comments</button>
                                                                    </td>
                                                                    <td>
                                                                        @if($data->selected_status == Utility::STATUS_ACTIVE && ($rfqMain->created_by == Auth::user()->id || $rfqMain->assigned_user == Auth::user()->id) && !empty($rfqReport) && $rfqReport->approval_status == Utility::STATUS_ACTIVE)
                                                                        <button class="btn btn-info btn-sm" onclick="fetchHtml2('{{$data->id}}','convert_content','convertModal','<?php echo url('rfq_bid_report_convert_form') ?>','<?php echo csrf_token(); ?>')">
                                                                            Convert Quote to PO
                                                                        </button>
                                                                        @else
                                                                        <button disabled class="btn btn-default btn-sm">Convert Quote to PO</button>
                                                                        @endif
                                                                    </td>
                                                                    
                                                                </tr>

                                                        </tbody>
                                                    </table>
                                                </td>
                                            @endforeach
                                             <!-- END OF CUSTOM QUOTES NOT SUBMITTED BY VENDORS -->
                                        </tr>
                                                                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><hr>

                   
                    
                    <div class="footer">
                        <p>Quote analysis for vendors</p>
                    </div>


                </div>
                 <div class="row">
                    <form name="submitApprovalForm" id="submitApprovalForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" value="{{$rfqMain->id}}" name="rfq_id" placeholder="">
                        <div class="col-sm-12">
                            <b>Decision After Analysis</b>
                            <div class="form-line">
                                <textarea rows="10" cols="50" type="text" class="form-control" name="decision" placeholder="Decision After Analysis">{{ $reportDecision }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- #END OF TABLE BODY -->
            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>
    

    $(document).ready(function() {
        $('.vendor_multi_select').multiselect({
        buttonWidth: '100%' // Set width to 100% of its parent
        });
        // Horizontal scroll buttons functionality
        $('#scroll-right').on('click', function() {
            const scrollableTable = $('.scrollable-columns');
            const currentScroll = scrollableTable.scrollLeft();
            const scrollAmount = 500;
            
            scrollableTable.animate({
                scrollLeft: currentScroll + scrollAmount
            }, 300);
            
            updateScrollButtons();
        });
        
        $('#scroll-left').on('click', function() {
            const scrollableTable = $('.scrollable-columns');
            const currentScroll = scrollableTable.scrollLeft();
            const scrollAmount = 500;
            
            scrollableTable.animate({
                scrollLeft: currentScroll - scrollAmount
            }, 300);
            
            updateScrollButtons();
        });
        
        // Update scroll buttons state based on scroll position
        function updateScrollButtons() {
            const scrollableTable = $('.scrollable-columns');
            const scrollLeft = scrollableTable.scrollLeft();
            const maxScroll = scrollableTable[0].scrollWidth - scrollableTable.width();
            
            $('#scroll-left').prop('disabled', scrollLeft <= 0);
            $('#scroll-right').prop('disabled', scrollLeft >= maxScroll - 10); // Small buffer for rounding errors
        }
        
        // Initial button state
        updateScrollButtons();
        
        // Update buttons on scroll
        $('.scrollable-columns').on('scroll', updateScrollButtons);
        
        // Sync vertical scrolling between fixed and scrollable columns
        $('.scrollable-columns').on('scroll', function() {
            $('.fixed-columns').scrollTop($(this).scrollTop());
        });
        
        $('.fixed-columns').on('scroll', function() {
            $('.scrollable-columns').scrollTop($(this).scrollTop());
        });
        
        // Add row highlighting on hover
        $('tbody tr').hover(
            function() {
                const index = $(this).index();
                $('#fixed-body tr').eq(index).addClass('highlight');
                $('#scrollable-body tr').eq(index).addClass('highlight');
            },
            function() {
                const index = $(this).index();
                $('#fixed-body tr').eq(index).removeClass('highlight');
                $('#scrollable-body tr').eq(index).removeClass('highlight');
            }
        );
    });
</script>

@endsection