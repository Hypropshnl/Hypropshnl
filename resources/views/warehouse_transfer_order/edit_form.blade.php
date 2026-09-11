<form name="editMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-edit">
    <div class="container body">

        <div class="row clearfix">
            <div class="row">
                    <div class="col-sm-4">
                        Inventory Item
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" value="{{$edit->inventory->item_name}} ({{$edit->inventory->item_no}})" autocomplete="off" id="select_inv_edit" onkeyup="searchOptionList('select_inv_edit','myUL500_edit','{{url('default_select')}}','search_inventory','inv500_edit');" name="select_user" placeholder="Select Inventory Item">

                                <input type="hidden" class="inv_class_edit" value="{{$edit->inventory_id}}" name="inventory_item" id="inv500_edit" />
                            </div>
                        </div>
                        <ul id="myUL500_edit" class="myUL"></ul>
                    </div>

                    <div class="col-sm-4">
                        <b>Transfer Quantity</b>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="number" class="form-control" name="transfer_quantity" value="{{$edit->transfer_quantity}}" placeholder="Transfer Quantity" >
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <b>Return Quantity</b>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="number" class="form-control" disabled="disabled" name="return_quantity" placeholder="Return Quantity" >
                            </div>
                        </div>
                    </div>
            </div><hr>

            <div class="row clearfix">
                <div class="col-sm-4">
                    <b>Description*</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="order_desc" value="{{$edit->order_desc}}" placeholder=" Descritpion" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <b>Due Date.</b>
                        <div class="form-line">
                            <input type="text" class="form-control datepicker1" value="{{$edit->due_date}}" name="due_date" placeholder="Due Date">
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
                            <select class=" warehouse" name="from_warehouse" id="warehouse_id_from1" onchange="fillNextInputParamId('warehouse_id_from1','zone_display_id_from1','<?php echo url('default_select'); ?>','w_zones_fetch_extra','zone_id_from1','bin_id_from1')" >
                                <option value="{{$edit->from_whse}}" selected>{{$edit->fromWarehouse->name}} ({{$edit->fromWarehouse->code}})</option>
                                @include('includes/warehouse')
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <b>Zone</b>
                        <div class="form-line" id="zone_display_id_from1">
                            <select class=" " id="zone_id_from1" name="zone_id_from1" >
                                <option value="{{$edit->from_zone}}" selected>{{$edit->fromZone->name}}</option>
                            
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <b>Bin</b>
                        <div class="form-line" id="bin_id_from1">
                            <select class=" " name="bin_id_from1"  >
                                <option value="{{$edit->from_bin}}" selected>{{$edit->fromBin->code}}</option>

                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <hr/>

            <div class="row">
                @php  $checked = ($edit->location_status == 1) ? 'checked' : '';  @endphp
                @php  $customDisplay = ($edit->location_status == '') ? 'display:block' : 'display:none';  @endphp
                @php  $warehouseDisplay = ($edit->location_status == 1) ? 'display:block' : 'display:none';  @endphp
                <div class="col-sm-4">
                    <div class="form-group">
                        Check to select warehouse location
                        <div class="form-line">
                        <input type="checkbox" class="" name="location_checker" {{$checked}}  value="{{$edit->location_status}}" onclick="toggleInput('custom_location_edit','static_location_edit','location_checker_edit');" id="location_checker_edit" />
                            
                        </div>
                    </div>
                </div>
                
                                
                
                <div class="col-sm-4" id="custom_location_edit" style="{{$customDisplay}}">
                        <b>Custom Location</b>
                        <div class="form-group">
                            <div class="form-line">
                                <textarea class="form-control" name="custom_location" placeholder="Custom Location" >{{$edit->custom_location}}</textarea>
                            </div>
                        </div>
                </div>

            </div>
           
            <div class="row"><b>To</b> </div>
            <div class="row" id="static_location_edit" style="{{$warehouseDisplay}}">
                <div class="col-sm-4">
                    <div class="form-group">
                        Warehouse
                        <div class="form-line" >
                            <select class=" warehouse" name="to_warehouse" id="warehouse_id_to1" onchange="fillNextInputParamId('warehouse_id_to1','zone_display_id_to1','<?php echo url('default_select'); ?>','w_zones_fetch_extra','zone_id_to1','bin_id_to1')" >
                                <option value="{{$edit->to_whse}}" selected>{{$edit->toWarehouse->name}} ({{$edit->toWarehouse->code}})</option>
                                @include('includes/warehouse')
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <b>Zone</b>
                        <div class="form-line" id="zone_display_id_to1">
                            <select class=" " id="zone_id_to1" name="zone_id_to1" >
                                <option value="{{$edit->to_zone}}" selected>{{$edit->toZone->name}}</option>
                            
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <b>Bin</b>
                        <div class="form-line" id="bin_id_to1">
                            <select class=" " name="bin_id_to1"  >
                                <option value="{{$edit->to_bin}}" selected>{{$edit->toBin->code}}</option>

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
                            <select class=" warehouse" name="return_warehouse" id="warehouse_id_return1" onchange="fillNextInputParamId('warehouse_id_return1','zone_display_id_return1','<?php echo url('default_select'); ?>','w_zones_fetch_extra','zone_id_return1','bin_id_return1')" >
                                <option value="{{$edit->return_whse}}" selected>{{$edit->returnWarehouse->name}} ({{$edit->returnWarehouse->code}})</option>
                                @include('includes/warehouse')
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <b>Zone</b>
                        <div class="form-line" id="zone_display_id_return1">
                            <select class=" " id="zone_id_return1" name="zone_id_return1" >
                                <option value="{{$edit->return_zone}}" selected>{{$edit->returnZone->name}}</option>
                            
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <b>Bin</b>
                        <div class="form-line" id="bin_id_return1">
                            <select class=" " name="bin_id_return1"  >
                                <option value="{{$edit->return_bin}}" selected>{{$edit->returnBin->code}}</option>

                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <hr/>

            <input type="hidden" name="edit_id" value="{{$edit->id}}">

        </div>
    </div>
</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>