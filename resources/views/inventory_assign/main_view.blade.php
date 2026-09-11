@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Assign Inventory</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_inv" onkeyup="searchOptionList('select_inv','myUL500','{{url('default_select')}}','search_inventory','inv500');" name="select_user" placeholder="Inventory Item">

                                            <input type="hidden" class="inv_class" value="" name="inventory" id="inv500" />
                                        </div>
                                    </div>
                                    <ul id="myUL500" class="myUL"></ul>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="user" id="user" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control qty" name="quantity" placeholder="Quantity">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                        <input type="checkbox" id="affect_inv" class="affect_inventory" onclick="toggleCheckBox('affect_inv')" value="1" name="affect_inventory" />Affect Inventory
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                        <input type="checkbox" class="change_option" name="change_option"  value="1" onclick="toggleInputInv('warehouse','store','change_view');" id="change_view" />Check to select Warehouse
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="row clearfix">
                                <div class="body" id="warehouse" style="display: none;">
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
                                                <select class="zones " id="zone_id_from" name="zone_id_from" >
                                                    <option value="">Select Zone</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <b>Bin</b>
                                            <div class="form-line" id="bin_id_from">
                                                <select class="bins " name="bin_id_from"  >
                                                    <option value="">Select Bin</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="body" id="store">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select  class="form-control store" name="store" >
                                                    <option value="" selected>Store</option>
                                                    @foreach($store as $de)
                                                    <option value="{{$de->id}}">{{$de->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3" id="hide_button">
                                    <div class="form-group">
                                        <div onclick="addMore('add_more','hide_button','1','<?php echo URL::to('add_more'); ?>','assign_inv','hide_button');">
                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control desc" name="desc" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="add_more"></div>

                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="saveInventoryAssign('createModal','createMainForm','<?php echo url('create_inv_assign'); ?>','reload_data',
                            '<?php echo url('inventory_assign'); ?>','<?php echo csrf_token(); ?>','inv_class','user_class','qty',
                            'affect_inventory','change_option','warehouse','zones','bins','store')" type="button" class="btn btn-success waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_inv_assign'); ?>','reload_data',
                            '<?php echo url('inventory_assign'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
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
                        Inventory Assignment
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('inventory_assign'); ?>',
                                    '<?php echo url('delete_inv_assign'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-print"></i>Print</a></li>
                                <li><a class="btn bg-red waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                                <li><a class="btn btn-warning" onClick ="$('#main_table').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                                <li><a class="btn  bg-light-green waves-effect" onClick ="$('#main_table').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                                <li><a class="btn btn-info" onClick ="$('#main_table').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

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
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="start_date" placeholder="From e.g 2019-02-22">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="end_date" placeholder="To e.g 2019-04-21">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user2" onkeyup="searchOptionList('select_user2','myUL2','{{url('default_select')}}','default_search','user2');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="user" id="user2" />
                                        </div>
                                    </div>
                                    <ul id="myUL2" class="myUL"></ul>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_inv2" onkeyup="searchOptionList('select_inv2','myUL501','{{url('default_select')}}','search_inventory','inv501');" name="select_user" placeholder="Inventory Item">

                                            <input type="hidden" class="inv_class" value="" name="inventory" id="inv501" />
                                        </div>
                                    </div>
                                    <ul id="myUL501" class="myUL"></ul>
                                </div>   

                                <div class="col-sm-8" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info col-sm-8" type="button" onclick="searchUsingDate('searchMainForm','<?php echo url('search_inv_assign'); ?>','reload_data',
                                                '<?php echo url('inventory_assign'); ?>','<?php echo csrf_token(); ?>','start_date','end_date')">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>


                </div>
                <div class="body table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Inventory Item</th>
                            <th>Assigned To</th>
                            <th>Quantity Assigned</th>
                            <th>Store</th>
                            <th>Warehouse</th>
                            <th>Zone</th>
                            <th>Bin</th>
                            <th>Description</th>
                            <th>Inventory Deduction</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            <th>Updated by</th>
                            <th>Updated at</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->inventory->item_name}}</td>
                            <td>{{$data->assignee->firstname}}&nbsp;{{$data->assignee->lastname}}</td>
                            <td>{{$data->qty}}</td>
                            <td>{{$data->storeData->name}}</td>
                            <td>{{$data->warehouseData->name}}({{$data->warehouseData->code}})</td>
                            <td>{{$data->zoneData->name}}</td>
                            <td>{{$data->binData->code}}</td>
                            <td>{{$data->item_desc}}</td>
                            <td>
                                @if($data->affect_inv == '1')
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                            <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                            <td>{{$data->updated_at}}</td>


                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                            @if(in_array(Auth::user()->role,Utility::TOP_USERS) || Auth::user()->id == $data->created_by)
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_inv_assign_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            @endif
                        </tr>
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

    <!-- #END# Bordered Table -->

<script>

    function saveInventoryAssign(formModal,formId,submitUrl,reload_id,reloadUrl,token,item,user,qty,affectInv,changeOpt,wah,zones,bins,stores) {
        var inputVars = $('#' + formId).serialize();
        
        var itemId = classToArray(item);
        var username = classToArray(user);
        var quantity = classToArray(qty);
        var affectInventory = classToArray(affectInv);
        var changeOption = classToArray(changeOpt)
        var warehouse = classToArray(wah);
        var zone = classToArray(zones);
        var bin = classToArray(bins);
        var store = classToArray(stores);

        var jUsername = JSON.stringify(username);
        var jItemId = JSON.stringify(itemId);
        var jQuantity = JSON.stringify(quantity);
        var jAffectInv = JSON.stringify(affectInventory);
        var jChangeOpt = JSON.stringify(changeOption);
        var jWah = JSON.stringify(warehouse);
        var jZone = JSON.stringify(zone);
        var jBin = JSON.stringify(bin);
        var jStore = JSON.stringify(store);
        //alert(jdesc);

        if(arrayItemEmpty(itemId) == false){
            var postVars = inputVars + '&affect_inv=' + jAffectInv+'&item='+jItemId+'&user='+jUsername+'&change_opt='+jChangeOpt+'&qty='+jQuantity;
                postVars += '&warehouse=' + jWah+'&zones='+jZone+'&bins='+jBin+'&stores='+jStore;

            $('#'+formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');
        
            sendRequestForm(submitUrl, token, postVars)
                ajax.onreadystatechange = function () {
                    if (ajax.readyState == 4 && ajax.status == 200) {

                        //HIDE LOADING ICON
                        overlayBody('none');
                        var rollback = JSON.parse(ajax.responseText);
                        var message2 = rollback.message2;
                        if (message2 == 'fail') {

                            //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                            var serverError = phpValidationError(rollback.message);

                            var messageError = swalFormError(serverError);
                            swal("Error", messageError, "error");

                        } else if (message2 == 'saved') {

                            //RESET FORM
                            //resetForm(formId);
                            var successMessage = swalSuccess(rollback.message);
                            swal("Success!", successMessage, "success");

                        } else {

                            var infoMessage = swalWarningError(message2);
                            swal("Warning!", infoMessage, "warning");

                        }

                        //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                        reloadContent(reload_id, reloadUrl);
                        //location.reload();
                    }
                }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    function toggleInputInv(normal_user1,temp_user1,change_user1){
        var changeUserT = $('#'+change_user1);
        var normalUser = $('#'+normal_user1);
        var tempUser = $('#'+temp_user1);

        if(changeUserT.val() == 'on'){

            changeUserT.val('1');
            normalUser.css("display", "none");

            tempUser.css("display", "block");
            tempInputId.prop("disabled",false);

        }else{

            changeUserT.val('on');
            tempUser.css("display", "none");

            normalUser.css("display", "block");
            inputId.prop("disabled",false);

        }

    }

    function toggleCheckBox(getId){
        var virtualId = $('#'+getId);

        if(virtualId.val() == 'on'){

            virtualId.val('1');

        }else{
            virtualId.val('on');
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

    <script>
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection