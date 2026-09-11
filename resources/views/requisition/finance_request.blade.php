@extends('layouts.app')

@section('content')

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')

        <!-- Default Size Attachment-->
        <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
                    </div>
                    <div class="modal-body" id="attach_content">


                    </div>
                    <div class="modal-footer">
                        
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
                        Finance Unprocessed Requisition(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button type="button" onclick="approveFinanceRequest('kid_checkbox','reload_data','<?php echo url('finance_requests'); ?>',
                                    '<?php echo url('approve_finance_requests'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Process Request(s)
                            </button>
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
                

                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class="active"><a href="#home" data-toggle="tab">Finance Request(s)</a></li>
                        <li role="presentation"><a href="#warehouse_receipt" data-toggle="tab">Warehouse Receipt</a></li>
                        <li role="presentation"><a href="#store_receipt" data-toggle="tab">Store Receipt</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                            <div class="body table-responsive tbl_scroll" id="reload_data">
                                <table class="table table-bordered table-hover table-striped" id="main_table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                                name="check_all" class="" />

                                        </th>

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
                                        <th>Finance Status</th>
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
                                        @if($data->complete_status == 1)
                                            @if($data->deny_reason == '')
                                        <tr>
                                            <td scope="row">
                                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                            </td>
                                            <td>
                                                
                                                    <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('request_print_preview') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o"></i>Preview</a>
                                                
                                            </td>
                                            <td>
                                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                            </td>
                                            <td>
                                               @if(!empty($data->po_id))
                                                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->po_id}}','print_preview','printPreviewModal','<?php echo url('po_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Preview</a>|
                                                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('po_print_preview') ?>','<?php echo csrf_token(); ?>','vendor')"><i class="fa fa-pencil-square-o"></i>Vendor Preview
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
                                            <td>{{$data->department->dept_name}}</td>
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
                                            <td class="{{\App\Helpers\Utility::statusIndicator($data->finance_status)}}">
                                                @if($data->finance_status === 0)
                                                    Processing
                                                @endif
                                                @if($data->finance_status === 1)
                                                    Complete and Ready for Print
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

                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="warehouse_receipt">
                            <div class="body table-responsive tbl_scroll" id="reload_data_warehouse">

                                <table class="table table-bordered table-hover table-striped" id="">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_warehouse');" id="parent_check_warehouse"
                                                name="check_all_warehouse" class="" />

                                        </th>

                                        <th>Manage/Preview</th>
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
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($warehouseReceipt as $data)
                                    <tr>
                                        <td scope="row">
                                            <input value="{{$data->id}}" type="checkbox" id="warehouse_{{$data->id}}" class="kid_checkbox_warehouse" />

                                        </td>
                                        <td>
                                            <a style="cursor: pointer;" class="" onclick="fetchHtml('{{$data->po_id}}','print_preview','printPreviewModal','<?php echo url('print_preview_warehouse_receipt') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o"></i>Preview</a> |
                                            <a style="cursor: pointer;" class="" onclick="fetchHtml('{{$data->po_ext_id}}','print_preview','printPreviewModal','<?php echo url('print_preview_multiple_warehouse_receipt') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o"></i>PO Items</a>
                                        
                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
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


                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="store_receipt">
                            <div class="body table-responsive" id="reload_data_store">
                                <table class="table table-bordered table-hover table-striped" id="">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_store');" id="parent_check_store"
                                                name="check_all_store" class="" />

                                        </th>

                                        <th>Store</th>
                                        <th>Inventory Item</th>
                                        <th>PO Number</th>
                                        <th>Quantity Received</th>
                                        <th>Total Inventory Quantity</th>
                                        <th>Status</th>
                                        <th>Created by</th>
                                        <th>Created at</th>
                                        <th>Updated by</th>
                                        <th>Updated at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($storeReceipt as $data)
                                    <tr>
                                        <td scope="row">
                                            @if(in_array(Auth::user()->id, Utility::TOP_USERS) || Auth::user()->id == $data->storeDetail->user_id)
                                                <input value="{{$data->id}}" type="checkbox" id="store_{{$data->id}}" class="kid_checkbox_store" />
                                            @else
                                                Not Manager
                                            @endif

                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>{{$data->storeDetail->name}}({{$data->storeDetail->code}})</td>
                                        <td>{{$data->inventory->item_name}}({{$data->inventory->code}})</td>
                                        <td>{{$data->poItem->po_number}}</td>
                                        <td>{{$data->qty}}</td>
                                        <td>
                                            @if (!empty($data->qty_remain) || $data->qty_remain != 0)
                                            <a href="#" class="badge bg-green">{{$data->qty_remain}}</a>
                                            @else
                                            
                                            <a href="#" class="badge bg-blue">{{$data->inventory->qty}}</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($data->qty_remain) || $data->qty_remain != 0)
                                            <a href="#" class="badge bg-green">Placed</a>
                                            @else
                                            
                                            <a href="#" class="badge bg-red">Not Placed</a>
                                            @endif
                                        </td>
                                        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                                        <td>{{$data->updated_at}}</td>


                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

    <script>
        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            page = window.location.hash.replace('#','');
            getProducts(page);
        });

        $(document).on('click','.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getProducts(page);
            location.hash = page;
        });

        function getProducts(page){

            $.ajax({
                url: '?page=' + page
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

    </script>

    <script>
        /*$(function() {
         $( ".datepicker" ).datepicker({
         /!*changeMonth: true,
         changeYear: true*!/
         });
         });*/
    </script>

@endsection