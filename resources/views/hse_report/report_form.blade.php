
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HSE Report Form</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('images/'.Utility::companyInfo()->logo) }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}">

    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Sweet Alert Css -->
    <link rel="stylesheet" href="{{ asset('sweetalert/dist/sweetalert.css') }}">

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />
    
    <!-- Jquery Core Js -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('templateEditor/ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript">
        var csrfToken = $('[name="csrf_token"]').attr('content');

        //setInterval(refreshToken, 3600000); // 1 hour

        function refreshToken(){
            $.get('refresh-csrf').done(function(data){
                csrfToken = data; // the new token
            });
        }

        setInterval(refreshToken, 3600000); // 1 hour

    </script>

</head>

<body class="container large-signup-page">
<div class="large-signup-box">
    <div class="logo">
        <a href="javascript:void(0);"><b>{{\App\Helpers\Utility::companyInfo()->name}}</b></a>
        <small>{{\App\Helpers\Utility::companyInfo()->address}}</small>
    </div>
    <div class="card">
        <div class="body">
          
            <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
            <div class="msg">Quality, Health and Safety Environment Form</div>
                <div class="body">
                    
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="location" placeholder="Location">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" class="form-control" name="occurrence_date" placeholder="Date of occurrence">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="time" class="form-control" name="occurrence_time" placeholder="Occurrence Time">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h5>Description</h5>
                                <div class="form-line">
                                    <textarea type="text" id="details" class="form-control " name="details" placeholder="Details"></textarea>
                                    <script>
                                        CKEDITOR.replace('details');
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group">
                            <h5>Actions Taken</h5>
                                <div class="form-line">
                                    <textarea type="text" class="form-control " name="actions_taken" placeholder="Enter Actions Taken"></textarea>                                           
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>

                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="reported_by" placeholder="Reported By">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>

                    <div class="row">
                        <h5>Section 2: To be completed by Quality, Healthy, Safety and Environment Department</h5>
                    </div>

                    <div class="row clearfix">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <select  class="form-control" disabled name="report_type" >
                                        <option value="">Report Type</option>
                                        @foreach(\App\Helpers\Utility::HSE_REPORT_TYPE as $key => $var)
                                            <option value="{{$key}}">{{$var}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <select  class="form-control" disabled name="source_type" >
                                        <option value="">Source Type</option>
                                        @foreach($sourceType as $ap)
                                            <option value="{{$ap->id}}">{{$ap->source_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr/>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" disabled class="form-control " name="causes" placeholder="Causes">Causes</textarea>                                           
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" disabled class="form-control " name="remedial_action" placeholder="Proposed Remedial Action">Remedial Action</textarea>                                           
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>

                    <div class="row">
                        <h5>Reviewed By</h5>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control"disabled name="reviewed_by" placeholder="Reviewed By">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control datepicker" disabled name="review_date" placeholder="Review Date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <h5>Approved By</h5>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" disabled name="approved_by" placeholder="Approved By">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control datepicker" disabled name="approve_date" placeholder="Approve Date">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <button id="create_button" onclick="createForm('createMainForm','<?php echo url('create_hse_report'); ?>','<?php echo csrf_token(); ?>')" class="btn btn-block btn-lg bg-pink waves-effect" type="button">Submit Report</button>
            </form>
        </div>
    </div>
</div>

<script>
    function createForm(formId,submitUrl,token){
        var createButton = _('create_button');
        createButton.disabled = true;
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var ckInput = CKEDITOR.instances['details'].getData();
        var postVars = new FormData(form);
        postVars.append('token',token);
        postVars.append('details',ckInput);
       //DISPLAY LOADING ICON
        overlayBody('block');
        sendRequestMediaForm(submitUrl,token,postVars);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //HIDE LOADING ICON
                overlayBody('none');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");
                    createButton.disabled = false;
                   
                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Your Information has been saved in our system, Thank you!", "success");
                    createButton.disabled = false;

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                    createButton.disabled = false;
                }
                
                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

            }
        }

    }
</script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Select Plugin Js -->
<script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('plugins/node-waves/waves.js') }}"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{ asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('sweetalert/dist/sweetalert.js') }}"></script>

<!-- Validation Plugin Js -->
<script src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('js/admin.js') }}"></script>
<script src="{{ asset('js/pages/examples/sign-up.js') }}"></script>

<!-- App Custom Helpers -->
<script src="{{ asset('js/app-helpers.js') }}"></script>
<script>

    $(function() {
        $( ".datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
    });
</script>
</body>

</html>