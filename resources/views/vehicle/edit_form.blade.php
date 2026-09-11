<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Vehicle Make*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="make" id="vehicle_make_id_edit" required onchange="fillNextInput('vehicle_make_id_edit','vehicle_model_id_edit','{{url('default_select')}}','fetch_vehicle_model')">
                            <option value="{{$edit->make_id}}">{{$edit->make->make_name}}</option>
                            @foreach($vehicleMake as $data)
                                <option value="{{$data->id}}">{{$data->make_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Vehicle Model*</b>
                <div class="form-group">
                    <div class="form-line" id="vehicle_model_id_edit">
                        <select class="form-control" name="model"  required>
                            <option selected value="{{$edit->model_id}}">{{$edit->model->model_name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>License Plate*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->license_plate}}" name="license_plate" placeholder="License Plate" required>
                    </div>
                </div>
            </div>

        </div>
        <hr/>
        @php   $driver = (empty($edit->driver_id)) ? '' : $edit->driver->firstname.' '.$edit->driver->lastname; @endphp
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$driver}}" autocomplete="off" id="select_user_edit" onkeyup="searchOptionList('select_user_edit','myUL1_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Select Driver">

                        <input type="hidden" value="{{$edit->driver_id}}" class="user_class" name="driver" id="user_edit" />
                    </div>
                </div>
                <ul id="myUL1_edit" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <b>Vehicle Category*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="category"  required>
                            <option value="{{$edit->category_id}}">{{$edit->category->name}}</option>
                            @foreach($vehicleCategory as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Mileage ({{\App\Helpers\Utility::odometerMeasure()->name}})</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" value="{{$edit->mileage}}" class="form-control" name="mileage" placeholder="Mileage" >
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Vehicle ID</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->vehicle_id}}" name="vehicle_id" placeholder="Vehicle ID" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>VIN</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->vin}}" name="vin" placeholder="VIN" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Engine Number</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->engine_no}}" name="engine_number" placeholder="Engine Number" >
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Transmission</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="transmission"  required>
                            <option value="{{$edit->transmission}}">{{$edit->transmission}}</option>
                            <option value="Automatic">Automatic</option>
                            <option value="Manual">Manual</option>
                            <option value="Self Driving">Self Driving</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Registration Date*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->registration_date}}" name="registration_date" placeholder="Registration Date" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Registration Due Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->registration_due_date}}" name="registration_due_date" placeholder="Registration Due Date" required>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>location*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->location}}" name="location" placeholder="Location" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Model Year</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control " value="{{$edit->model_year}}" name="model_year" placeholder="Model Year" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Fuel Type</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->fuel_type}}" name="fuel_type" placeholder="Fuel Type">
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>IVHMS TYPE</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->ivhms_type}}" name="ivhms_type" placeholder="IVHMS Type">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    Insurance Status
                    <div class="form-line">
                        <select  class="form-control" name="insurance_status" >
                        @php $insuranceStatus = ($edit->insurance_status == Utility::STATUS_ACTIVE) ? 'ACTIVE' : 'INACTIVE'; @endphp
                        <option value="{{$edit->insurance_status}}">{{$insuranceStatus}}</option>
                            <option value="{{Utility::STATUS_ACTIVE}}">ACTIVE</option>
                            <option value="{{Utility::ZERO}}">INACTIVE</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    Status
                    <div class="form-line">
                        <select  class="form-control" name="status" >
                        @php $activeStatus = ($edit->active_status == Utility::STATUS_ACTIVE) ? 'ACTIVE' : 'INACTIVE'; @endphp
                        <option value="{{$edit->active_status}}">{{$activeStatus}}</option>
                            <option value="{{Utility::STATUS_ACTIVE}}">ACTIVE</option>
                            <option value="{{Utility::ZERO}}">INACTIVE</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Purchase Price</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->purchase_price}}" name="purchase_price" placeholder="Purchase Price" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Colour</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->colour}}" class="form-control" name="colour" placeholder="Colour" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Horse Power</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" value="{{$edit->horsepower}}" class="form-control" name="horse_power" placeholder="Horse Power" >
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-12">
                <b>Current Condition</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea  class="form-control" name="current_condition" placeholder="Current Condition" required>{{$edit->current_condition}}</textarea>
                    </div>
                </div>
            </div>
            </div>

            <div class="row clearfix">
                <div class="col-sm-12">
                    <b>Route</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea  class="form-control " name="route" placeholder="Route" >{{$edit->route}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
            <div class="col-sm-12">
                <b>Servicing Parts</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea  class="form-control " name="servicing_parts" placeholder="Servicing Parts" >{{$edit->service_parts}}</textarea>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Chasis Number*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->chasis_no}}" name="chasis_no" placeholder="Chasis Number" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Seat Number</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" value="{{$edit->seat_number}}" class="form-control " name="seat_no" placeholder="Seat Number" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Doors</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" value="{{$edit->doors}}" class="form-control" name="doors" placeholder="doors" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-sm-12" >
                <div class="form-group">
                    <b>Project</b>
                    <div class="form-line">
                        <select  class="form-control"  id="" name="project" >
                            <option value="{{$edit->project_id}}">{{$edit->project->project_name}}</option>
                            @foreach($project as $ap)
                                <option value="{{$ap->project->id}}">{{$ap->project->project_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

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

