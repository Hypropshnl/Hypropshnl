@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Goal Set/Cycle</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <h4>This new Goal Set/Cycle will store the current Supervision Config for Performance Appraisal</h4>
                            <div class="row clearfix">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="goal_set" placeholder="Goal set/cycle name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="appraisal_type" class="form-control">
                                                <option value="">Select Appraisal Type</option>
                                                @foreach(Utility::APPRAISAL_TYPE as $key => $name)
                                                    <option value="{{$key}}">{{$name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="start_date" placeholder="Start date">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="end_date" placeholder="End date">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="description" placeholder="Description"></textarea>
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
                                            <input type="number" class="form-control" name="objectives_weight" placeholder="Enter Weight">
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
                                            <input type="number" class="form-control" name="technical_competency_weight" placeholder="Enter Weight">
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
                                            <input type="number" class="form-control" name="behavioral_competency_weight" placeholder="Enter Weight">
                                        </div>
                                    </div>
                                </div>
                            </div><hr>

                            <span><h3>Grade for Ratings </h3></span>
                            <div class="row clearfix">
                                <div class="col-m-6 pull-left">
                                    <b>Automatic Rating</b>
                                    <div class="form-group">
                                        <div class="">
                                            <input type="checkbox" value="1" class="form-control" name="auto_recommend" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-m-6 pull-right">
                                    <b>Merge Individual and Unit Objective Score</b>
                                    <div class="form-group">
                                        <div class="">
                                            <input type="checkbox" value="1" class="form-control" name="bsc_okr_obj_merge_status" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                
                                <div class="col-sm-4" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="rating[]" id="">
                                                <option value="">Select Rating</option>
                                                @foreach($rating as $rec)
                                                    <option value="{{$rec->id}}">{{$rec->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="low_score_class" name="low_score[]" placeholder="Enter Low Score" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="high_score_class" name="high_score[]" placeholder="Enter High Score" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1" id="hide_button">
                                    <div class="form-group">
                                        <div onclick="addMore('add_more','hide_button','1','<?php echo URL::to('add_more'); ?>','multiple_rating_scores','hide_button');">
                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="" id="add_more"></div><hr>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Employee Deadline</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="datetime-local" class="form-control" name="employee_deadline" placeholder="Employee deadline">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Reviewer Deadline</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="datetime-local" class="form-control" name="reviewer_deadline" placeholder="Reviewer deadline">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Survey</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="survey" class="form-control">
                                                <option value="">Select Survey</option>
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
                                            <input type="number" class="form-control" name="notification_number" placeholder="Number of Notification">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Interval</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="interval" class="form-control">
                                                @foreach(Utility::RECUR_INTERVAL as $key => $value)
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
                                            <input type="time" class="form-control " name="notify_time" placeholder="Time of notification">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitDefault('createModal','createMainForm','<?php echo url('create_ug_series'); ?>','reload_data',
                            '<?php echo url('appraisal_goal_set'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_ug_series'); ?>','reload_data',
                            '<?php echo url('appraisal_goal_set'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-info waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Goal Set/Cycle
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('appraisal_goal_set'); ?>',
                                    '<?php echo url('delete_ug_series'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>

                    </ul>
                </div>
                <div class="body table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Unit Goal Set</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->goal_name}}</td>
                            <td>{{$data->start_date}}</td>
                            <td>{{$data->end_date}}</td>
                            <td>
                                @if($data->created_by != '0')
                                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                @endif
                            </td>
                            <td>
                                @if($data->updated_by != '0')
                                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                @endif
                            </td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_ug_series_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

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