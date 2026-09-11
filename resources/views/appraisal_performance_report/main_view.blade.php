@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Performance Appraisal Report
                    </h2>
                    <ul class="header-dropdown m-r--5">
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
                    <div class="col-md-12">
                        
                        <div class="row">
                            <form name="import_excel" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                      
                                <div class="col-sm-4" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" id="department" name="goal_set" data-selected-text-format="count">
                                                <option value="">Select Goal Set/Cycle</option>
                                                @foreach($mainData as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReport('searchMainForm','<?php echo url('search_appraisal_performance_report'); ?>','reload_data_search',
                                                '','<?php echo csrf_token(); ?>')">Search Report</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class=" table-responsive" id="reload_data_search" >

                            
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