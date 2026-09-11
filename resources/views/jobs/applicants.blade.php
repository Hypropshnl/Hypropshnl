@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="letterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Cover Letter</h4>
                </div>
                <div class="modal-body" id="letter_content">

                </div>
                <div class="modal-footer">

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
                        Filter Job Applicants
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button type="button" onclick="deleteSearchItems('kid_checkbox','reload_data','',
                                    '<?php echo url('delete_applicants'); ?>','<?php echo csrf_token(); ?>','search_applicants');" class="btn btn-danger">
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

                <div class="container body">
                    <form name="import_excel" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="from_date" placeholder="From e.g 2019-02-22">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="to_date" placeholder="To e.g 2019-04-21">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_job" onkeyup="searchOptionList('select_job','myUL1','{{url('default_select')}}','default_search_job','job_item');" name="select_job" placeholder="Search Job">

                                            <input type="hidden" class="user_class" name="job" id="job_item" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick"   name="category" data-selected-text-format="count">
                                                <option value="">Select Job Category (not compulsory)</option>
                                                @foreach($jobCategory as $de)
                                                    <option value="{{$de->id}}">{{$de->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" multiple name="experience" >
                                                <option selected value="">Select Experience (Multiple)</option>
                                                @for($i=0;$i<=30;$i++)
                                                    <option value="{{$i}}">{{$i}} yr(s)</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="min_match_score" >
                                                <option selected value="0">Min Match Score</option>
                                                @for($i=0;$i<=100;$i+=10)
                                                    <option value="{{$i}}">{{$i}}%</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick"  name="max_match_score" >
                                                <option selected value="100">Max Match Score</option>
                                                @for($i=0;$i<=100;$i+=10)
                                                    <option value="{{$i}}">{{$i}}%</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clear-fix">

                                <div class="col-sm-12" id="" style="">
                                    <div class="form-group">
                                        <button id="search_applicants" class="form-control btn btn-info col-sm-8" type="button" onclick="searchUsingDate('searchMainForm','<?php echo url('search_job_applicants'); ?>','reload_data',
                                                '<?php echo url('applicants') ?>','<?php echo csrf_token(); ?>','start_date','end_date')">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>


                </div>

                <div class="body table-responsive tbl_scroll" id="reload_data">

                </div>


            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function deleteSearchItems(klass,reloadId,reloadUrl,submitUrl,token,searchButtonId) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                        title: "Are you sure you want to delete?",
                        text: "You will not be able to recover this data entry!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel delete!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            deleteSearchEntry(klass, reloadId, reloadUrl, submitUrl, token,searchButtonId);

                            //swal("Deleted!", "Your item(s) has been deleted.", "success");

                            //butId.trigger('click');
                        } else {
                            swal("Delete Cancelled", "Your data is safe :)", "error");
                        }
                    });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function deleteSearchEntry(klass,reloadId,reloadUrl,submitUrl,token,searchButtonId){
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data;
        //$('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){
                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");
                    var butId = $('#'+searchButtonId);

                    butId.trigger('click');

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                if(reloadUrl != '') {
                    reloadContent(reloadId, reloadUrl);
                }
            }
        }


    }

    function viewLetter(modalId,divId,letterId){
        $('#'+modalId).modal('show');
        var coverLetter = $('#'+letterId).attr('data-val');
        $('#'+divId).html(coverLetter);
    }


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