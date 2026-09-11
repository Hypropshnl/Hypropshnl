<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
    <h4>This new Goal Set/Cycle will store the current Supervision Config for Performance Appraisal</h4>
    <div class="row clearfix">
        <div class="col-sm-8">
            <b>Goal Set/Cycle Name</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$edit->goal_name}}" name="goal_set" placeholder="Goal set/cycle name">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <b>Appraisal Type</b>
                <div class="form-line">
                    <select name="appraisal_type" class="form-control">
                        @foreach(Utility::APPRAISAL_TYPE as $key => $name)
                            @if($key == $edit->appraisal_type)
                                <option value="{{$key}}" selected>{{$name}}</option>
                            @endif
                            <option value="{{$key}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <b>Start Date</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="date" class="form-control " name="start_date" placeholder="Start date" value="{{$edit->start_date}}">
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <b>End Date</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="date" class="form-control " name="end_date" placeholder="End date" value="{{$edit->end_date}}">
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <b>Description</b>
            <div class="form-group">
                <div class="form-line">
                    <textarea class="form-control" name="description" placeholder="Description">{{$edit->description}}</textarea>
                </div>
            </div>
        </div>
    </div><hr>

        <span><h3>Assign Scores (Total should be equal 100)</h3></span>
    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" readonly value="Objectives" class="form-control" name="" placeholder="">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control" name="objectives_weight" placeholder="Enter Weight" value="{{$edit->obj_weight}}">
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" readonly value="Technical Competency" class="form-control" name="" placeholder="">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control" name="technical_competency_weight" placeholder="Enter Weight" value="{{$edit->tech_weight}}">
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" readonly value="Behavioral Competency" class="form-control" name="" placeholder="">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control" name="behavioral_competency_weight" placeholder="Enter Weight" value="{{$edit->behav_weight}}">
                </div>
            </div>
        </div>
    </div><hr>
    
    <div class="row">
        @php $bscOkrCheck = ($edit->bsc_okr_obj_merge_status == Utility::STATUS_ACTIVE) ? "checked" : ""; @endphp
        <div class="col-m-6 pull-left">
            <b>Merge Individual and Unit Objective Score</b>
            <div class="form-group">
                <div class="f">
                    <input type="checkbox" value="1" class="form-control" {{$bscOkrCheck}} name="bsc_okr_obj_merge_status" />
                </div>
            </div>
        </div>
    </div><hr>


    <span><h3>Grade for Ratings </h3></span>
    <div class="row clearfix">
        @php $check = ($edit->auto_rating == Utility::STATUS_ACTIVE) ? "checked" : ""; @endphp
        <div class="col-m-6 pull-left">
            <b>Auto Rating</b>
            <div class="form-group">
                <div class="">
                    <input type="checkbox" value="1" class="form-control" name="auto_rating" {{$check}} >
                </div>
            </div>
        </div>
        <div class="col-m-4 pull-right">
            <b>Update Supervision Config</b>
            <div class="form-group">
                <div class="">
                    <input type="checkbox" value="1" class="form-control" name="update_supervision" >
                </div>
            </div>
        </div>
        
    </div>
    <div class="row clearfix">
        @if(!empty($edit->rating_data))
            @php $ratingData = json_decode($edit->rating_data, true);   @endphp
            @foreach($ratingData as $key => $value)
                
                <div class="row clearfix" id="remove_user{{$key}}">
                    <div class="col-sm-4" id="">
                        <div class="form-group">
                            <div class="form-line">
                                <select name="rating[]" id="">
                                    @foreach($rating as $rec)
                                        @if($key == $rec->id)
                                        <option value="{{$key}}" selected>{{$rec->name}}</option>
                                        @endif
                                        <option value="{{$rec->id}}">{{$rec->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="number" class="low_score_class form-control" value="{{$ratingData[$key]['low_score']}}" name="low_score[]" placeholder="Enter Low Score" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="number" class="high_score_class form-control" value="{{$ratingData[$key]['high_score']}}" name="high_score[]" placeholder="Enter High Score" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" onclick="deleteSingleItemWithParam('{{$edit->id}}','','reload_data','<?php echo url('appraisal_goal_set'); ?>',
                                '<?php echo url('delete_ug_series_rating'); ?>','<?php echo csrf_token(); ?>','remove_user{{$key}}');" class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>Delete
                        </button>
                    </div>

                </div>
            @endforeach
        @endif
        <div class="row" id="hide_button_edit">
            <div class="col-md-12">
                <div class="form-group">
                    <div onclick="addMore('add_more_edit','hide_button_edit','1','<?php echo URL::to('add_more'); ?>','multiple_rating_scores_edit','hide_button_edit');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>
            
        </div>

        </div>
        <div class="" id="add_more_edit"></div>
    </div>
      

    <div class="row clearfix">
        <div class="col-sm-4">
            <b>Employee Deadline</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="datetime-local" class="form-control" value="{{$edit->employee_deadline}}" name="employee_deadline" placeholder="Employee deadline">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <b>Reviewer Deadline</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="datetime-local" class="form-control" value="{{$edit->reviewer_deadline}}" name="reviewer_deadline" placeholder="Reviewer deadline">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <b>Survey</b>
            <div class="form-group">
                <div class="form-line">
                    <select name="survey" class="form-control">
                        <option value="{{$edit->survey_id}}">{{$edit->surveyData->session_name}}</option>
                        @foreach($survey as $s)
                            <option value="{{$s->id}}">{{$s->session_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

    </div>

    <span><h3>Notification</h3></span>
    <div class="row clearfix">
        <div class="col-sm-3">
            <b>Number of Notification</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control" value="{{$edit->notify_num}}" name="notification_number" placeholder="Number of Notification">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <b>Interval</b>
            <div class="form-group">
                <div class="form-line">
                    <select name="interval" class="form-control">
                        @foreach(Utility::RECUR_INTERVAL as $key => $value)
                            @if($key == $edit->frequency)
                                <option value="{{$key}}" selected>{{$value}}</option>
                            @endif
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <b>Time of Notification</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="time" class="form-control " value="{{$edit->time}}" name="notify_time" placeholder="Time of notification">
                </div>
            </div>
        </div>

    </div>

</div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepickers" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>