
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RFQ List | </title>
    <!-- Favicon-->
    <link rel="icon"  href="{{ asset('images/'.Utility::companyInfo()->logo) }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}">
    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet">

    <!-- Sweet Alert Css -->
    <link rel="stylesheet" href="{{ asset('sweetalert/dist/sweetalert.css') }}">

    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Jquery Core Js -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

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

<body class="theme-red">
    
     <!-- LOADING MODAL -->
             <div class="modal fade" id="loading_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel"></h4>
                        </div>
                        <div class="modal-body" id="loading_icon">
                         LOADING......
                        <img src="{{asset('icons/loading_icon.gif')}}" />
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
    
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="{{url('OByxRFDeOtxHYxnTTfJmSukkJZ7aCY/positions/2y101HS5A2C30Nex/available')}}">{{\App\Helpers\Utility::companyInfo()->name}}</a>
        </div>
    </div>
</nav>
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user_info">
            <div class="image">
                <img src="{{ asset('images/'.\App\Helpers\Utility::companyInfo()->logo) }}" width="300" height="200" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><h6>{{\App\Helpers\Utility::companyInfo()->address}}</h6></div>
                <div class="email"><h6>{{\App\Helpers\Utility::companyInfo()->email}}</h6></div>
                <div class="email"><h6>{{\App\Helpers\Utility::companyInfo()->phone1}},{{\App\Helpers\Utility::companyInfo()->phone2}}</h6></div>
            </div>

        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li>
                    <a href="#">
                        <i class="material-icons">home</i>
                        <span>RFQ</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Changelogs -->
        <div class="block-header">
            <h2></h2>
        </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header" style="cursor:pointer;" >
                            <h2>
                                {{$mainData->rfq_no}}
                                <small>Posted {{$mainData->created_at->diffForHumans()}}</small>
                            </h2>
                        </div>
                        <div class="body">
                            
                            <table class="table-bordered table-hover table-striped">
                                <thead></thead>
                                <tbody>
                                    @php $rfqNumber = (empty($mainData->rfq_no) ? $mainData->id : $mainData->rfq_no) @endphp
                                <tr>
                                    <td>RFQ Number: {{$rfqNumber}}</td>
                                    <td>Project : {{$mainData->project->project_name}}</td>
                                </tr>

                                </tbody>
                            </table><hr/>

                            <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="email" class="form-control" name="email" required placeholder="Enter the email where this RFQ was received">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="">
                                                    <input type="file" multiple class="form-control" name="attachment" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="">
                                                    <input type="hidden" class="form-control" name="rfq_id" value="{{$mainData->id}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="">
                                                    <input type="hidden" class="form-control" name="rfq_bid_id" value="{{$rfqBid->id}}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div><hr>
                               
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            
                                            <div class="form-line">
                                                <textarea rows="10" cols="50" class="form-control" name="comment" autocomplete="off" required placeholder="Enter Message Response"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div><hr>
                                @if($mainData->rfq_status == Utility::STATUS_ACTIVE)
                                <div class="row">
                                    <div class="col-md-12">
                                        <button onclick="submitResponse('createMainForm','<?php echo url('rfq_bid_vendor_response'); ?>','',
                                            '','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info col-sm-12 waves-effect">
                                        Submit Response
                                    </button>
                                    </div>
                                    
                                </div>
                                
                                @endif
                            </form>

                        </div>
                    </div>
                </div>

                
            </div>




    </div>
</section>

<!-- Bootstrap Core Js -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('plugins/node-waves/waves.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('js/admin.js') }}"></script>

<!-- App Custom Helpers -->
<script src="{{ asset('js/app-helpers.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('sweetalert/dist/sweetalert.js') }}"></script>

</body>

<script>

    function submitResponse(formId,submitUrl,reload_id,reloadUrl,token){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var postVars = new FormData(form);
        postVars.append('token',token);
        $('#loading_modal').modal('show');

        sendRequestMediaForm(submitUrl,token,postVars);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Thank you for your response, we will get back to you');
                    swal("Success!", successMessage, "success");

                }else if(message2 == 'token_mismatch'){

                    //location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                //reloadContent(reload_id,reloadUrl);
            }
        }

    }

</script>

</html>