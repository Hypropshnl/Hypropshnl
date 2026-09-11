<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control show-tick" name="type" required data-selected-text-format="count">
                            <option value="{{$edit->type}}">{{Utility::ATTENDANCE_TIME_REQUEST[$edit->type]}}</option>
                            @foreach(Utility::ATTENDANCE_TIME_REQUEST as $key => $var)
                            <option value="{{$key}}">{{$var}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="reason" placeholder="Reason for Request">{{$edit->reason}}</textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>