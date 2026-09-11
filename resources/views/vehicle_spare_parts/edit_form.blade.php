<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

        <div class="row clearfix">
            @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || \App\Helpers\Utility::moduleAccessCheck('vehicle_fleet_access'))
                <div class="col-sm-4">
                    <b>Vehicle*</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$edit->vehicleDetail->license_plate}}" autocomplete="off" id="select_vehicle_edit" onkeyup="searchOptionList('select_vehicle_edit','myUL1_edit','{{url('default_select')}}','search_vehicle','vehicle_edit');" name="select_vehicle" placeholder="Select Vehicle">

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
                            <select class="form-control" name="vehicle"  required>
                                <option value="{{$edit->vehicle_id}}">{{$edit->vehicleDetail->license_plate}}</option>
                                @foreach(\App\Helpers\Utility::driverVehicles() as $data)
                                    <option value="{{$data->id}}">{{$data->make->make_name}} {{$data->model->model_name}} ({{$data->license_plate}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            @endif

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->name}}" class="form-control" id="" name="name" placeholder="Part Name" >
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <b>Part Number</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->part_no}}" class="form-control" id="" name="part_no" placeholder="Part Number" >
                    </div>
                </div>
            </div>
            
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-8">
                <b>Location</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="location" placeholder="Location" >{{$edit->location}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Quantity*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" value="{{$edit->quantity}}" class="form-control" id="" name="quantity" placeholder="Quantity" >
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

