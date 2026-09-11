<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
    @php   $driver = (empty($edit->driver_id)) ? '' : $edit->driver->firstname.' '.$edit->driver->lastname; @endphp
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$driver}}" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL3','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select Driver">

                        <input type="hidden" value="{{$edit->driver_id}}" class="user_class" name="driver" id="user" />
                    </div>
                </div>
                <ul id="myUL3" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <b>Vehicle*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->vehicleDetail->license_plate}}" class="form-control" autocomplete="off" id="select_vehicle" onkeyup="searchOptionList('select_vehicle','myUL1','{{url('default_select')}}','search_vehicle','vehicle');" name="select_vehicle" placeholder="Select Vehicle">

                        <input type="hidden" value="{{$edit->vehicle_id}}" class="vehicle_class" name="vehicle" id="vehicle" />
                    </div>
                </div>
                <ul id="myUL1" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <b>Route Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->name}}" class="form-control" name="route_name" placeholder="Route Name" required>
                    </div>
                </div>
            </div>
            
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Pick-up Points</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea  class="form-control" name="pickup_points" placeholder="Pick Up Points" required>{{$edit->pickup_points}}</textarea>
                    </div>
                </div>
            </div>
        
            <div class="col-sm-6">
                <b>Drop-off Points</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea  class="form-control " name="dropoff_points" placeholder="Drop Off Points" >{{$edit->dropoff_points}}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Departure Time</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea  class="form-control " name="departure_time" placeholder="Departure Time" >{{$edit->departure_time}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <b>Arrival Time</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea  class="form-control " name="arrival_time" placeholder="Arrival Time" >{{$edit->arrival_time}}</textarea>
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

