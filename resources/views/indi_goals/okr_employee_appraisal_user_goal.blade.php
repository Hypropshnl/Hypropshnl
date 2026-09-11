@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{$userDetail->firstname}} {{$userDetail->lastname}} Objective and Key Result (OKR) Appraisal ({{$indiGoalSeries->goal_name}})
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
                            <div class="wizard">
                                <div class="wizard-inner">
                                    <div class="connecting-line"></div>
                                    <ul class="nav nav-tabs" role="tablist">

                                        <li role="presentation" class="active">
                                            <a href="#step{{\App\Helpers\Utility::APP_OBJ_GOAL}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::APP_OBJ_GOAL}}" role="tab" title="Appraisal Objectives and Goals">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil">Objectives and Goals</i>
                            </span>
                                            </a>
                                        </li>

                                        <li role="presentation" class="">
                                            <a href="#step{{\App\Helpers\Utility::COMP_ASSESS}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::COMP_ASSESS}}" role="tab" title="Competency Assessment">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil">Competency Assessment</i>
                            </span>
                                            </a>
                                        </li>
                                        <li role="presentation" class="">
                                            <a href="#step{{\App\Helpers\Utility::BEHAV_COMP2}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::BEHAV_COMP2}}" role="tab" title="Behavioural Competency">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil">Behavioural Competency</i>
                            </span>
                                            </a>
                                        </li>

                                        <li role="presentation" class="">
                                            <a href="#step{{\App\Helpers\Utility::INDI_REV_COMMENT}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::INDI_REV_COMMENT}}" role="tab" title="Individual/Reviewers Comment">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil">Reviewers Comment</i>
                            </span>
                                            </a>
                                        </li>

                                        <li role="presentation" class="">
                                            <a href="#step{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}" role="tab" title="Employee Comment of Appraisal Platform">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil">Employee Comment of Appraisal</i>
                            </span>
                                            </a>
                                        </li>

                                        <li role="presentation" class="disabled">
                                            <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok">Complete</i>
                            </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                    <?php $arr1 = []; $arr2 = []; $arr3 = []; $arr4 = []; $arr5 = [];  ?>
                                    <div class="tab-content" id="main_table" >
                                        <div class="tab-pane active" role="tabpanel" id="step{{\App\Helpers\Utility::APP_OBJ_GOAL}}">
                                            @if(in_array(\App\Helpers\Utility::APP_OBJ_GOAL,$existingGoalCat))

                                                @foreach($indiGoal as $edit)
                                                    @if($edit->indi_goal_cat == \App\Helpers\Utility::APP_OBJ_GOAL)

                                                        <div class="container">
                                                            @if($bscUnitGoalScore > 0)
                                                                <div class="body">
                                                                    <div class="col-md-4">
                                                                        <div class="info-box hover-zoom-effect">
                                                                            <div class="icon bg-light-green">
                                                                                <i class="material-icons">equalizer</i>
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="text">Individual and Unit Goal Perct Score</div>
                                                                                <div class="number">{{$okrBscAvgScore}}%</div>
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
                                                                                <div class="number">{{$indiGoalSeries->obj_weight}}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="info-box hover-zoom-effect">
                                                                            <div class="icon bg-green">
                                                                                <i class="material-icons">verified_user</i>
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="text">Weighted Final Score</div>
                                                                                <div class="number">{{$overallObjWeight}}%</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="body">
                                                                    <div class="col-md-6">
                                                                        <div class="info-box hover-zoom-effect">
                                                                            <div class="icon bg-pink">
                                                                                <i class="material-icons">assessment</i>
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="text">Average Unit Goal Percentage Score</div>
                                                                                <div class="number">{{$bscUnitGoalScore}}%</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="info-box hover-zoom-effect">
                                                                            <div class="icon bg-orange">
                                                                                <i class="material-icons">assessment</i>
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="text">Average Individual Goal Percentage Score</div>
                                                                                <div class="number">{{$edit->perct_score}}%</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="body">
                                                                    <div class="col-md-4">
                                                                        <div class="info-box hover-zoom-effect">
                                                                            <div class="icon bg-light-green">
                                                                                <i class="material-icons">equalizer</i>
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="text">Average Percentage Score</div>
                                                                                <div class="number">{{$edit->perct_score}}%</div>
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
                                                                                <div class="number">{{$indiGoalSeries->obj_weight}}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="info-box hover-zoom-effect">
                                                                            <div class="icon bg-green">
                                                                                <i class="material-icons">verified_user</i>
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="text">Goals & Objectives Weighted Final Score</div>
                                                                                <div class="number">{{$overallObjWeight}}%</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
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
                                                                </div>

                                                            
                                                                <div class="body ">
                                                                    <?php $num = 0; $countData = []; ?>
                                                                    @foreach($edit->indiObj as $data)
                                                                        <?php $num++ ?>
                                                                        <?php $countData[] = $num; $disableLateEdit = (!empty($data->reviewer_score)) ? "readonly" : ""; ?>
                                                                        <div class="body card clearfix">
                                                                            <div class="row clearfix">
                                                                                <div class="col-md-12">
                                                                                        <b>Objective</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <textarea rows="6" cols="50" class="form-control" {{$disableLateEdit}} {{$employee}} name="obj{{$num}}" placeholder="Objectives">{{$data->objectives}}</textarea>
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
                                                                                                Employee Percentage Score for this Objective : {{$data->employee_perct_score}}%
                                                                                            </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="collapseOne_employee_obj_{{$data->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_employee_obj_{{$data->id}}">
                                                                                        <div class="panel-body">
                                                                                            <p>The employee percentage score for this objective is calculated by dividing the employee's actual score by the target value and multiplying it by 100.</p>
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
                                                                                            
                                                                                            <p>The average percentage score for this objective is calculated by adding the percentage scores of all the reviewers for this objective and dividing it by the number of reviewers for this objective.</p>

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
                                                                                <div class="col-sm-4" id="hide_button_edit">
                                                                                    <div class="form-group">
                                                                                        <div onclick="addMore('add_more_edit','hide_button_edit','-1','<?php echo URL::to('add_more'); ?>','app_obj_goal','hide_button_edit');">
                                                                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div id="add_more_edit" class="container body"></div>
                                                            <input type="hidden" name="count_ext" value="<?php echo count($countData) ?>" >
                                                            <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                                            <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                                            <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                                            <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                                        </form>

                                                        <ul class="list-inline pull-right">
                                                            <li><button type="button" onclick="submitMediaFormNoModal('editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','',
                                                            '','<?php echo csrf_token(); ?>')" class="btn btn-primary next-step" {{$submitAccess}}>Save and continue</button></li>
                                                        </ul>
                                                    @endif
                                                    <hr/>
                                                @endforeach

                                            @elseif($userDetail->id == Auth::user()->id)
                                                
                                                <form name="createMainForm1" id="createMainForm1" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                                    <div class="body container card" >
                                                        <div class="row clearfix">
                                                            <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::APP_OBJ_GOAL}}" name="competency_type" >
                                                            <input type="hidden" value="{{$dept->id}}" name="dept_id">
                                                            <input type="hidden" name="goal_set" value="{{$indiGoalSeries->id}}" >
                                                            <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                            <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                            <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                            <input type="hidden" name="reviewer_id" value="" >
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
                                                                <div class="col-md-10">
                                                                    <b>Employee Comment</b>
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <textarea class="form-control" name="employee_comment[]" placeholder="Employee Comment"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            
                                                                <div class="col-sm-4" id="hide_button_obj">
                                                                    <div class="form-group">
                                                                        <div onclick="addMore('add_more_obj','hide_button_obj','0','<?php echo URL::to('add_more'); ?>','app_obj_goal','hide_button_obj');">
                                                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                    <div class="container body" id="add_more_obj"></div>
                                                </form>
                                                <ul class="list-inline pull-right">
                                                    <li>
                                                        <button onclick="submitMediaFormNoModal('createMainForm1','<?php echo url('create_indi_goal'); ?>','',
                                                        '','<?php echo csrf_token(); ?>')" type="button" class="pull-right btn btn-info waves-effect">
                                                            Save and continue
                                                        </button>
                                                    </li>
                                                </ul>

                                            @endif
                                                <!-- @if(count($arr1) < 1)
                                                    <ul class="list-inline pull-right">
                                                        <li><button type="button" class="btn btn-default prev-step" >Previous</button></li>
                                                        <li><button type="button" class="btn btn-default next-step" >Skip</button></li>
                                                        <li><button type="button" class="btn btn-primary btn-info-full next-step" >Save and continue</button></li>

                                                    </ul>
                                                @endif -->
                                                <!--END OF INDIVIDUAL OBJECTIVES-->
                                        </div>

                                        <div class="tab-pane" role="tabpanel" id="step{{\App\Helpers\Utility::COMP_ASSESS}}">
                                            @if(in_array(\App\Helpers\Utility::COMP_ASSESS,$existingGoalCat))
                                                @foreach($indiGoal as $edit)
                                                    @if($edit->indi_goal_cat == \App\Helpers\Utility::COMP_ASSESS)

                                                        <div class="container">
                                                            <div class="body">
                                                                <div class="col-md-4">
                                                                    <div class="info-box hover-zoom-effect">
                                                                        <div class="icon bg-light-green">
                                                                            <i class="material-icons">equalizer</i>
                                                                        </div>
                                                                        <div class="content">
                                                                            <div class="text">Percentage Score((score/100)*weight)</div>
                                                                            <div class="number">{{$edit->perct_score}}%</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="info-box hover-zoom-effect">
                                                                        <div class="icon bg-red">
                                                                            <i class="material-icons">gps_fixed</i>
                                                                        </div>
                                                                        <div class="content">
                                                                            <div class="text">Technical Comptency Weight</div>
                                                                            <div class="number">{{$indiGoalSeries->tech_weight}}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="info-box hover-zoom-effect">
                                                                        <div class="icon bg-green">
                                                                            <i class="material-icons">verified_user</i>
                                                                        </div>
                                                                        <div class="content">
                                                                            <div class="text">Technical Competency Weighted Final Score</div>
                                                                            <div class="number">{{$overallTechWeight}}%</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                            <?php $arr2[] = 2; ?>
                                                        <form name="" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                                            <div class="row clearfix">
                                                                <input type="hidden" value="{{$edit->department->id}}" name="dept_id">
                                                                <input type="hidden" name="goal_set" value="{{$edit->goal_set_id}}" >
                                                                <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                                <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                                <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                                <input type="hidden" name="reviewer_id" value="" >
                                                            </div>

                                                            <div class="container body">
                                                                <div class="body card">
                                                                    <?php $num = 0; $countData = []; ?>
                                                                    @foreach($edit->compAssess as $data)
                                                                        <?php $num++  ?>
                                                                        <?php $countData[] = $num;  ?>
                                                                        <div class="row">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <b>Core Competencies</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <select class="form-control" {{$employee}} name="core_comp_edit[{{$num}}]" id="core_comp_edit" onchange="fillNextInputParamGetVal('core_comp_edit','capable_edit','<?php echo url('default_select'); ?>','core_tech_comp','capable_edit{{$num}}')" >
                                                                                                <option value="">Core Technical Competency</option>
                                                                                                @foreach($techComp as $ap)
                                                                                                    @if($data->core_comp == $ap->id)
                                                                                                        <option value="{{$ap->id}}" selected>{{$ap->category_name}}</option>
                                                                                                    @else
                                                                                                        <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <b>Capabilites</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line " id="capable_edit" >
                                                                                            <select  class="form-control" name="capable_edit{{$num}}"  >
                                                                                                <option value="{{$data->capability}}" selected>{{$data->capability}}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <b>Employee Rating</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <select  class="form-control " {{$employee}} name="comp_level_edit{{$num}}" >
                                                                                                @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                                                    @if($data->level == $val)
                                                                                                        <option value="{{$val}}" selected>{{$val}}</option>
                                                                                                    @else
                                                                                                        <option value="{{$val}}">{{$val}}</option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <b>Reviewer Rating</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <select  class="form-control " {{$assignedReviewer}} name="rev_rate_edit{{$num}}" >
                                                                                                @foreach(APP\Helpers\Utility::REVIEW_COMP as $key => $val)
                                                                                                    @if($data->reviewer_rating == $key)
                                                                                                        <option value="{{$key}}" selected>{{$val}}</option>
                                                                                                    @else
                                                                                                        <option value="{{$key}}">{{$val}}</option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- EMPLOYEE PERCENTAGE SCORE -->
                                                                             <hr>
                                                                             <div class="panel-group" id="accordion_employee_tech_{{$data->id}}" role="tablist" aria-multiselectable="true">
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading" role="tab" id="headingOne_employee_tech_{{$data->id}}">
                                                                                        <h4 class="panel-title">
                                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion_employee_tech_{{$data->id}}" href="#collapseOne_employee_tech_{{$data->id}}" aria-expanded="false" aria-controls="collapseOne_employee_tech_{{$data->id}}">
                                                                                                Employee Percentage Score for this Technical Competency - {{$data->employee_perct_score}}%
                                                                                            </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="collapseOne_employee_tech_{{$data->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_employee_tech_{{$data->id}}">
                                                                                        <div class="panel-body">
                                                                                            <p>The employee percentage score for this technical competency is calculated by dividing the employee score by the target value(5) and multiplying it by 100.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row clearfix">
                                                                                <div class="col-md-12">
                                                                                    Attach File (Optional)
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <input type="file" class="" {{$employee}} multiple name="attachment{{$num}}[]" {{$employee}} placeholder="Attachment">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row clearfix">
                                                                                <div class="col-md-12">
                                                                                    <b>Employee Comment</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <textarea rows="6" cols="50" class="form-control" {{$employee}} name="employee_comment{{$num}}" placeholder="Employee Comment">{{$data->comment}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row clearfix">
                                                                                <div class="col-md-12">
                                                                                    <b>Reviewer Comment</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <textarea class="form-control" {{$assignedReviewer}} name="reviewer_comment{{$num}}" placeholder="Reviewer Comment"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            @php $techScores = $data->techScores; @endphp

                                                                            <!-- ARC REVIEWERS  FOR VIEWING PURPOSE -->
                                                                             <hr>
                                                                            <span ><h4>Appraisal Reviewing committee(ARC)</h4></span>
                                                                            @foreach($techScores as $score)
                                                                                <div class="row">
                                                                                    @if($score->arc_status == Utility::STATUS_ACTIVE)
                                                                                        
                                                                                        <div class="panel-group" id="accordion_comp_{{$score->id}}" role="tablist" aria-multiselectable="true">
                                                                                            <div class="panel panel-default">
                                                                                                <div class="panel-heading" role="tab" id="headingOne_comp_{{$score->id}}">
                                                                                                    <h4 class="panel-title">
                                                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion_comp_{{$score->id}}" href="#collapseOne_comp_{{$score->id}}" aria-expanded="false" aria-controls="collapseOne_comp_{{$score->id}}">
                                                                                                            {{$score->reviewer->firstname}} {{$score->reviewer->lastname}} - {{$score->perct_score}}% (click to view details)
                                                                                                        </a>
                                                                                                    </h4>
                                                                                                </div>
                                                                                                <div id="collapseOne_comp_{{$score->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_comp_{{$score->id}}">
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
                                                                                                                <th>Percentage Score(%)<br>((score/target)*100/1)</th>
                                                                                                                <th>Assigned Reviewer Weight</th>
                                                                                                                <th>Weighted Score<br>((score/target)*assigned weight)</th>
                                                                                                                <th>Weighted Score Percentage(%)<br> ((Weighted Score/Assigned Weight)*100/1)</th>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td>{{$score->score}}</td>
                                                                                                                        <td>{{$score->total_score}}</td>
                                                                                                                        <td>{{isset($arcData[$score->reviewer_id]['score']) ? $arcData[$score->reviewer_id]['score'] : ''}}</td>
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
                                                                            <hr><span ><h4>Assinged Reviewer(s)</h4></span>
                                                                            @foreach($techScores as $score)
                                                                                <div class="row">
                                                                                    @if($score->arc_status == Utility::ZERO)

                                                                                        <div class="panel-group" id="accordion_comp_linear_{{$score->id}}" role="tablist" aria-multiselectable="true">
                                                                                            <div class="panel panel-default">
                                                                                                <div class="panel-heading" role="tab" id="headingOne_comp_linear_{{$score->id}}">
                                                                                                    <h4 class="panel-title">
                                                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion_comp_linear_{{$score->id}}" href="#collapseOne_comp_linear_{{$score->id}}" aria-expanded="false" aria-controls="collapseOne_comp_linear_{{$score->id}}">
                                                                                                            {{$score->reviewer->firstname}} {{$score->reviewer->lastname}} - {{$score->perct_score}}% (click to view details)
                                                                                                        </a>
                                                                                                    </h4>
                                                                                                </div>
                                                                                                <div id="collapseOne_comp_linear_{{$score->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_comp_linear_{{$score->id}}">
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
                                                                             <div class="panel-group" id="accordion_tech_avg_{{$data->id}}" role="tablist" aria-multiselectable="true">
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading" role="tab" id="headingOne_tech_avg_{{$data->id}}">
                                                                                        <h4 class="panel-title">
                                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion_tech_avg_{{$data->id}}" href="#collapseOne_tech_avg_{{$data->id}}" aria-expanded="false" aria-controls="collapseOne_tech_avg_{{$data->id}}">
                                                                                                Average Percentage Score for this Technical Competency - {{$data->reviewer_perct_score}}%
                                                                                            </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="collapseOne_tech_avg_{{$data->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_tech_avg_{{$data->id}}">
                                                                                        <div class="panel-body">
                                                                                            <p>The average percentage score for this technical competency is calculated by adding the percentage scores of all the reviewers for this technical competency and dividing it by the number of reviewers for this technical competency.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Attached Files -->
                                                                            <div class="row">
                                                                                <?php $attach = json_decode($data->attachment,true); $numAttach=0; ?>
                                                                                @if(count($attach) < 1)
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
                                                                                        <tr id="remove_comp_{{$data->id}}_{{$numAttach}}">
                                                                                            <td>{{$at}}</td>
                                                                                            <td><a target="_blank" href="<?php echo URL::to('download_attachment?file='); ?>{{$at}}">
                                                                                                    <i class="fa fa-files-o fa-2x"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                            <td>
                                                                                                <button type="button" id="file_{{$data->id}}{{$numAttach}}" class="btn btn-outline-primary btn-view"
                                                                                                                data-file-url="{{ asset('files/'.$at) }}" onclick="previewFile('<?php echo 'file_'.$data->id.$numAttach; ?>');">
                                                                                                            <i class="fa fa-eye me-2"></i>View File
                                                                                                        </button>
                                                                                            </td>
                                                                                            <td>
                                                                                                @if($edit->created_by == Auth::user()->id)
                                                                                                <button type="button"  onclick="removeOkrAttachment('remove_comp_{{$data->id}}_{{$numAttach}}','<?php echo url('remove_appraisal_okr_attachment'); ?>','{{$data->id}}',
                                                                                                        '{{\App\Helpers\Utility::COMP_ASSESS}}','{{$at}}','<?php echo csrf_token(); ?>')"
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
                                                                        <div class="col-md-10">
                                                                            @if(Auth::user()->id ==$edit->user_id)
                                                                                <div class="col-sm-4" id="hide_button_comp_edit">
                                                                                    <div class="form-group">
                                                                                        <div onclick="addMore('add_more_comp_edit','hide_button_comp_edit','-1','<?php echo URL::to('add_more'); ?>','comp_assess','hide_button_comp_edit');">
                                                                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="container clearfix" id="add_more_comp_edit">
                                                                </div>

                                                            </div>

                                                            <input type="hidden" name="count_ext" value="<?php echo count($countData) ?>" >
                                                            <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                                            <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                                            <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                                            <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                                        </form>

                                                        <ul class="list-inline pull-left">
                                                            <li><button type="button" class="btn btn-default prev-step" >Previous</button></li>
                                                        </ul>

                                                        <ul class="list-inline pull-right">

                                                            <li><button type="button" class="btn btn-primary next-step" onclick="submitMediaFormNoModal('editMainForm{{$edit->id}}','<?php echo url('create_indi_goal'); ?>','reload_data',
                                                            '','<?php echo csrf_token(); ?>')" {{$submitAccess}}>Save and continue</button></li>
                                                        </ul>
                                                    @endif
                                                    <hr/>
                                                @endforeach
                                            @elseif($userDetail->id == Auth::user()->id)

                                                <form name="createMainForm2" id="createMainForm2" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                                    <div class="container ">
                                                        <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::COMP_ASSESS}}" name="competency_type" >
                                                        <input type="hidden" name="goal_set" value="{{$indiGoalSeries->id}}" >
                                                        <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                        <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                        <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                        <input type="hidden" name="reviewer_id" value="" >
                                                        <div class="container body card">
                                                            <div class="row clearfix">
                                                                <div class="col-sm-12">
                                                                    <b>Competency Category</b>
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <select class="form-control core_comp" name="core_comp[]" id="core_comp" onchange="fillNextInputParamGetVal('core_comp','capable','<?php echo url('default_select'); ?>','core_tech_comp','capable[]')" >
                                                                                <option value="">Core Technical Competency</option>
                                                                                @foreach($techComp as $ap)
                                                                                    <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row clearfix">
                                                                <div class="col-sm-12">
                                                                    <b>Competency Capabilities</b>
                                                                    <div class="form-group">
                                                                        <div class="form-line capable" id="capable" >
                                                                            <select  class="form-control" name="capable[]"  >
                                                                                <option value="">Capabilities</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row clearfix">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <select  class="form-control comp_level" name="comp_level[]" >
                                                                                <option value="" selected>Level</option>
                                                                                @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                                    <option value="{{$val}}">{{$val}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row clearfix">
                                                                <div class="col-md-10">
                                                                    <b>Attach File (Optional)</b>
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
                                                            <div class="col-sm-4" id="hide_button_comp">
                                                                <div class="form-group">
                                                                    <div onclick="addMore('add_more_comp','hide_button_comp','0','<?php echo URL::to('add_more'); ?>','comp_assess','hide_button_comp');">
                                                                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="container body" id="add_more_comp"></div>
                                                </form>

                                                <ul class="list-inline pull-left">
                                                    <li><button type="button" class="btn btn-info prev-step" >Previous</button></li>
                                                </ul>

                                                <ul class="list-inline pull-right">
                                                    <li>
                                                        <button onclick="submitMediaFormNoModal('createMainForm2','<?php echo url('create_indi_goal'); ?>','',
                                                        '','<?php echo csrf_token(); ?>')" type="button" class=" btn btn-info waves-effect">
                                                            Save and continue
                                                        </button>
                                                    </li>
                                                </ul>

                                            @endif
                                        </div>

                                        <div class="tab-pane" role="tabpanel" id="step{{\App\Helpers\Utility::BEHAV_COMP2}}">
                                            @if(in_array(Utility::BEHAV_COMP2,$existingGoalCat))
                                                @foreach($indiGoal as $edit)

                                                    @if($edit->indi_goal_cat == \App\Helpers\Utility::BEHAV_COMP2)

                                                        <div class="container">
                                                            <div class="body">
                                                                <div class="col-md-4">
                                                                    <div class="info-box hover-zoom-effect">
                                                                        <div class="icon bg-light-green">
                                                                            <i class="material-icons">equalizer</i>
                                                                        </div>
                                                                        <div class="content">
                                                                            <div class="text">Percentage Score((score/100)*weight)</div>
                                                                            <div class="number">{{$edit->perct_score}}%</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="info-box hover-zoom-effect">
                                                                        <div class="icon bg-red">
                                                                            <i class="material-icons">gps_fixed</i>
                                                                        </div>
                                                                        <div class="content">
                                                                            <div class="text">Behavioural Competency Weight</div>
                                                                            <div class="number">{{$indiGoalSeries->behav_weight}}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="info-box hover-zoom-effect">
                                                                        <div class="icon bg-green">
                                                                            <i class="material-icons">verified_user</i>
                                                                        </div>
                                                                        <div class="content">
                                                                            <div class="text">Behavioural Competency Weighted Final Score</div>
                                                                            <div class="number">{{$overallBehavWeight}}%</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php $arr3[] = 3; ?>
                                                        <form name="editMainForm{{$edit->id}}" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                                            <div class="container" >
                                                                <div class="row clearfix">
                                                                    <input type="hidden" value="{{$edit->department->id}}" name="dept_id">
                                                                    <input type="hidden" name="goal_set" value="{{$edit->goal_set_id}}" >
                                                                    <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                                    <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                                    <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                                    <input type="hidden" name="reviewer_id" value="" >
                                                                </div>

                                                                
                                                                <div class="container body ">
                                                                    
                                                                    <?php $num = 0; $countData = []; ?>
                                                                    @foreach($edit->behavCompetency as $data)
                                                                        <?php $num++  ?>
                                                                        <?php $countData[] = $num;  ?>
                                                                        <div class="body card">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <b>Competency Category</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <select  class="form-control" {{$employee}} name="core_behav_comp_edit{{$num}}" id="core_behave_comp_edit{{$num}}" onchange="fillNextInputParamGetVal('core_behave_comp_edit{{$num}}','element_edit_id{{$num}}','<?php echo url('default_select'); ?>','core_behav_comp','element_edit{{$num}}')" >

                                                                                                @foreach($behavComp as $ap)
                                                                                                    @if($data->core_behav_comp == $ap->id)
                                                                                                        <option value="{{$ap->id}}" selected>{{$ap->category_name}}</option>
                                                                                                    @else
                                                                                                        <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <b>Elements of Behavioural Competency</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line" id="element_edit_id{{$num}}" >
                                                                                            <select  class="form-control" name="element_edit{{$num}}"  >
                                                                                                <option value="{{$data->element_behav_comp}}" selected>{{$data->element_behav_comp}}</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <b>Employee Rating Level</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <select  class="form-control" {{$employee}} name="behav_level_edit{{$num}}" >
                                                                                                @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                                                    @if($data->level == $val)
                                                                                                        <option value="{{$val}}" selected>{{$val}}</option>
                                                                                                    @else
                                                                                                        <option value="{{$val}}">{{$val}}</option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <b>Reviewer Rating Level</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <select  class="form-control" {{$assignedReviewer}} name="behav_rev_rate_edit{{$num}}" >
                                                                                                <option value="" selected>--Select Reviewer Rating--</option>
                                                                                            @foreach(APP\Helpers\Utility::REVIEW_RATE2 as $key => $val)
                                                                                                    <option value="{{$val}}">{{$val}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- FINAL OR AVERAGE PERCENTAGE SCORE -->
                                                                             <hr>
                                                                            <div class="panel-group" id="accordion_employee_behav_{{$data->id}}" role="tablist" aria-multiselectable="true">
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading" role="tab" id="headingOne_behav_avg_{{$data->id}}">
                                                                                        <h4 class="panel-title">
                                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion_employee_behav_{{$data->id}}" href="#collapseOne_employee_behav_{{$data->id}}" aria-expanded="false" aria-controls="collapseOne_employee_behav_{{$data->id}}">
                                                                                                Employee Percentage Score for this Behavioural Competency - {{$data->employee_perct_score}}%
                                                                                            </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="collapseOne_employee_behav_{{$data->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_employee_behav_{{$data->id}}">
                                                                                        <div class="panel-body">
                                                                                            <p>The employee percentage score for this behavioural competency is calculated by adding the ratings given by the employee for this behavioural competency and dividing it by the target rating defined for this behavioural competency and multiplying it by 100 to get the percentage score for this behavioural competency.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row clearfix">
                                                                                <div class="col-md-10">
                                                                                    <b>Attach File (Optional)</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <input type="file" class="form-control" {{$employee}} multiple name="attachment{{$num}}[]" placeholder="Attachment">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row clearfix">
                                                                                <div class="col-md-12">
                                                                                    <b>Employee Comment</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <textarea cols="10" rows="10" {{$employee}} class="form-control" name="employee_comment{{$num}}" placeholder="Employee Comment">{{$data->comment}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row clearfix">
                                                                                <div class="col-md-12">
                                                                                    <b>Reviewer Comment</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <textarea class="form-control" {{$assignedReviewer}} name="reviewer_comment{{$num}}" placeholder="Reviewer Comment"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            @php $behavScores = $data->behavScores; @endphp

                                                                            <!-- ARC REVIEWERS  FOR VIEWING PURPOSE -->
                                                                             <hr>
                                                                             <span><h4>Appraisal Reviewing committee(ARC)</h4></span>
                                                                            @foreach($behavScores as $score)
                                                                                <div class="row">
                                                                                    @if($score->arc_status == Utility::STATUS_ACTIVE)
                                                                                        <div class="panel-group" id="accordion_behav_{{$score->id}}" role="tablist" aria-multiselectable="true">
                                                                                            <div class="panel panel-default">
                                                                                                <div class="panel-heading" role="tab" id="headingOne_behav_{{$score->id}}">
                                                                                                    <h4 class="panel-title">
                                                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion_behav_{{$score->id}}" href="#collapseOne_behav_{{$score->id}}" aria-expanded="false" aria-controls="collapseOne_behav_{{$score->id}}">
                                                                                                            {{$score->reviewer->firstname}} {{$score->reviewer->lastname}} - {{$score->perct_score}}% (click to view details)
                                                                                                        </a>
                                                                                                    </h4>
                                                                                                </div>
                                                                                                <div id="collapseOne_behav_{{$score->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_behav_{{$score->id}}">
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
                                                                                                                <th>Rating</th>
                                                                                                                <th>Percentage Rating(%)<br>((rating/target)*100/1)</th>
                                                                                                                <th>Assigned Reviewer Weight</th>
                                                                                                                <th>Weighted Score<br>((rating/target)*assigned weight)</th>
                                                                                                                <th>Weighted Score Percentage(%)<br> ((Weighted Score/Assigned Weight)*100/1)</th>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td>{{$score->review_rating}}</td>
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
                                                                            @foreach($behavScores as $score)
                                                                                <div class="row">
                                                                                    @if($score->arc_status == Utility::ZERO)

                                                                                        <div class="panel-group" id="accordion_behav_linear_{{ $score->id }}" role="tablist" aria-multiselectable="true">
                                                                                            <div class="panel panel-default">
                                                                                                <div class="panel-heading" role="tab" id="headingOne_behav_linear_{{ $score->id }}">
                                                                                                    <h4 class="panel-title">
                                                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion_behav_linear_{{ $score->id }}" href="#collapseOne_behav_linear_{{ $score->id }}" aria-expanded="false" aria-controls="collapseOne_behav_linear_{{ $score->id }}">
                                                                                                            Collapsible Group Item #1
                                                                                                        </a>
                                                                                                    </h4>
                                                                                                </div>
                                                                                                <div id="collapseOne_behav_linear_{{ $score->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_behav_linear_{{ $score->id }}">
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
                                                                                                                <th>Rating</th>
                                                                                                                <th>Weighted Score Percentage(%)<br>((score/target)*100/1)</th>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td>{{$score->review_rating}}</td>
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
                                                                            <div class="panel-group" id="accordion_behav_avg_{{$data->id}}" role="tablist" aria-multiselectable="true">
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading" role="tab" id="headingOne_behav_avg_{{$data->id}}">
                                                                                        <h4 class="panel-title">
                                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion_behav_avg_{{$data->id}}" href="#collapseOne_behav_avg_{{$data->id}}" aria-expanded="false" aria-controls="collapseOne_behav_avg_{{$data->id}}">
                                                                                                Average Percentage Score for this Behavioural Competency - {{$data->reviewer_perct_score}}%
                                                                                            </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="collapseOne_behav_avg_{{$data->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_behav_avg_{{$data->id}}">
                                                                                        <div class="panel-body">
                                                                                            <p>The average percentage score for this behavioural competency is calculated by adding the percentage scores of all the reviewers for this behavioural competency and dividing it by the number of reviewers for this behavioural competency.</p>
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
                                                                                        <tr id="remove_behav_{{$data->id}}_{{$numAttach}}">
                                                                                            <td>{{$at}}</td>
                                                                                            <td><a target="_blank" href="<?php echo URL::to('download_attachment?file='); ?>{{$at}}">
                                                                                                    <i class="fa fa-files-o fa-2x"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                            <td>
                                                                                                <button type="button" id="file_behav_{{$data->id}}{{$numAttach}}" class="btn btn-outline-primary btn-view"
                                                                                                                data-file-url="{{ asset('files/'.$at) }}" onclick="previewFile('<?php echo 'file_behav_'.$data->id.$numAttach; ?>');">
                                                                                                            <i class="fa fa-eye me-2"></i>View File
                                                                                                        </button>
                                                                                            </td>
                                                                                            <td>
                                                                                                @if($edit->created_by == Auth::user()->id)
                                                                                                <button type="button"  onclick="removeOkrAttachment('remove_behav_{{$data->id}}_{{$numAttach}}','<?php echo url('remove_appraisal_okr_attachment'); ?>','{{$data->id}}',
                                                                                                        '{{\App\Helpers\Utility::BEHAV_COMP2}}','{{$at}}','<?php echo csrf_token(); ?>')"
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
                                                                        <div class="row">
                                                                            @if(Auth::user()->id == $edit->user_id)
                                                                                <div class="col-sm-4" id="hide_button_behav_edit">
                                                                                    <div class="form-group">
                                                                                        <div onclick="addMore('add_more_behav_edit','hide_button_behav_edit','-1','<?php echo URL::to('add_more'); ?>','behav_comp2','hide_button_behav_edit');">
                                                                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row clearfix" id="add_more_behav_edit"></div>

                                                            <input type="hidden" name="count_ext" value="<?php echo count($countData) ?>" >
                                                            <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                                            <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                                            <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                                            <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                                        </form>

                                                        <ul class="list-inline pull-left">
                                                            <li><button type="button" class="btn btn-default prev-step" >Previous</button></li>

                                                        </ul>

                                                        <ul class="list-inline pull-right">

                                                            <li><button type="button" class="btn btn-primary btn-info-full next-step" onclick="submitMediaFormNoModal('editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','',
                                                            '','<?php echo csrf_token(); ?>')" {{$submitAccess}}>Save and continue</button></li>

                                                        </ul>
                                                    @endif
                                                    <hr/>
                                                    <!-- END OF BEHAVIOURAL ASSESSMENT -->

                                                @endforeach
                                            @elseif($userDetail->id == Auth::user()->id)
                                                <form name="createMainForm3" id="createMainForm3" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">                                    
                                                    <div class="container body">
                                                        <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::BEHAV_COMP2}}" name="competency_type" >
                                                        <input type="hidden" name="goal_set" value="{{$indiGoalSeries->id}}" >
                                                        <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                        <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                        <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                        <input type="hidden" name="reviewer_id" value="" >

                                                        <div class="container body card clearfix">
                                                            <div class="row clearfix">
                                                                <div class="col-md-12">
                                                                    <b>Competency Category</b>
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <select  class="form-control core_behav_comp" id="core_behav_comp" name="core_behav_comp[]" onchange="fillNextInputParamGetVal('core_behav_comp','element','<?php echo url('default_select'); ?>','core_behav_comp','element[]')" >
                                                                                <option value="">Core Behavioural Competency</option>
                                                                                @foreach($behavComp as $ap)
                                                                                    <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row clearfix">
                                                                <div class="col-md-12">
                                                                    <b>Elements of Behavioural Competency</b>
                                                                    <div class="form-group">
                                                                            <div class="form-line element" id="element" >
                                                                                <select  class="form-control" name="element[]"  >
                                                                                    <option value="">Elements of behavioural competency</option>
                                                                                </select>
                                                                            </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <select  class="form-control"  name="behav_level[]" >
                                                                                <option value="" selected>Level</option>
                                                                                @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                                    <option value="{{$val}}">{{$val}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row clearfix">
                                                                <div class="col-md-12">
                                                                    <b>Attach File (Optional)</b>
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
                                                            <div class="col-sm-4" id="hide_button_behav">
                                                                <div class="form-group">
                                                                    <div onclick="addMore('add_more_behav','hide_button_behav','0','<?php echo URL::to('add_more'); ?>','behav_comp2','hide_button_behav');">
                                                                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><hr>
                                                        
                                                    </div>
                                                    <div class="container body" id="add_more_behav"></div>
                                                </form>

                                                <ul class="list-inline pull-left">
                                                    <li><button type="button" class="btn btn-info prev-step" >Previous</button></li>
                                                </ul>

                                                <ul class="list-inline pull-right">
                                                    <li>
                                                        <button onclick="submitMediaFormNoModal('createMainForm3','<?php echo url('create_indi_goal'); ?>','',
                                                        '','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                                                            Save and continue
                                                        </button>
                                                    </li>
                                                </ul>

                                            @endif
                                        </div>

                                        <div class="tab-pane" role="tabpanel" id="step{{\App\Helpers\Utility::INDI_REV_COMMENT}}">
                                            @if(in_array(\App\Helpers\Utility::INDI_REV_COMMENT,$existingGoalCat))
                                                @foreach($indiGoal as $edit)

                                                        <!-- START  -->
                                                        @if($edit->indi_goal_cat == \App\Helpers\Utility::INDI_REV_COMMENT)

                                                            <div class="container">
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

                                                            <?php $arr4[] = 4; ?>
                                                            <form name="" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                                                <div class="container body">
                                                                    <div class="row clearfix">
                                                                        <input type="hidden" value="{{$edit->department->id}}" name="dept_id">
                                                                        <input type="hidden" name="goal_set" value="{{$edit->goal_set_id}}" >
                                                                        <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                                        <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                                        <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                                        <input type="hidden" name="reviewer_id" value="" >
                                                                    </div>

                                                                    <div class="container card clearfix">
                                                                        <div class="row clearfix">
                                                                            <div class="col-sm-6">
                                                                                Overview Strength
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <textarea  class="form-control" {{$assignedReviewer}}  name="overview_str" placeholder="Overview and strengths"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                Areas of Improvement
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <textarea {{$assignedReviewer}} class="form-control"  name="area_improv" placeholder="Areas of Improvement"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row clearfix">
                                                                            <div class="col-sm-12">
                                                                                Suggestions for personal and professional development
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <textarea class="form-control" {{$assignedReviewer}} name="sug_pp_dev" placeholder="Suggestions for personal and professional development"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row clearfix">
                                                                            @if($indiGoalSeries->auto_rating == Utility::ZERO)
                                                                                <div class="col-sm-6">
                                                                                    <b>Manual Overall Rating</b>
                                                                                    <div class="form-group">
                                                                                        <div class="form-line">
                                                                                            <select  class="form-control" {{$assignedReviewer}} name="over_rate" >
                                                                                                @foreach($overallRating as $val)
                                                                                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                                                                                @endforeach
                                                                                            </select>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <b>Recommendation</b>
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <select  class="form-control" {{$assignedReviewer}} name="recommendation" >
                                                                                                <option value="">Select Recommendation</option>
                                                                                            @foreach($recommendation as $val)
                                                                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div><hr>

                                                                    <span><h4> Reviewer Ratings/Recommendations</h4></span><hr>
                                                                    <?php $num = 0; $countData = []; ?>
                                                                    @foreach($edit->reviewerComments as $data)
                                                                        <?php $num++  ?>
                                                                        <?php $countData[] = $num;  ?>
                                                                        
                                                                        <div class="panel-group" id="accordion_{{$num}}" role="tablist" aria-multiselectable="true">
                                                                            <div class="panel panel-default">
                                                                                    <div class="panel-heading" role="tab" id="headingOne_{{$num}}">
                                                                                        <h4 class="panel-title">
                                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion_{{$num}}" href="#collapseOne_{{$num}}" aria-expanded="true" aria-controls="collapseOne_{{$num}}">
                                                                                                {{$data->reviewer->firstname}} {{$data->reviewer->lastname}} - {{$data->rating->name}} - {{$data->recommend->name}}
                                                                                            </a>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div id="collapseOne_{{$num}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_{{$num}}">
                                                                                        <div class="panel-body">
                                                                                            
                                                                                            <b>Overview Strength</b>
                                                                                            <p>{{$data->overview_strength}}</p><hr>
                                                                                            <b>Areas of Improvement</b>
                                                                                            <p>{{$data->area_improv}}</p><hr>
                                                                                            <b>Suggestions for personal and professional development</b>
                                                                                            <p>{{$data->suggest_pp_dev}}</p><hr>
                                                                                            <b>Recommendation</b>
                                                                                            <p>{{$data->recommend->name}}</p><hr>
                                                                                            @if($indiGoalSeries->auto_rating == Utility::ZERO)
                                                                                                <b>Manual Overall Rating</b>
                                                                                                <p>{{$data->rating->name}}</p><hr>
                                                                                            @endif

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        </div>

                                                                        
                                                                        
                                                                    @endforeach

                                                                </div>



                                                                <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                                                <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                                                <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                                                <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                                            </form>


                                                            <ul class="list-inline pull-left">
                                                                <li><button type="button" class="btn btn-default prev-step" >Previous</button></li>

                                                            </ul>
                                                            <ul class="list-inline pull-right">

                                                                <li><button type="button" class="btn btn-primary btn-info-full next-step" onclick="submitMediaFormNoModal('editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','',
                                                            '','<?php echo csrf_token(); ?>')" {{$submitAccess}}>Save and continue</button></li>
                                                            </ul>
                                                        @endif
                                                        <hr/>
                                                    <!--END OF INDIVIDUAL/REVIEWER COMMENTS-->
                                                    <!--  END  -->

                                                @endforeach
                                            @elseif(in_array(Auth::user()->id, json_decode($reviewerAccessArray)))
                                                <form name="createMainForm4" id="createMainForm4" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                                    <div class="container body">
                                                        <span>
                                                            <h4>
                                                                For Reviewers
                                                            </h4><hr>
                                                        </span>
                                                        <input type="hidden" class="form-control" value="{{$dept->id}}" name="department" placeholder="">
                                                        <input type="hidden" class="form-control" value="{{$userDetail->id}}" name="employee" placeholder="">
                                                        <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::INDI_REV_COMMENT}}" name="competency_type" >
                                                        <input type="hidden" name="goal_set" value="{{$indiGoalSeries->id}}" >
                                                        <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                        <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                        <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                        <input type="hidden" name="reviewer_id" value="" >
                                                        <div class="container card">
                                                            <div class="row clearfix">
                                                                <div class="col-sm-12">
                                                                    <b>Overview and Strengths</b>
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <textarea class="form-control" {{$assignedReviewer}} name="overview_str" placeholder="Overview and strengths"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row clearfix">
                                                                <div class="col-sm-12">
                                                                    <b>Areas of Improvement</b>
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <textarea class="form-control" {{$assignedReviewer}} name="area_improv" placeholder="Areas of Improvement"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row clearfix">
                                                                <div class="col-sm-12">
                                                                    <b>Suggestions for personal and professional development</b>
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <textarea class="form-control" {{$assignedReviewer}} name="sug_pp_dev" placeholder="Suggestions for personal and professional development"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row clearfix">
                                                                <div class="col-sm-6">
                                                                    Recommendation
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <select  class="form-control" {{$assignedReviewer}} name="recommendation" >
                                                                                <option value="" selected>Recommendation</option>
                                                                                @foreach($recommendation as $rec)
                                                                                    <option value="{{$rec->id}}">{{$rec->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if($indiGoalSeries->auto_rating == Utility::ZERO)
                                                                    <div class="col-sm-6">
                                                                        <b>Manual Overall Rating</b>
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <select  class="form-control" {{$assignedReviewer}} name="over_rate" >
                                                                                    <option value="" selected>Appraisal Rating</option>
                                                                                    @foreach($overallRating as $rec)
                                                                                        <option value="{{$rec->id}}">{{$rec->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <ul class="list-inline pull-left">
                                                    <li><button type="button" class="btn btn-info prev-step" >Previous</button></li>
                                                </ul>

                                                <ul class="list-inline pull-right">
                                                    <li><button {{$assignedReviewer}} onclick="submitMediaFormNoModal('createMainForm4','<?php echo url('create_indi_goal'); ?>','',
                                                    '','<?php echo csrf_token(); ?>')" type="button" class="btn btn-primary btn-info-full next-step" >Save and continue</button></li>
                                                </ul>

                                            @endif

                                        </div>

                                        <div class="tab-pane" role="tabpanel"  id="step{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}">
                                            @if(in_array(\App\Helpers\Utility::EMP_COM_APP_PLAT,$existingGoalCat))
                                                @foreach($indiGoal as $edit)
                                                    @if($edit->indi_goal_cat == \App\Helpers\Utility::EMP_COM_APP_PLAT)

                                                        <div class="container">
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

                                                        <?php $arr5[] = 5; ?>
                                                        <form name="" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                                            <div class="container body">
                                                                <div class="row clearfix">
                                                                    <input type="hidden" value="{{$edit->department->id}}" name="dept_id">
                                                                    <input type="hidden" name="goal_set" value="{{$edit->goal_set_id}}" >
                                                                    <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                                                    <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                                    <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                                    <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                                    <input type="hidden" name="reviewer_id" value="" >
                                                                </div><hr>

                                                                <div class="container card clearfix">
                                                                    <div class="col-sm-12">
                                                                        <b>Employee Comment of Appraisal Outcome</b>
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <textarea rows="10" cols="70" class="form-control" {{$employee}} name="emp_comment" placeholder="Employee comment of Appraisal Outcome">{{$edit->emp_comment}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                            <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                                            <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                                            <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                                            <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                                        </form>

                                                        <ul class="list-inline pull-left">
                                                            <li><button type="button" class="btn btn-default prev-step" >Previous</button></li>
                                                        </ul>
                                                        <ul class="list-inline pull-right">

                                                            <li><button type="button" class="btn btn-primary btn-info-full next-step" onclick="submitMediaFormNoModal('editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','',
                                                            '','<?php echo csrf_token(); ?>')" {{$submitAccess}}>Save and continue</button></li>
                                                        </ul>
                                                    @endif
                                                    <!--END OF INDIVIDUAL/REVIEWER COMMENTS-->
                                                @endforeach
                                            @elseif (Auth::user()->id == $userDetail->id)
                                                <form name="createMainForm5" id="createMainForm5" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                        
                                                    <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}" name="competency_type" >
                                                    <input type="hidden" name="goal_set" value="{{$indiGoalSeries->id}}" >
                                                    <input type="hidden" name="reviewer_access_array" value="{{$reviewerAccessArray}}" >
                                                    <input type="hidden" name="linear_reviewers" value="{{$linearReviewers}}" >
                                                    <input type="hidden" name="degree_reviewers" value="{{$degreeReviewers}}" >
                                                    <input type="hidden" name="reviewer_id" value="" >
                                                    <div class="container body">
                                                        <div class="container card clearfix">
                                                            <input type="hidden" class="form-control" value="{{$dept->id}}" name="department" placeholder="">
                                                            <div class="col-sm-12">
                                                                <b>Employee comment of Appraisal Outcome</b>
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea  class="form-control" {{$employee}} name="emp_comment" placeholder="Employee comment of Appraisal Outcome"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                </form>
                                                <ul class="list-inline pull-left">
                                                        <li><button type="button" class="btn btn-info prev-step" >Previous</button></li>

                                                </ul>
                                                <ul class="list-inline pull-right">
                                                    <li><button onclick="submitMediaFormNoModal('createMainForm5','<?php echo url('create_indi_goal'); ?>','',
                                                        '','<?php echo csrf_token(); ?>')" type="button" class="btn btn-primary btn-info-full next-step" >Save and continue</button></li>
                                                </ul>

                                            @endif

                                        </div>

                                        <div class="tab-pane" role="tabpanel" id="complete">
                                            <h3>Complete</h3>
                                            <p>You have successfully completed all steps.</p>
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