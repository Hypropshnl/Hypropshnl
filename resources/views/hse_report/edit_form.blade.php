<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">

    <div class="body">
    
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="location" value="{{$edit->location}}" placeholder="Location">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control " value="{{$edit->report_date}}" name="occurrence_date" placeholder="Date of occurrence">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="time" class="form-control " value="{{$edit->time}}" name="occurrence_time" placeholder="Time of occurrence">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">

            <div class="col-md-8">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" id="details_edit" class="form-control " name="details" placeholder="Details">{{$edit->report_details}}</textarea>
                        <script>
                            CKEDITOR.replace('details_edit');
                        </script>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control " name="actions_taken" placeholder="Actions Taken">{{$edit->action_taken}}</textarea>                                           
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="reported_by" value="{{$edit->reported_by}}" placeholder="Reported By">
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
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>