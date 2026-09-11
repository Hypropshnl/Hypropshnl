@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{$userDetail->firstname}} {{$userDetail->lastname}} Balance Score Card (BSC) {{Utility::BSC_TYPES[$type]}} Appraisal ({{$indiGoalSeries->goal_name}})
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'detail_id', $exportDocId = 'detail_id'])
                            </ul>
                        </li>

                    </ul>
                </div>

               
                <div class="body table-responsive" id="reload_data">

                    <!-- BEGIN OF TAB WIZARD -->

                    <div class="row">
                       
                    </div>

                    <div class="row">
                        <section >
                            <div class="body">
                                    <ul class="nav nav-tabs" role="tablist">

                                        @if(!empty($indiGoal))
                                            @foreach($indiGoal as $cat)
                                                <li role="presentation" class="{{ $loop->first ? 'active' : '' }}">
                                                    <a href="#step{{$cat->unit_goal_cat}}" data-toggle="tab" aria-controls="step{{$cat->unit_goal_cat}}" role="tab" title="{{$cat->u_goal_cat->category_name}}">
                                                        <span class="nav-tab">
                                                            <i class="material-icons">assignment</i>
                                                            {{$cat->u_goal_cat->category_name}}
                                                            <i class="material-icons">keyboard_tab</i>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif

                                        @if(!empty($unitGoalCat))
                                            @foreach($unitGoalCat as $cat)
                                                <li role="presentation" class="{{ $loop->first && empty($existingGoalCat) ? 'active' : '' }}">
                                                    <a href="#step{{$cat->id}}" data-toggle="tab" aria-controls="step{{$cat->id}}" role="tab" title="{{$cat->category_name}}">
                                                        <span class="nav-tab">
                                                            <i class="material-icons">assignment</i>
                                                            {{$cat->category_name}}
                                                            <i class="material-icons">keyboard_tab</i>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                                <li role="presentation">
                                                    <a href="#step_complete" data-toggle="tab" aria-controls="step_complete" role="tab" title="Overall Weighted Score">
                                                        <span class="nav-tab">
                                                            <i class="material-icons">assignment</i>
                                                            Summary/Overall Weighted score
                                                        </span>
                                                    </a>
                                                </li>
                                                
                                        @endif
                                    </ul>

                                    <?php $arr1 = []; $arr2 = []; $arr3 = []; $arr4 = []; $arr5 = [];  ?>
                                    <div class="tab-content" id="main_table" >
                                        @if(!empty($indiGoal))
                                            @foreach($indiGoal as $edit)
                                                <div class="tab-pane {{ $loop->first ? 'active' : '' }}" role="tabpanel" id="step{{$edit->unit_goal_cat}}">

                                                    <div class="container">
                                                        <div class="body">
                                                            <h3>{{$edit->u_goal_cat->category_name}}</h3>
                                                        </div>
                                                        <div class="body">
                                                            <div class="col-md-4">
                                                                <div class="info-box hover-zoom-effect">
                                                                    <div class="icon bg-light-green">
                                                                        <i class="material-icons">equalizer</i>
                                                                    </div>
                                                                    <div class="content">
                                                                        <div class="text">Goals & Objectives Weighted Final Score</div>
                                                                        <div class="number">{{$edit->overall_weighted_score}}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="info-box hover-zoom-effect">
                                                                    <div class="icon bg-red">
                                                                        <i class="material-icons">gps_fixed</i>
                                                                    </div>
                                                                    <div class="content">
                                                                        <div class="text">Total Weight</div>
                                                                        <div class="number">{{$edit->total_obj_weight}}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="info-box hover-zoom-effect">
                                                                    <div class="icon bg-green">
                                                                        <i class="material-icons">verified_user</i>
                                                                    </div>
                                                                    <div class="content">
                                                                        <div class="text">Percentage Score((weighted/Total Weight)*100)</div>
                                                                        <div class="number">{{$edit->perct_score}}%</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                        <?php $arr1[] = 1; ?>
                                                    <form name="" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                                        <div class="body container " >
                                                            <div class="row clearfix">
                                                                <input type="hidden" value="{{$edit->department->id}}" name="dept_id">
                                                                <input type="hidden" name="goal_set" value="{{$edit->goal_set_id}}" >
                                                                <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                                <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                                <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                                <input type="hidden" name="reviewer_id" value="" >
                                                                <input type="hidden" name="type" value="{{$type}}" >
                                                            </div>

                                                        
                                                            <div class="body ">
                                                                <?php $num = 0; $countData = []; ?>
                                                                @foreach($edit->unit_goal_ext as $data)
                                                                    <?php $num++ ?>
                                                                    <?php $countData[] = $num; $disableLateEdit = (!empty($data->reviewer_score)) ? "readonly" : ""; ?>
                                                                    <div class="body card clearfix">
                                                                        <div class="row clearfix">
                                                                            <div class="col-md-12">
                                                                                    <b>Objective</b>
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <textarea rows="6" cols="50" class="form-control" {{$disableLateEdit}} {{$employee}} name="obj{{$num}}" placeholder="Objectives">{{$data->strat_obj}}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row clearfix">
                                                                            <div class="col-md-12">
                                                                                <b>Measure</b>
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <textarea class="form-control" name="measure{{$num}}" {{$disableLateEdit}} {{$employee}} placeholder="Measure">{{$data->measurement}}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <b>Desired Result</b>
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <textarea class="form-control" name="desired_result{{$num}}" {{$disableLateEdit}} {{$employee}} placeholder="Employee Comment">{{$data->desired_result}}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <b>Frequency</b>
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <select name="frequency{{$num}}" class="form-control" {{$disableLateEdit}} {{$employee}}>
                                                                                            <option value="{{$data->frequency}}" selected>{{!empty($data->frequency) ? Utility::FREQUENCY[$data->frequency] : ''}}</option>
                                                                                            @foreach(Utility::FREQUENCY as $key => $value)
                                                                                                <option value="{{$key}}">{{$value}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <b>Weight(%)</b>
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <input type="number" class="form-control" {{$disableLateEdit}} {{$employee}} value="{{$data->weight}}" name="weight{{$num}}" placeholder="Target Value">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <b>Start Value</b>
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <input class="form-control" name="start_value{{$num}}" {{$disableLateEdit}} {{$employee}}  value="{{$data->start_value}}" placeholder="Start Value">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            @if(Auth::user()->id == $edit->user_id)
                                                                            <div class="col-md-4">
                                                                                <b>Target Value</b>
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <input class="form-control" name="target_value{{$num}}" {{$disableLateEdit}} {{$employee}} value="{{$data->target_value}}" placeholder="Target Value">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @else
                                                                            <div class="col-md-4">
                                                                                <b>Target Value</b>
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <input class="form-control" name="target_value{{$num}}" readonly value="{{$data->target_value}}" placeholder="Target Value">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @endif
                                                                            
                                                                            <div class="col-md-4">
                                                                                <b>Employee Score</b>
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <input class="form-control" name="employee_score{{$num}}" {{$disableLateEdit}} {{$employee}} value="{{$data->score}}" placeholder="Employee Score">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>

                                                                        <!-- EMPLOYEE PERCENTAGE SCORE -->
                                                                        <hr>
                                                                        <div class="panel-group" id="accordion_employee_obj_{{$data->id}}" role="tablist" aria-multiselectable="true">
                                                                            <div class="panel panel-default">
                                                                                <div class="panel-heading" role="tab" id="headingOne_employee_obj_{{$data->id}}">
                                                                                    <h4 class="panel-title">
                                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion_employee_obj_{{$data->id}}" href="#collapseOne_employee_obj_{{$data->id}}" aria-expanded="false" aria-controls="collapseOne_employee_obj_{{$data->id}}">
                                                                                            Employee Weighted Score for this Objective : {{$data->employee_perct_score}}% (Click to view more)
                                                                                        </a>
                                                                                    </h4>
                                                                                </div>
                                                                                <div id="collapseOne_employee_obj_{{$data->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_employee_obj_{{$data->id}}">
                                                                                    <div class="panel-body">

                                                                                        <div class="body">
                                                                                            <div class="col-md-4">
                                                                                                <div class="info-box hover-zoom-effect">
                                                                                                    <div class="icon bg-light-green">
                                                                                                        <i class="material-icons">equalizer</i>
                                                                                                    </div>
                                                                                                    <div class="content">
                                                                                                        <div class="text">Percentage Score((score/100)*weight)</div>
                                                                                                        <div class="number">{{$data->total_score}}%</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="info-box hover-zoom-effect">
                                                                                                    <div class="icon bg-red">
                                                                                                        <i class="material-icons">gps_fixed</i>
                                                                                                    </div>
                                                                                                    <div class="content">
                                                                                                        <div class="text">Goals & Objectives Weight</div>
                                                                                                        <div class="number">{{$data->weight}}</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="info-box hover-zoom-effect">
                                                                                                    <div class="icon bg-green">
                                                                                                        <i class="material-icons">equalizer</i>
                                                                                                    </div>
                                                                                                    <div class="content">
                                                                                                        <div class="text">Goals & Objectives Weighted Final Score</div>
                                                                                                        <div class="number">{{$data->employee_perct_score}}</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row clearfix">
                                                                            <div class="col-md-10">
                                                                                Attach File (Optional)
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <input type="file" class="" multiple name="attachment{{$num}}[]" {{$employee}} placeholder="Attachment">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row clearfix">
                                                                            <div class="col-md-12">
                                                                                Employee Comment
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <textarea rows="6" cols="50" class="form-control" {{$employee}} name="employee_comment{{$num}}" placeholder="Employee Comment">{{ $data->comment }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row clearfix">
                                                                            <div class="col-md-12">
                                                                                Reviewer Comment
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <textarea rows="6" cols="50" class="form-control" {{$assignedReviewer}} name="reviewer_comment{{$num}}" placeholder="Reviewer Comment"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        @if($indiGoalSeries->type == Utility::LINEAR_APPRAISAL && in_array(Auth::user()->id, json_decode($linearReviewers)))
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <input type="number" step="any" class="form-control " onchange="scoreRange({{$data->target_value}}, {{$data->start_value}})" {{$assignedReviewer}} name="reviewer_score{{num}}" placeholder="Reviewer Score" >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($indiGoalSeries->appraisal_type == Utility::DEGREE_APPRAISAL && in_array(Auth::user()->id, json_decode($degreeReviewers)))
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <b>Reviewer Score</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <input type="number" step="any" class="form-control " onchange="scoreRange({{$data->target_value}}, {{$data->start_value}})" {{$assignedReviewer}} name="reviewer_score{{$num}}" placeholder="Reviewer Score" >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <b>Assigned Reviewer Weight for Appraisal</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <input type="text" class="form-control " readonly value="{{$arcData[Auth::user()->id]['score']}}" >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($indiGoalSeries->appraisal_type == Utility::DEGREE_APPRAISAL && !in_array(Auth::user()->id, json_decode($degreeReviewers)) && in_array(Auth::user()->id, json_decode($linearReviewers)))
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <input type="number" class="form-control " step="any" onchange="scoreRange({{$data->target_value}}, {{$data->start_value}})" {{$assignedReviewer}} name="reviewer_score{{num}}" placeholder="Reviewer Score" >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @php $indiObjScores = $data->indiScores; @endphp

                                                                        <!-- ARC REVIEWERS  FOR VIEWING PURPOSE -->
                                                                        <hr>
                                                                        <span ><h4>Appraisal Reviewing committee(ARC)</h4></span>
                                                                        @foreach($indiObjScores as $score)
                                                                            <div class="row">
                                                                                @if($score->arc_status == Utility::STATUS_ACTIVE)
                                                                                    
                                                                                    <div class="panel-group" id="accordion_obj_{{$score->id}}" role="tablist" aria-multiselectable="true">
                                                                                        <div class="panel panel-default">
                                                                                            <div class="panel-heading" role="tab" id="headingOne_obj_{{$score->id}}">
                                                                                                <h4 class="panel-title">
                                                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion_obj_{{$score->id}}" href="#collapseOne_obj_{{$score->id}}" aria-expanded="false" aria-controls="collapseOne_obj_{{$score->id}}">
                                                                                                        {{$score->reviewer->firstname}} {{$score->reviewer->lastname}} - {{$score->perct_score}}% (click to view details)
                                                                                                    </a>
                                                                                                </h4>
                                                                                            </div>
                                                                                            <div id="collapseOne_obj_{{$score->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_obj_{{$score->id}}">
                                                                                                <div class="panel-body">
                                                                                                    
                                                                                                    <div class="row card">
                                                                                                        <div class="col-md-12">
                                                                                                            <b>Comment : </b>
                                                                                                            <p >{{$score->comment}}</p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <table class="table table-responsive">
                                                                                                            <thead>
                                                                                                            <th>Score</th>
                                                                                                            <th>Percentage Score(%)<br>((score/target)*100/1)</th>
                                                                                                            <th>Assigned Reviewer Weight</th>
                                                                                                            <th>Weighted Score<br>((score/target)*assigned weight)</th>
                                                                                                            <th>Weighted Score Percentage(%)<br> ((Weighted Score/Assigned Weight)*100/1)</th>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td>{{$score->score}}</td>
                                                                                                                    <td>{{$score->total_score}}</td>
                                                                                                                    <td>{{isset($arcData[$score->reviewer_user_id]['score']) ? $arcData[$score->reviewer_user_id]['score'] : ''}}</td>
                                                                                                                    <td>{{$score->final_score}}</td>
                                                                                                                    <td>{{$score->perct_score}}</td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    
                                                                                @endif
                                                                            </div>
                                                                        @endforeach

                                                                        <!-- NORMAL/ASSIGNED REVIEWERS FOR VIEWING PURPOSE -->
                                                                        <span ><h4>Assinged Reviewer(s)</h4></span>
                                                                        @foreach($indiObjScores as $score)
                                                                            <div class="row">
                                                                                @if($score->arc_status == Utility::ZERO)

                                                                                    <div class="panel-group" id="accordion_obj_linear_{{$score->id}}" role="tablist" aria-multiselectable="true">
                                                                                        <div class="panel panel-default">
                                                                                            <div class="panel-heading" role="tab" id="headingOne_obj_linear_{{$score->id}}">
                                                                                                <h4 class="panel-title">
                                                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion_obj_linear_{{$score->id}}" href="#collapseOne_obj_linear_{{$score->id}}" aria-expanded="false" aria-controls="collapseOne_obj_linear_{{$score->id}}">
                                                                                                        {{$score->reviewer->firstname}} {{$score->reviewer->lastname}} - {{$score->perct_score}}% (click to view details)
                                                                                                    </a>
                                                                                                </h4>
                                                                                            </div>
                                                                                            <div id="collapseOne_obj_linear_{{$score->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_obj_linear_{{$score->id}}">
                                                                                                <div class="panel-body">
                                                                                                    
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-12">
                                                                                                            <b>Comment : </b>
                                                                                                            <p >{{$score->comment}}</p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <table class="table table-responsive">
                                                                                                            <thead>
                                                                                                            <th>Score</th>
                                                                                                            <th>Weighted Score Percentage(%)<br>((score/target)*100/1)</th>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td>{{$score->score}}</td>
                                                                                                                    <td>{{$score->total_score}}</td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            
                                                                                @endif

                                                                            </div>
                                                                            
                                                                        @endforeach

                                                                        <!-- FINAL OR AVERAGE PERCENTAGE SCORE -->
                                                                        <hr>
                                                                        <div class="panel-group" id="accordion_obj_avg_{{$data->id}}" role="tablist" aria-multiselectable="true">
                                                                            <div class="panel panel-default">
                                                                                <div class="panel-heading" role="tab" id="headingOne_avg_{{$data->id}}">
                                                                                    <h4 class="panel-title">
                                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion_obj_avg_{{$data->id}}" href="#collapseOne_avg_{{$data->id}}" aria-expanded="false" aria-controls="collapseOne_avg_{{$data->id}}">
                                                                                            Average Percentage Score for this Objective : {{$data->reviewer_perct_score}}%
                                                                                        </a>
                                                                                    </h4>
                                                                                </div>
                                                                                <div id="collapseOne_avg_{{$data->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_avg_{{$data->id}}">
                                                                                    <div class="panel-body">
                                                                                        
                                                                                        <div class="body">
                                                                                            <div class="col-md-4">
                                                                                                <div class="info-box hover-zoom-effect">
                                                                                                    <div class="icon bg-light-green">
                                                                                                        <i class="material-icons">equalizer</i>
                                                                                                    </div>
                                                                                                    <div class="content">
                                                                                                        <div class="text">Percentage Score((score/100)*weight)</div>
                                                                                                        <div class="number">{{$data->reviewer_perct_score}}%</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="info-box hover-zoom-effect">
                                                                                                    <div class="icon bg-red">
                                                                                                        <i class="material-icons">gps_fixed</i>
                                                                                                    </div>
                                                                                                    <div class="content">
                                                                                                        <div class="text">Goals & Objectives Weight</div>
                                                                                                        <div class="number">{{$data->weight}}</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="info-box hover-zoom-effect">
                                                                                                    <div class="icon bg-green">
                                                                                                        <i class="material-icons">equalizer</i>
                                                                                                    </div>
                                                                                                    <div class="content">
                                                                                                        <div class="text">Goals & Objectives Weighted Final Score</div>
                                                                                                        <div class="number">{{$data->reviewer_weighted_score}}</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Attached Files -->
                                                                        <div class="row">
                                                                            <?php $attach = json_decode($data->attachment,true); $numAttach=0; ?>
                                                                            @if(empty($attach))
                                                                                No Document
                                                                            @else

                                                                                <table class="table table-responsive">
                                                                                    <thead>
                                                                                    <th>Attachment</th>
                                                                                    <th>Download</th>
                                                                                    <th>Preview</th>
                                                                                    <th>Remove Attachment</th>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($attach as $at)
                                                                                        <?php $numAttach++; ?>
                                                                                    <tr id="remove_indi_{{$numAttach}}">
                                                                                        <td>{{$at}}</td>
                                                                                        <td><a target="_blank" href="<?php echo URL::to('download_attachment?file='); ?>{{$at}}">
                                                                                                <i class="fa fa-files-o fa-2x"></i>
                                                                                            </a>
                                                                                        </td>
                                                                                        <td>
                                                                                            <button type="button" id="file_{{$numAttach}}" class="btn btn-outline-primary btn-view"
                                                                                                            data-file-url="{{ asset('files/'.$at) }}" onclick="previewFile('<?php echo 'file_'.$numAttach; ?>');">
                                                                                                        <i class="fa fa-eye me-2"></i>View File
                                                                                                    </button>
                                                                                        </td>
                                                                                        <td>
                                                                                            @if($edit->created_by == Auth::user()->id)
                                                                                            <button type="button"  onclick="removeOkrAttachment('remove_indi_{{$numAttach}}','<?php echo url('remove_appraisal_okr_attachment'); ?>','{{$data->id}}',
                                                                                                    '{{\App\Helpers\Utility::APP_OBJ_GOAL}}','{{$at}}','<?php echo csrf_token(); ?>')"
                                                                                                    class="btn btn-danger waves-effect">
                                                                                                Remove
                                                                                            </button>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            @endif
                                                                        </div>
                                                                        <input type="hidden"  value="{{$data->id}}" name="ext_id{{$num}}">
                                                                    </div>
                                                                @endforeach
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        @if(Auth::user()->id == $edit->user_id)
                                                                            <div class="col-sm-4" id="hide_button_edit_{{$edit->unit_goal_cat}}">
                                                                                <div class="form-group">
                                                                                    <div onclick="addMore('add_more_edit_{{$edit->unit_goal_cat}}','hide_button_edit_{{$edit->unit_goal_cat}}','-1','<?php echo URL::to('add_more'); ?>','unit_goal','hide_button_edit_{{$edit->unit_goal_cat}}');">
                                                                                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div id="add_more_edit_{{$edit->unit_goal_cat}}" class="container body"></div>

                                                        <input type="hidden" name="count_ext" value="<?php echo count($countData) ?>" >
                                                        <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                                        <input type="hidden" name="unit_goal_cat" value="{{$edit->unit_goal_cat}}" >
                                                        <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                                        <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                                    </form>

                                                    <ul class="list-inline pull-right">
                                                        <li><button type="button" onclick="submitMediaFormNoModal('editMainForm{{$edit->id}}','<?php echo url('edit_unit_goal'); ?>','',
                                                        '','<?php echo csrf_token(); ?>')" class="btn btn-primary next-step" {{$submitAccess}}>Save and continue</button></li>
                                                    </ul>
                                                    <hr/>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if(!empty($unitGoalCat))
                                            @foreach($unitGoalCat as $data)
                                                <div class="tab-pane {{ $loop->first && empty($existingGoalCat) ? 'active' : '' }}" role="tabpanel" id="step{{$data->id}}">
                                                    <div class="body">
                                                        <h3>{{$data->category_name}}</h3>
                                                    </div>
                                                    @if($userDetail->id == Auth::user()->id)
                                                        <form name="createMainForm1" id="createMainForm1" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                                            <div class="body container card" >
                                                                <div class="row clearfix">
                                                                    <input type="hidden" class="form-control" value="{{$data->id}}" name="unit_goal_category" >
                                                                    <input type="hidden" value="{{$dept->id}}" name="dept_id">
                                                                    <input type="hidden" name="goal_set" value="{{$indiGoalSeries->id}}" >
                                                                    <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                                    <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                                    <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                                    <input type="hidden" name="reviewer_id" value="" >
                                                                    <input type="hidden" name="type" value="{{$type}}" >
                                                                    <input type="hidden" name="employee" value="{{$userDetail->id}}" >
                                                                </div>
                                                                
                                                                <div class="body clearfix container">
                                                                    <div class="row clearfix">
                                                                        <div class="col-md-12">
                                                                            <b>Objective</b>
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <textarea class="form-control" name="obj[]" placeholder="Objectives"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row clearfix">
                                                                        <div class="col-md-12">
                                                                            <b>Measure</b>
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <textarea class="form-control" name="measure[]" placeholder="Measure"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <b>Desired Result</b>
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <textarea class="form-control" name="desired_result[]" placeholder="Employee Comment"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <b>Frequency</b>
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select name="frequency[]" class="form-control">
                                                                                        <option value="" selected>Select Frequency</option>
                                                                                        @foreach(Utility::FREQUENCY as $key => $value)
                                                                                           <option value="{{$key}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <b>Weight(%)</b>
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <input type="number" class="form-control" name="weight[]" placeholder="Weight Value">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <b>Start Value</b>
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <input type="number" class="form-control" name="start_value[]" placeholder="Start Value">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <b>Target Value</b>
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <input type="number" class="form-control" name="target_value[]" placeholder="Target Value">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <b>Employee Score</b>
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <input type="number" class="form-control" name="employee_score[]" placeholder="Employee Score">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>

                                                                    <div class="row clearfix">
                                                                        <div class="col-md-10">
                                                                            Attach File (Optional)
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <input type="file" class="form-control" multiple name="attachment[0][]" placeholder="Attachment">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row clearfix">
                                                                        <div class="col-md-12">
                                                                            <b>Employee Comment</b>
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <textarea class="form-control" name="employee_comment[]" placeholder="Employee Comment"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                        <div class="col-sm-4" id="hide_button_obj_{{$data->id}}">
                                                                            <div class="form-group">
                                                                                <div onclick="addMore('add_more_obj_{{$data->id}}','hide_button_obj_{{$data->id}}','0','<?php echo URL::to('add_more'); ?>','unit_goal','hide_button_obj_{{$data->id}}');">
                                                                                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                            <div class="container body" id="add_more_obj_{{$data->id}}"></div>
                                                        </form>
                                                        <ul class="list-inline pull-right">
                                                            <li>
                                                                <button onclick="submitMediaFormNoModal('createMainForm1','<?php echo url('create_unit_goal'); ?>','',
                                                                '','<?php echo csrf_token(); ?>')" type="button" class="pull-right btn btn-info waves-effect">
                                                                    Save and continue
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="tab-pane" role="tabpanel" id="step_complete">
                                            
                                            <div class="container">
                                                <h3>Summary/Overall Weighted Score</h3>
                                                <div class="body">
                                                    <div class="col-md-6">
                                                        <div class="info-box hover-zoom-effect">
                                                            <div class="icon bg-light-green">
                                                                <i class="material-icons">star_rate</i>
                                                            </div>
                                                            <div class="content">
                                                                <div class="text">Auto Performance Appraisal Rating</div>
                                                                <div class="number">{{$finalEmployeeRating}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-box hover-zoom-effect">
                                                            <div class="icon bg-green">
                                                                <i class="material-icons">dashboard</i>
                                                            </div>
                                                            <div class="content">
                                                                <div class="text">Overall Weighted Final Score</div>
                                                                <div class="number">{{$overallRatingScore}}%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                            </div>
                        </section>
                    </div>

                    <!-- END OF TAB WIZARD -->

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    /**
     * Validates reviewer score input
     * Accepts decimal/double numbers and clears input if outside range [startValue, targetValue]
     * @param {number} targetValue - Maximum allowed value
     * @param {number} startValue - Minimum allowed value
     */
    function scoreRange(targetValue, startValue) {
        // Get the input that triggered the oninput event
        var inputElement = event.target;
        var inputValue = inputElement.value.trim();

        // Check if input is empty (allow user to clear it)
        if (inputValue === '' || inputValue === null) {
            return;
        }

        // Parse as float to handle decimals
        var numValue = parseFloat(inputValue);

        // Validate that the input is a valid number
        if (isNaN(numValue)) {
            inputElement.value = '';
            alert('Please enter a valid decimal number');
            return;
        }

        // Convert to numbers for comparison (ensure proper numeric conversion)
        var target = parseFloat(targetValue);
        var start = parseFloat(startValue);

        // Check if values were properly converted
        if (isNaN(target) || isNaN(start)) {
            console.error('Invalid range values: target=' + targetValue + ', start=' + startValue);
            return;
        }

        // Check if value is within range [start, target]
        if (numValue > target) {
            inputElement.value = '';
            alert('Score must not exceed ' + target);
            return;
        }

        if (numValue < start) {
            inputElement.value = '';
            alert('Score must be at least ' + start);
            return;
        }

        // Keep the original input (preserves decimal precision as typed by user)
    }

    function save1(formModal,formId,submitUrl,reload_id,reloadUrl,token,obj,review,level) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var obj1 = classToArray2(obj);
        var level1 = classToArray2(level);
        var review1 = classToArray2(review);

        var jobj = sanitizeData(obj);
        var jlevel = sanitizeData(level);
        var jreview = sanitizeData(review);
        //alert(jcompName);

        if(arrayItemEmpty(obj1) == false && arrayItemEmpty(review1) == false){
        var postVars = inputVars + '&editor_input=' + summerNote+'&obj='+jobj+'&review='+jreview+'&level='+jlevel;
        //alert(postVars);
            //$('#loading_modal').modal('show');
        //$('#' + formModal).modal('hide');
        sendRequestForm(submitUrl, token, postVars)
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {

                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if (message2 == 'fail') {

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error", messageError, "error");

                } else if (message2 == 'saved') {

                    var successMessage = swalSuccess('Data saved successfully');
                    //swal("Success!", "Data saved successfully!", "success");
                    //location.reload();
                   /* clearClassInputs('obj_edit,obj_level_edit,');
                    hideAddedInputs2('new_app_obj_goal','add_more_obj','hide_button_obj','<?php echo URL::to('add_more'); ?>','app_obj_goal');
                    */
                } else {

                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                //reloadContent(reload_id, reloadUrl);
            }
        }
        //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    function save2(formModal,formId,submitUrl,reload_id,reloadUrl,token,core_comp,capable,level,review) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var core_comp1 = classToArray2(core_comp);
        var capable1 = classToArray2(capable);
        var level1 = classToArray2(level);
        var review1 = classToArray2(review);
        var jcore_comp = sanitizeData(core_comp);
        var jcapable = sanitizeData(capable);
        var jlevel = sanitizeData(level);
        var jreview = sanitizeData(review);

        if(arrayItemEmpty(core_comp1) == false && arrayItemEmpty(level1) == false){
            var postVars = inputVars + '&editor_input=' + summerNote+'&core_comp='+jcore_comp+'&capable='+jcapable+'&level='+jlevel+'&review='+jreview;
            //alert(postVars);
            //$('#loading_modal').modal('show');
            //$('#' + formModal).modal('hide');
            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    //$('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                        /*var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                        location.reload();*/

                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    //reloadContent(reload_id, reloadUrl);
                }
            }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    function save3(formModal,formId,submitUrl,reload_id,reloadUrl,token,core_comp,element,level,review) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var core_comp1 = classToArray2(core_comp);
        var element1 = classToArray2(element);
        var level1 = classToArray2(level);
        var review1 = classToArray2(review);
        var jcore_comp = sanitizeData(core_comp);
        var jelement = sanitizeData(element);
        var jlevel = sanitizeData(level);
        var jreview = sanitizeData(review);

        if(arrayItemEmpty(core_comp1) == false && arrayItemEmpty(level1) == false){
            var postVars = inputVars + '&editor_input=' + summerNote+'&core_comp='+jcore_comp+'&element='+jelement+'&level='+jlevel+'&review='+jreview;
            //alert(postVars);
            //$('#loading_modal').modal('show');
            //$('#' + formModal).modal('hide');
            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    $('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                        /*var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                        location.reload();*/

                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    //reloadContent(reload_id, reloadUrl);
                }
            }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    function submitDefaultApp(formModal,formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');;
        }
        var postVars = inputVars+'&editor_input='+summerNote;
        //alert(postVars);
        //$('#loading_modal').modal('show');
        //$('#'+formModal).modal('hide');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    //swal("Success!", "Data saved successfully!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                //reloadContent(reload_id,reloadUrl);
            }
        }

    }

    function removeOkrAttachment(attachmentId,submitUrl,dataId,appraisalType,fileName,token){
        //var inputVars = $('#'+formId).serialize();

        var postVars = 'dataId='+dataId+'&appraisalType='+appraisalType+'&fileName='+fileName;
        //alert(postVars);
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){
                        
                    var successMessage = swalSuccess('success');
                    //swal("Success!", "Data saved successfully!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                    $('#'+attachmentId).remove();
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                //reloadContent(reload_id,reloadUrl);
            }
        }

    }


</script>



<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

    <script>
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection