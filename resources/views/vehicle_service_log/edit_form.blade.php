<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

        <div class="row clearfix">
            @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || \App\Helpers\Utility::moduleAccessCheck('vehicle_fleet_access'))
                <div class="col-sm-4">
                    <b>Vehicle*</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$edit->vehicleDetail->license_plate}}" autocomplete="off" id="select_vehicle_edit" onkeyup="searchOptionListParamCheck('select_vehicle_edit','myUL1_edit','{{url('default_select')}}','search_vehicle_param_repair','vehicle_edit','','fault_desc_id_edit','select_vehicle_repair','{{url('default_select')}}');" name="select_vehicle" placeholder="Select Vehicle">

                            <input type="hidden" value="{{$edit->vehicle_id}}" class="vehicle_class" name="vehicle" id="vehicle_edit" />
                        </div>
                    </div>
                    <ul id="myUL1_edit" class="myUL"></ul>
                </div>
            @else

                <div class="col-sm-4">
                    <b>Vehicle*</b>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control" name="vehicle" onchange="fillNextInput('vehicle_edit','fault_desc_id_edit','<?php echo url('default_select'); ?>','select_vehicle_repair')" required>
                                <option value="{{$edit->vehicle_id}}">{{$edit->vehicleDetail->license_plate}}</option>
                                @foreach(\App\Helpers\Utility::driverVehicles() as $data)
                                    <option value="{{$data->id}}">{{$data->make->make_name}} {{$data->model->model_name}} ({{$data->license_plate}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            @endif

            <div class="col-md-4">
                <b>Repair Requests/Fault Description</b>
                <div class="form-group">
                    <div class="form-line fault_desc" id="fault_desc_id_edit" >
                        <select  class="form-control" name="fault_description"  >
                            <option value="{{$edit->repair_id}}">{{$edit->repairDetail->fault_desc}}</option>
                            <option value="">Vehicle Fault Description</option>
                        </select>
                    </div>
                </div>
            </div>

            
            <div class="col-sm-4">
                <b>Total Bill {{\App\Helpers\Utility::defaultCurrency()}}</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->total_price}}" name="total_bill" placeholder="Total Bill" >
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Add/Remove Spare Parts by selection</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" id="select_item1_edit" onkeyup="searchOptionListMultipleDetail('select_item1_edit','myUL501_edit','{{url('default_select')}}','search_multiple_vehicle_spare_parts_detail','inv501_edit','spare_parts_desc_edit','spare_parts_array_id_edit','vehicle_spare_parts');" name="select_spare_parts" placeholder="Select Spare parts">

                        <input type="hidden" class="inv_class" value="" name="spare_part" id="inv501_edit" />
                    </div>
                </div>
                <ul id="myUL501_edit" class="myUL"></ul>
            </div>
            <div class="col-sm-6">
                <b>Spares Required</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" readonly id="spare_parts_desc_edit" name="spares_required" placeholder="Vehicle Spare Parts" required>{{$edit->spares_required}}</textarea>
                    </div>
                </div>
                <input type="hidden" id="spare_parts_array_id_edit" name="spare_parts_array">
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Services*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control show-tick" name="service_type" required>
                            <option value="{{$edit->service_type}}">{{$edit->service->name}}</option>
                            @foreach($serviceType as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Action Taken So Far*</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="action_taken" placeholder="Action Taken So Far" required>{{$edit->action_taken}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Next Action*</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="next_action" placeholder="Next Action" required>{{$edit->next_action}}</textarea>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Service/Repair Start Date*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->service_date}}" name="service_date" placeholder="Service Date" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Estimated Complete Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control" id="" value="{{$edit->estimated_complete_date}}" name="estimated_complete_date" placeholder="Estimated Completion Date" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Actual Complete Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control" id="" value="{{$edit->actual_complete_date}}" name="actual_compete_date" placeholder="Actual Completion Date" >
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Invoice Reference*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->invoice_reference}}" name="invoice_reference" placeholder="Invoice Reference" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Mileage In({{\App\Helpers\Utility::odometerMeasure()->name}})</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->mileage_in}}" id="" name="mileage_in" placeholder="Mileage In" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Mileage Out({{\App\Helpers\Utility::odometerMeasure()->name}})</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" id="" class="form-control" value="{{$edit->mileage_out}}" id="" name="mileage_out" placeholder="Mileage Out">
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Workshop*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="workshop"  required>
                            <option value="{{$edit->workshop}}">{{$edit->workshopDetail->name}}</option>
                            @foreach($workshop as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Location</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->location}}" name="location" id="" placeholder="location" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Diagnosis Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control" id="" value="{{$edit->diagnosis_date}}" name="diagnosis_date" placeholder="Diagnosis Date" >
                    </div>
                </div>
            </div>
            
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-12">
                <b>Comment</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="comment" placeholder="Comment" >{{$edit->comment}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <hr/>

    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
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

