<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="name" value="{{$edit->name}}" placeholder="Name">
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <b>Frequency</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->frequency}}" name="frequency" placeholder="Frequency">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Details</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="details" placeholder="Details">{{$edit->details}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <b>Prompt Emails (Use comma to separate emails)</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="prompt_emails" placeholder="Details">{{$edit->prompt_emails}}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Last Audit Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control" value="{{$edit->last_audit_date}}" name="last_audit_date" placeholder="Last Audit Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <b>Next Audit Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control" value="{{$edit->next_audit_date}}" name="next_audit_date" placeholder="Next Audit Date">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>