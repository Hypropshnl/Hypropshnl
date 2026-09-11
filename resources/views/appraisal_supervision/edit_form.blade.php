<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="department" >
                            <option value="{{$edit->dept_id}}" selected>{{$edit->department->dept_name}}</option>
                            @foreach($dept as $de)
                                <option value="{{$de->id}}">{{$de->dept_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->hod->firstname}} {{$edit->hod->lastname}}" autocomplete="off" id="select_user2" onkeyup="searchOptionList('select_user2','myUL2','{{url('default_select')}}','default_search','user2');" name="select_user" placeholder="Department Head">

                        <input type="hidden" value="{{$edit->dept_id}}" class="user_class" name="supervisor" id="user2" />
                    </div>
                </div>
                <ul id="myUL2" class="myUL"></ul>
            </div>

        </div><hr>
        
        <div class="row clearfix">
            @php $check = ($edit->arc_status == 1) ? "checked" : ""; @endphp
            <div class="col-m-6 pull-left">
                <b>Enable Appraisal Reviewing Committee(ARC)</b>
                <div class="form-group">
                    <div class="">
                        <input type="checkbox" value="1" class="form-control" name="enable_arc" {{$check}} >
                    </div>
                </div>
            </div>
        </div><hr>

        <span><h3>Appraisal Reviewing Committee (ARC)</h3></span>
        <div class="row clearfix">
            @if(!empty($edit->arc_data))
                @php $arcData = json_decode($edit->arc_data, true);   @endphp
                @foreach($edit->arcUsers  as $user)
                    
                    <div class="row clearfix" id="remove_user{{$user->id}}">
                        <div class="col-sm-6" id="">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" value="{{$user->firstname}} {{$user->lastname}}" autocomplete="off" id="select_user_edit" onkeyup="searchOptionList('select_user_edit','myUL_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Select User">

                                    <input type="hidden" value="{{$user->id}}" class="user_class_edit" name="reviewer_edit[]" id="user_edit" />
                                </div>
                            </div>
                            <ul id="myUL_edit" class="myUL"></ul>
                        </div>

                        @if(!empty($arcData[$user->id]))
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" class="score_class_edit" value="{{$arcData[$user->id]['score']}}" name="score_edit[]" placeholder="Enter Score" />
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-sm-3">
                            <button type="button" onclick="deleteSingleItemWithParam('{{$edit->id}}','{{$user->id}}','reload_data','<?php echo url('appraisal_supervision'); ?>',
                                    '<?php echo url('delete_appraisal_sup_user'); ?>','<?php echo csrf_token(); ?>','remove_user{{$user->id}}');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </div>

                    </div>
                @endforeach
            @endif
            <div class="row" id="hide_button_edit">
                <div class="col-md-12">
                    <div class="form-group">
                        <div onclick="addMore('add_more_edit','hide_button_edit','1','<?php echo URL::to('add_more'); ?>','multiple_user_scores_edit','hide_button_edit');">
                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                        </div>
                    </div>
                </div>
                
            </div>

            </div>
            <div class="" id="add_more_edit"></div>
        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>