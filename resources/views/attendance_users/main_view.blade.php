@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Assign Users</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="schedule" >
                                                <option value="" selected>Select Schedule</option>
                                                @foreach($schedule as $de)
                                                <option value="{{$de->id}}">{{$de->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="submitDefaultWithItems('createModal','createMainForm','<?php echo url('create_assign_time_schedule'); ?>','reload_data',
                            '<?php echo url('assign_time_schedule'); ?>','<?php echo csrf_token(); ?>','kid_checkbox')" class="btn btn-info">
                        <i class="fa fa-check-square-o"></i>Assign
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Re-Assign Users</h4>
                </div>
                <div class="modal-body">

                    <form name="editMainForm" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="schedule" >
                                                <option value="" selected>Select Schedule</option>
                                                @foreach($schedule as $de)
                                                <option value="{{$de->id}}">{{$de->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="submitDefaultWithItems('editModal','editMainForm','<?php echo url('create_assign_time_schedule'); ?>','reload_data',
                            '<?php echo url('assign_time_schedule'); ?>','<?php echo csrf_token(); ?>','kid_checkbox_assigned')" class="btn btn-info">
                        <i class="fa fa-check-square-o"></i>Assign
                    </button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
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
                        Assign Time Schedule To User(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Assign Users</button>
                        </li>
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#editModal"><i class="fa fa-plus"></i>Re-Assign Users</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox_assigned','reload_data','<?php echo url('assign_time_schedule'); ?>',
                                    '<?php echo url('delete_assign_time_schedule'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                <div class="body row">
                    <div class="col-md-6">
                        <div class="card header">
                            <h2>Assign Time Schedule</h2>
                        </div>
                        <div class="row">
                            <form name="import_excel" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                      
                                <div class="col-sm-4" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" multiple id="department" name="department[]" data-selected-text-format="count">
                                                <option value="">Department(Multiple)</option>
                                                @foreach($dept as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="user" id="user" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReport('searchMainForm','<?php echo url('search_assign_time_schedule'); ?>','reload_data_search',
                                                '','<?php echo csrf_token(); ?>')">Search Users</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class=" table-responsive" id="reload_data_search" >

                            
                            </div>
                        </div>
                        

                    </div>

                    <div class="col-md-6">
                        <div class="card header">
                            <h2>Assigned User(s)</h2>
                        </div>
                        <div class="row">
                            <form name="searchAssignForm" id="searchAssignForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                      
                                <div class="col-sm-4" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" multiple id="department" name="department[]" data-selected-text-format="count">
                                                <option value="">Department(Multiple)</option>
                                                @foreach($dept as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user0" onkeyup="searchOptionList('select_user0','myUL0','{{url('default_select')}}','default_search','user0');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="user" id="user0" />
                                        </div>
                                    </div>
                                    <ul id="myUL0" class="myUL"></ul>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReport('searchAssignForm','<?php echo url('search_user_assign_time_schedule'); ?>','reload_data',
                                                '','<?php echo csrf_token(); ?>')">Search Users</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class=" table-responsive" id="reload_data" >

                                <table class="table table-bordered table-hover table-striped" id="main_table">

                                    <thead>

                                    <tr>

                                        <th>

                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_assigned');" id="parent_check_assigned"

                                                name="check_all" class="" />



                                        </th>
                                        <th>Name</th>
                                        <th>Time Schedule</th>
                                        <th>Department</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Created by</th>
                                        <th>Updated by</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                    @foreach($mainData as $data)

                                    <tr>

                                        <td scope="row">

                                            <input value="{{$data->user_id}}" type="checkbox" id="{{$data->id}}_assigned" class="kid_checkbox_assigned" />

                                        </td>

                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

                                        <td>

                                            <a href="{{route('profile', ['uid' => $data->userData->uid])}}">

                                                <span class="">{{$data->userData->title}}&nbsp;{{$data->userData->firstname}}&nbsp;{{$data->userData->othername}}&nbsp;{{$data->userData->lastname}}</span>

                                            </a>

                                        </td>
                                        <td>{{$data->schedule->name}}</td>
                                        <td>
                                            {{$data->department->dept_name}}
                                        </td>
                                        <td>{{$data->userData->email}}</td>

                                        <td>{{$data->userData->sex}}</td>
                                        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->updated_at}}</td>
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

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
                

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function saveApprovalSys(formModal,formId,submitUrl,reload_id,reloadUrl,token,user,stage) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var user = classToArray(user);
        var stage = classToArray(stage);

        var juser = JSON.stringify(user);
        var jstage = JSON.stringify(stage);
        //alert(juser);

        if(arrayItemEmpty(user) == false && arrayItemEmpty(stage) == false) {
            if(double(stage) == false && double(stage) == false){
            var postVars = inputVars + '&editor_input=' + summerNote + '&user=' + juser + '&stage=' + jstage;
           
            $('#' + formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');

            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    //HIDE LOADING ICON
					overlayBody('none');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                         //RESET FORM
                        //resetForm(formId);
                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");

                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id, reloadUrl);
                }
            }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else {
                swal("Warning!","Please, a user/stage cannot be selected more than once","warning");
        }
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

</script>

<script>
    var li_class = document.getElementsByClassName("myUL");
    $(window).click(function() {
        for (var i = 0; i < li_class.length; i++){
            li_class[i].style.display = 'none';
        }

    });
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