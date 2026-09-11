@extends('layouts.app')

@section('content')


    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Requisition</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" class="form-control" name="request_description" placeholder="Request Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="request_category" >
                                                <option value="">Request Category</option>
                                                @foreach($reqCat as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->request_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" onchange="checkProject('request_type','project_id');" id="request_type" name="request_type" >
                                                <option value="">Request Type</option>
                                                @foreach($reqType as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->request_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" id="project_id" style="display:none;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control"  id="" name="project" >
                                                <option value="">Select Project</option>
                                                @foreach($project as $ap)
                                                    <option value="{{$ap->project->id}}">{{$ap->project->project_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clear-fix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" onchange="checkTransaction('transaction_type','currency_id','material_request_id');" id="transaction_type" name="transaction_type" >
                                                <option value="">Transaction Type</option>
                                                @foreach($transactionTypes as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" id="currency_id" style="display:none;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control"  id="" name="currency" >
                                                <option value="">Select Currency</option>
                                                @foreach($currencies as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->code}}({{$ap->currency}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" id="material_request_id" style="display:none;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_mr" onkeyup="searchOptionList('select_mr','myUL12','{{url('default_select')}}','search_my_mr_select','mr');" name="select_user" placeholder="Select Material Request">

                                            <input type="hidden" class="user_class" name="material_request" id="mr" />
                                        </div>
                                    </div>
                                    <ul id="myUL12" class="myUL"></ul>
                                </div>
                            
                            </div>

                            <div class="row clear-fix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="amount" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" multiple="multiple" class="form-control" name="attachment[]" placeholder="Attachment">
                                        </div>
                                    </div>
                                </div>
                                @if($access == \App\Helpers\Utility::DETECT)
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                                <input type="hidden" class="user_class" name="user" id="user" />
                                            </div>
                                        </div>
                                        <ul id="myUL1" class="myUL"></ul>
                                    </div>
                                @else
                                    <input type="hidden"  name="user" />
                                @endif


                            </div>

                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_requisition'); ?>','reload_data',
                            '<?php echo url('requisition'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Default Size -->
    <div class="modal fade" id="convertModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Convert Purchase Order</h4>
                </div>
                <div class="modal-body" id="convert_content">


                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('convertModal','convertMainForm','<?php echo url('create_requisition'); ?>','reload_data',
                            '<?php echo url('requisition'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

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
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_attachment'); ?>','reload_data',
                            '<?php echo url('requisition'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_requisition'); ?>','reload_data',
                            '<?php echo url('requisition'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Requisition
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('requisition'); ?>',
                                    '<?php echo url('delete_requisition'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
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
                        <li role="presentation" class="active"><a href="#home" data-toggle="tab">My Requisitions</a></li>
                        <li role="presentation"><a href="#purchase_orders" data-toggle="tab">Department Purchase Orders</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                            
                            <div class="table-responsive " id="reload_data">
                                <table class="table table-bordered table-hover table-striped" id="main_table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                                name="check_all" class="" />

                                        </th>

                                        <th>Manage</th>
                                        <th>Attachment</th>
                                        <th>Preview</th>
                                        <th>Description</th>
                                        <th>Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                        <th>Foreign Amount</th>
                                        <th>Transaction Type</th>
                                        <th>Material Request</th>
                                        <th>Approval Status</th>
                                        <th>Finance Status</th>
                                        <th>Days with Finance</th>
                                        <th>Approved by</th>
                                        <th>Edited</th>
                                        <th>Response Message(s)</th>
                                        <th>Request Category</th>
                                        <th>Request Type</th>
                                        <th>Project Category</th>
                                        <th>Requested by</th>
                                        <th>Department</th>
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
                                    <tr>
                                        <td scope="row">
                                            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />
                                        </td>
                                        <td>
                                            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_requisition_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                        </td>
                                        <td>
                                            <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                        </td>
                                        <td>
                                            @if($data->finance_status == \App\Helpers\Utility::STATUS_ACTIVE)
                                            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('request_print_preview') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o"></i>Preview</a>
                                            @endif
                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>{{$data->req_desc}}</td>
                                        <td>{{Utility::numberFormat($data->amount)}}</td>
                                        <td>{{$foreignCurr}}{{Utility::numberFormat($data->foreign_amount)}}</td>
                                        <td>
                                            {{$transType}}
                                        </td>
                                        <td>{{$data->mrData->mr_number}}</td>
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
                                        <td>{{$data->project->project_name}}</td>
                                        <td>{{$data->requestUser->firstname}} &nbsp; {{$data->requestUser->lastname}}</td>
                                        <td>{{$data->department->dept_name}}</td>
                                        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
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

                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="purchase_orders">
                            <div class="table-responsive " id="">
                                <table class="table table-bordered table-hover table-striped tbl_order" id="reload_po">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_po');" id="parent_check_po"
                                                name="check_all" class="" />

                                        </th>
                                        <th>Convert</th>
                                        <th>Vendor Preview</th>
                                        <th>Default Preview</th>
                                        <th>PO Number</th>
                                        <th>Approval Status</th>
                                        <th>Vendor</th>
                                        <th>Post Date</th>
                                        <th>Due date</th>
                                        <th>PO Status</th>
                                        <th>Assigned User</th>
                                        <th>Vendor Sum Total</th>
                                        <th>Sum Total {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                        <th>Created by</th>
                                        <th>Updated by</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($purchaseOrders as $data)
                                        <tr>
                                            <td scope="row">
                                                <input value="{{$data->id}}" type="checkbox" id="po_{{$data->id}}" class="kid_checkbox_po" />

                                            </td>
                                            <td>
                                                @if($data->approval_status == Utility::STATUS_ACTIVE && ($data->mrData->created_by == Auth::user()->id || empty($data->mr_id)))
                                                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','convert_content','convertModal','<?php echo url('convert_po_requisition_form') ?>','<?php echo csrf_token(); ?>')">Convert to Fund Request</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('po_print_preview') ?>','<?php echo csrf_token(); ?>','vendor')"><i class="fa fa-pencil-square-o"></i>Vendor Preview</a>
                                            </td>
                                            <td>
                                                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('po_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Preview</a>
                                            </td>
                                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                            @php $poNumber = (empty($data->po_number) ? $data->id : $data->po_number) @endphp
                                            <td>{{$poNumber}}</td>
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
                                            <td>{{$data->vendorCon->name}}</td>
                                            <td>{{$data->post_date}}</td>
                                            <td>{{$data->due_date}}</td>
                                            <td>{{$data->dataStatus->name}}</td>
                                            <td>{{$data->UserDetail->firstname}} &nbsp; {{$data->userDetail->lastname}}</td>
                                            <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{Utility::numberFormat($data->sum_total)}}</td>
                                            <td>{{Utility::numberFormat($data->trans_total)}}</td>
                                            <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
                                            <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
                                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                            <input type="hidden" id="vendorDisplay" value="{{$data->vendor}}">

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

    function checkProject(reqType_id,project_id){
        var projId = $('#'+project_id);
        var reqValue = $('#'+reqType_id).val();
        if(reqValue == 1){
            projId.hide();
        }
        if(reqValue == 2){
            projId.show();
        }
        if(reqValue == ''){
            projId.hide();
        }

    }

    function checkTransaction(reqType_id,currency,material_request_id){
        var mr_id = $('#'+material_request_id);
        var currency_id = $('#'+currency);
        var reqValue = $('#'+reqType_id).val();
        //var reqValue = idVal(reqType_id);
        console.log(reqValue);
        if(reqValue == 1){
            currency_id.hide();
            mr_id.show();
        }
        if(reqValue == 2){
            currency_id.show();
            mr_id.hide();

        }
        if(reqValue == ''){
            currency_id.hide();
            mr_id.show();
        }

    }

</script>

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


@endsection