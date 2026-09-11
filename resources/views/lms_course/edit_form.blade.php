<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group">
                Course Name
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$edit->name}}" name="course_name" placeholder="Course Name">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                Course Code
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$edit->code}}" name="course_code" placeholder="Course Code">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                Course Overview
                <div class="form-line">
                    <textarea class="form-control" name="overview" placeholder="Course Overview">{{$edit->overview}}</textarea>
                </div>
            </div>
        </div>

    </div>

    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group">
                Amount
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$edit->amount}}" name="amount" placeholder="Amount">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                Validity (Day(s))
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$edit->validity}}" name="validity" placeholder="Validity">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                Hour(s) Per Day
                <div class="form-line">
                    <input type="number" class="form-control" value="{{$edit->hour_per_day}}" name="hours_per_day" placeholder="Hour(s) Per Day">
                </div>
            </div>
        </div>

    </div>
    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group">
                Duration (number of days before expiration)
                <div class="form-line">
                    <input type="number" class="form-control" value="{{$edit->duration}}" name="duration" placeholder="Duration">
                </div>
            </div>
        </div>
    </div>
    
    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group">
                Select Course Category
                <div class="form-line">
                    <select  class="form-control" name="course_category" >
                        <option selected value="{{$edit->category_id}}">{{$edit->category->name}}</option>
                        @foreach($lmsCourseCategory as $ap)
                            <option value="{{$ap->id}}">{{$ap->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                Certificate Status
                <div class="form-line">
                    <select  class="form-control" name="certificate_status" >
                        @php $certificateStatus = ($edit->certificate_status == Utility::STATUS_ACTIVE) ? 'ACTIVE' : 'INACTIVE'; @endphp
                        <option value="{{$edit->certificate_status}}">{{$certificateStatus}}</option>
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
        <div class="col-sm-4">
            <div class="form-group">
                Icon Image
                <div class="form-line">
                    <input type="file" class="form-control" name="icon_image" placeholder="Icon Image">
                </div>
            </div>
        </div>

    </div>

    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group">
                Certificate Template
                <div class="form-line">
                    <select class="form-control" name="certificate_template_id">
                        <option value="">Select Template</option>
                        @foreach($certificateTemplates as $template)
                            <option value="{{$template->id}}" {{ $edit->certificate_template_id == $template->id ? 'selected' : '' }}>{{$template->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                Organizer One
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$edit->name_one}}" name="name_one" placeholder="Organizer One">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                Organizer Two
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$edit->name_two}}" name="name_two" placeholder="Organizer Two">
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group">
                Organizer One Role
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$edit->name_one_role}}" name="name_one_role" placeholder="Organizer One Role">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                Organizer Two Role
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$edit->name_two_role}}" name="name_two_role" placeholder="Organizer Two Role">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                Organizer One Sign
                <div class="form-line">
                    <input type="file" class="form-control" name="name_one_sign" placeholder="Organizer One Sign">
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group">
                Organizer Two Sign
                <div class="form-line">
                    <input type="file" class="form-control" name="name_two_sign" placeholder="Organizer Two Sign">
                </div>
            </div>
        </div>
    </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    <input type="hidden" name="prev_photo" value="{{$edit->photo}}" >
    <input type="hidden" name="prev_name_one_sign" value="{{$edit->name_one_sign}}" >
    <input type="hidden" name="prev_name_two_sign" value="{{$edit->name_two_sign}}" >
</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>