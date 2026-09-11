<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-3">
                <b>Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name}}" name="name" placeholder="Name" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <b>Geo Tag*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="geo_tag" required>
                            <option value="{{$edit->geo_tag_id}}">{{$edit->geoTag->tag_name}}</option>
                            @foreach($geoTag as $tag)
                            <option value="{{$tag->id}}">{{$tag->tag_name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Work Days*</b>
                <div class="form-group">
                    <div class="form-line">
                        @php
                            $workDaysArr = json_decode($edit->work_days);
                        @endphp
                        <select class="form-control week_day" multiple name="work_days[]" required data-live-search="true">
                            <option value="">Select Work Days</option>
                            @foreach(Utility::WEEKDAYS as $key => $var)
                                @if(in_array($key,$workDaysArr))
                                <option value="{{$key}}" selected>{{$var}}</option>
                                @else
                                <option value="{{$key}}" >{{$var}} </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Time Zone*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="time_zone" required>
                            <option value="{{$edit->time_zone_id}}">{{$edit->timeZone->name}}</option>
                            @foreach($timeZone as $tag)
                            <option value="{{$tag->id}}">{{$tag->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-3">
                <b>Start Time*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="time" class="form-control" value="{{$edit->start_time}}" name="start_time" placeholder="Start Time" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>End Time</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="time" class="form-control" value="{{$edit->end_time}}" name="end_time" placeholder="End Time" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Start Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control" value="{{$edit->start_date}}" name="start_date" placeholder="Start Date" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>End Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control" value="{{$edit->end_date}}" name="end_date" placeholder="End Date" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-3">
                <b>Lateness Starts After (Mins)*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->late_start_time}}" name="late_start_time" placeholder="Lateness Starts After" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Absence Starts After (Mins)</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->absence_start_time}}" name="absence_start_time" placeholder="Absence Starts After" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Notify Users for Lateness After (Number)</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->late_count_notify}}" name="late_count_notify" placeholder="Notify Users for Latenes After" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Notify Users for Absence After (Number)</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->absence_count_notify}}" name="absence_count_notify" placeholder="Notify Users for Absence After" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-3">
                <b>Late Request Start Time</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="time" class="form-control" value="{{$edit->late_request_start_time}}" name="late_request_start_time" placeholder="Late Request Start Time" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Late Request End Time</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="time" class="form-control" value="{{$edit->late_request_end_time}}" name="late_request_end_time" placeholder="Late Request End Time" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Absence Request Start Time</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="time" class="form-control" value="{{$edit->absence_request_start_time}}" name="absence_request_start_time" placeholder="Absence Request Start Time" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Absence Request End Time</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="time" class="form-control" value="{{$edit->absence_request_end_time}}" name="absence_request_end_time" placeholder="Absence Request End Time" required>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row clearfix">
            <div class="col-sm-3">
                <b>Break Start Time</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="time" class="form-control" value="{{$edit->break_time_start}}" name="break_start_time" placeholder="Break Start Time" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Break End Time</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="time" class="form-control" value="{{$edit->break_time_end}}" name="break_end_time" placeholder="Break End Time" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Break Period</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="time" class="form-control" value="{{$edit->break_period}}" name="break_period" placeholder="Break Period" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script type="text/javascript">
    $('.week_day').multiselect({
    buttonWidth: '200px', // Set width to 100% of its parent
    nonSelectedText: 'Select Week Day(s)'
    });

</script>