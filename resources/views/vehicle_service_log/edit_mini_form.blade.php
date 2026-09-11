<form name="" id="editMiniMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

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
                <b>Actual Complete Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control" id="" value="{{$edit->actual_complete_date}}" name="actual_complete_date" placeholder="Actual Completion Date" >
                    </div>
                </div>
            </div>
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

