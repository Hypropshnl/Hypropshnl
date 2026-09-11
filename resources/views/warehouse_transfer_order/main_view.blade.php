@extends('layouts.app')

@section('content')

    @include('includes.print_preview')

    <!-- Default Size Attachment-->
    <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
                </div>
                <div class="modal-body" id="attach_content">


                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('warehouse_transfer_order_edit_attachment'); ?>','reload_data',
                            '<?php echo url('warehouse_transfer_order'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Transfer Order</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="container body">

                            <div class="row clearfix">
                                <div class="row">
                                        <div class="col-sm-4">
                                            Inventory Item
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" autocomplete="off" id="select_inv" onkeyup="searchOptionList('select_inv','myUL500','{{url('default_select')}}','search_inventory','inv500');" name="select_user" placeholder="Select Inventory Item">

                                                    <input type="hidden" class="inv_class" value="" name="inventory_item" id="inv500" />
                                                </div>
                                            </div>
                                            <ul id="myUL500" class="myUL"></ul>
                                        </div>

                                        <div class="col-sm-4">
                                            <b>Transfer Quantity</b>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="form-control" name="transfer_quantity" placeholder="Transfer Quantity" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <b>Return Quantity</b>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="form-control" disabled="disabled" name="return_qty" placeholder="Transfer Quantity" >
                                                </div>
                                            </div>
                                        </div>
                                </div><hr>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Description*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="order_desc" placeholder=" Descritpion" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <b>Due Date.</b>
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" value="" name="due_date" placeholder="Due Date">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <b>Attachment</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file" class="form-control" name="attachment" >
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div><hr/>

                                <div class="row"><b>From</b> </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            Warehouse
                                            <div class="form-line" >
                                                <select class=" warehouse" name="from_warehouse" id="warehouse_id_from" onchange="fillNextInputParamId('warehouse_id_from','zone_display_id_from','<?php echo url('default_select'); ?>','w_zones_fetch_extra','zone_id_from','bin_id_from')" >
                                                    <option value="">Warehouse</option>
                                                    @include('includes/warehouse')
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <b>Zone</b>
                                            <div class="form-line" id="zone_display_id_from">
                                                <select class=" " id="zone_id_from" name="zone_id_from" >
                                                    <option value="">Select Zone</option>
                                                
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <b>Bin</b>
                                            <div class="form-line" id="bin_id_from">
                                                <select class=" " name="bin_id_from"  >
                                                    <option value="">Select Bin</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            Check to select warehouse location
                                            <div class="form-line">
                                            <input type="checkbox" class="" name="location_checker" value="" onclick="toggleInput('custom_location','static_location','location_checker');" id="location_checker" />
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                                   

                                    <div class="col-sm-4" id="custom_location">
                                            <b>Custom Location</b>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea class="form-control" name="custom_location" placeholder="Custom Location" ></textarea>
                                                </div>
                                            </div>
                                    </div>

                                </div>
                                    
                                <div class="row"><b>To</b> </div>
                                <div class="row" id="static_location" style="display:none;">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            Warehouse
                                            <div class="form-line" >
                                                <select class=" warehouse" name="to_warehouse" id="warehouse_id_to" onchange="fillNextInputParamId('warehouse_id_to','zone_display_id_to','<?php echo url('default_select'); ?>','w_zones_fetch_extra','zone_id_to','bin_id_to')" >
                                                    <option value="">Select Warehouse</option>
                                                    @include('includes/warehouse')
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <b>Zone</b>
                                            <div class="form-line" id="zone_display_id_to">
                                                <select class=" " id="zone_id_to" name="zone_id_to" >
                                                    <option value="">Select Zone</option>
                                                
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <b>Bin</b>
                                            <div class="form-line" id="bin_id_to">
                                                <select class=" " name="bin_id_to"  >
                                                    <option value="">Select Bin</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>

                                <div class="row"><b>Return</b> </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            Warehouse
                                            <div class="form-line" >
                                                <select class=" warehouse" name="return_warehouse" id="warehouse_id_return" onchange="fillNextInputParamId('warehouse_id_return','zone_display_id_return','<?php echo url('default_select'); ?>','w_zones_fetch_extra','zone_id_return','bin_id_return')" >
                                                    <option value="">Select Warehouse</option>
                                                    @include('includes/warehouse')
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <b>Zone</b>
                                            <div class="form-line" id="zone_display_id_return">
                                                <select class=" " id="zone_id_return" name="zone_id_return" >
                                                    <option value="">Select Zone</option>
                                                
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <b>Bin</b>
                                            <div class="form-line" id="bin_id_return">
                                                <select class=" " name="bin_id_return"  >
                                                    <option value="">Select Bin</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>

                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_warehouse_transfer_order'); ?>','reload_data',
                            '<?php echo url('warehouse_transfer_order'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_warehouse_transfer_order'); ?>','reload_data',
                            '<?php echo url('warehouse_transfer_order'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
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
                        Transfer Order(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('warehouse_transfer_order'); ?>',
                                    '<?php echo url('delete_warehouse_transfer_order'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        @if(!empty($warehouseManager))
                        <li>
                            <button type="button" onclick="generalApproval('kid_checkbox','reload_data','<?php echo url('warehouse_transfer_order'); ?>',
                                    '<?php echo url('change_warehouse_transfer_order_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Approve
                            </button>
                        </li>
                        <li>
                        <li>
                            <button type="button" onclick="generalApproval('kid_checkbox','reload_data','<?php echo url('warehouse_transfer_order'); ?>',
                                    '<?php echo url('change_warehouse_transfer_order_status'); ?>','<?php echo csrf_token(); ?>','2');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Deny
                            </button>
                        </li>
                        @endif
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

                <div class=" body">
                    <form name="import_excel" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="from_date" placeholder="From e.g 2030-02-22">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="to_date" placeholder="To e.g 2019-04-21">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick"  id="" name="status" data-selected-text-format="count">
                                                <option value="">Select All Status</option>
                                                @foreach(Utility::TICKET_STATUS as $key => $var)
                                                    <option value="{{$key}}">{{$var}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3" >
                                    <div class="form-group">
                                        <button class="btn btn-info col-sm-8" type="button" onclick="searchReportRequest('searchMainForm','<?php echo url('search_report_warehouse_transfer_order'); ?>','reload_data',
                                                '<?php echo url('warehouse_transfer_order'); ?>','<?php echo csrf_token(); ?>','start_date','end_date')" id="search_warehouse_transfer_order_button">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>


                </div>

                <div class="body ">
                    <div class="row">
                        <div class="col-sm-8 ">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="search_warehouse_transfer_order" class="form-control"
                                           onkeyup="searchItem('search_warehouse_transfer_order','reload_data','<?php echo url('search_warehouse_transfer_order') ?>','{{url('search_warehouse_transfer_order')}}','<?php echo csrf_token(); ?>')"
                                           name="search_user" placeholder="Search Transfer Order(s)" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" table-responsive" id="reload_data" >
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
                                <td>{{$data->order_desc}}</td>
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

                    </div>
              </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function searchReportRequest(formId,submitUrl,reload_id,reloadUrl,token,fromId,toId){

        var from = $('#'+fromId).val();
        var to = $('#'+toId).val();

        var inputVars = $('#'+formId).serialize();
        //alert(inputVars);
        if(from != '' && to !=''){

           
            var postVars = inputVars;
            $('#loading_modal').modal('show');
            sendRequestForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    $('#loading_modal').modal('hide');
                    var result = ajax.responseText;
                    $('#'+reload_id).html(result);

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

                }
            }

        }else{
            swal("warning!", "Please ensure to select from, to date.", "warning");

        }




    }
    
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getData(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
        //location.hash = page;
    });

    function getData(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

    <script>
        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getSearchData(page);
        });

        $(document).on('click','.search .pagination a', function(event){
            event.preventDefault();

            var page=$(this).attr('href').split('page=')[1];
            getSearchData(page);
            //location.hash = page;
        });

        function getSearchData(page){
            var searchVar = $('#search_user').val();

            $.ajax({
                url: '<?php echo url('search_user'); ?>?page=' + page +'&searchVar='+ searchVar
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