
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
                    <a href="{{url('rfq_vendor_quotes')}}">
                        <i class="material-icons">home</i>
                        <span>Available RFQ'S</span>
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
                        <div class="header" style="cursor:pointer;" onclick="navigatePage('<?php echo url('rfq_vendor_quotes/'.$id); ?>')">
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
                                <tr>
                                    <td>Due Date: {{$dueDate}}</td>
                                    @if($dueDate >= $deadline)
                                    <td class="{{Utility::statusIndicator($mainData->rfq_status)}}">
                                        Status: {{Utility::defaultReverseStatus($mainData->rfq_status)}}
                                    </td>
                                    @else
                                        <td class="btn-danger">
                                        Status: Closed
                                        </td>
                                    @endif
                                </tr>

                                </tbody>
                            </table><hr/>

                            <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="name" required placeholder="Enter Name of Organization">
                                                </div>
                                            </div>
                                        </div>

                                    
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="email" class="form-control" name="email" required placeholder="Enter the email where this RFQ was received">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="">
                                                    <input type="hidden" class="form-control" name="due_date_time" value="{{$mainData->due_date_time}}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="">
                                                    <input type="hidden" class="form-control" name="rfq_id" value="{{$mainData->id}}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <b>Expected Delivery Date</b>
                                                <div class="">
                                                    <input type="date" class="form-control" name="delivery_date" required placeholder="Enter expected delivery date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <b>Currency</b>
                                                <div class="form-line">
                                                    <select  class="form-control"  id="" name="currency" >
                                                        <option value="">Select </option>
                                                        @foreach($currency as $ap)
                                                            <option value="{{$ap->id}}">{{$ap->code}}({{$ap->currency}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div><hr>
                                <div class="row">
                                    <div class="col-sm-12">{!!$mainData->message!!}</div>
                                </div><hr>

                                <div class="container body table-responsive">
                                    <table class="table-responsive table-bordered table-hover ">
                                        <thead>
                                        <td>Item</td>
                                        <td>Description</td>
                                        <td>Quantity</td>
                                        <td>Unit Measure</td>
                                        <td>Unit Price</td>
                                        <td>Amount</td>
                                        </thead>
                                        <tbody>
                                        @foreach($rfqItems as $data)
                                            @php $bomItem = (!empty($data->bomData)) ? 'Click to view Bill of Materials' : '' ; @endphp
                                            @if($data->item_id != '')
                                                <tr onclick="idDisplayClass('bom_{{$data->id}}');">
                                                    <td>
                                                        {{$data->inventory->item_name}} ({{$data->inventory->item_no}})
                                                        <h6>{{$bomItem}}</h6>
                                                    </td>
                                                    <td>{{$data->rfq_desc}}</td>
                                                    <td>{{$data->quantity}}</td>
                                                    <td>{{$data->unit_measurement}}</td>
                                                    <td>
                                                        <input type="hidden" name="item[]" value="{{$data->inventory->id}}" >
                                                        <input type="hidden" name="item_desc[]" value="{{$data->rfq_desc}}" >
                                                        
                                                        <input type="number" class="form-control" name="unit_price[]" id="price_{{$data->id}}"
                                                            onchange="simpleSumCalc('price_{{$data->id}}', 'qty_{{$data->id}}', 'amount_{{$data->id}}', 'sub_total', 'amount_sum','discount','discount_perct','tax','tax_perct','grand_total')"
                                                            onkeyup="simpleSumCalc('price_{{$data->id}}', 'qty_{{$data->id}}', 'amount_{{$data->id}}', 'sub_total', 'amount_sum', 'discount','discount_perct','tax','tax_perct','grand_total')"
                                                            autocomplete="off" required placeholder="Unit Price">
                                                            
                                                        <input type="hidden" name="qty[]" value="{{$data->quantity}}" id="qty_{{$data->id}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control amount_sum" name="amount[]" id="amount_{{$data->id}}" readonly autocomplete="off" required placeholder="Amount">
                                                    </td>
                                                </tr>
                                                @include('includes.display_bom_items',['bomData' => $data->bomData, 'data' => $data])
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td></td><td></td><td></td>
                                            <td>Sub Total:</td>
                                            <td></td>
                                            <td>
                                                <input type="text" class="form-control" id="sub_total" name="sub_total" readonly required placeholder="Sub Total">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td><td></td><td></td>
                                            <td>Discount(%):</td>
                                            <td>
                                                <input type="number" class="form-control" id="discount_perct" name="discount_perct"
                                                onkeyup="simpleSumCalcGenPercentage('sub_total','discount','discount_perct','tax','tax_perct','grand_total')"
                                                onchange="simpleSumCalcGenPercentage('sub_total','discount','discount_perct','tax','tax_perct','grand_total')"
                                                required placeholder="Percentage Discount">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="discount" name="discount" readonly required placeholder="Discount Amount">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td><td></td><td></td>
                                            <td>VAT(%):</td>
                                            <td>
                                                <input type="number" class="" id="tax_perct" name="tax_perct"
                                                onkeyup="simpleSumCalcGenPercentage('sub_total','discount','discount_perct','tax','tax_perct','grand_total')"
                                                onchange="simpleSumCalcGenPercentage('sub_total','discount','discount_perct','tax','tax_perct','grand_total')"
                                                required placeholder="Percentage Tax">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="tax" name="tax" readonly required placeholder="Tax Amount">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td><td></td><td></td>
                                            <td>Grand Total:</td>
                                            <td></td>
                                            <td>
                                                <input type="number" class="" id="grand_total" name="grand_total" readonly required placeholder="Grand Total">
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table><hr/>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <b>Attach Alternative Quote(Optional)</b>
                                                <div class="form-line">
                                                    <input type="file" class="form-control" multiple name="quote_attachment[]" placeholder="Quote Attachment">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <b>Enter Message(optional)</b>
                                                <div class="form-line">
                                                    <textarea class="form-control" name="message" autocomplete="off" required placeholder="e.g payment terms, any other information"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div><hr>
                                    @if($dueDate >= $deadline && $mainData->rfq_status == Utility::STATUS_ACTIVE)
                                    <div class="row">
                                        <button onclick="applyJob('createModal','createMainForm','<?php echo url('rfq_vendor_quote_create'); ?>','reload_data',
                                                '','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info col-sm-12 waves-effect">
                                            Submit
                                        </button>
                                    </div>
                                    
                                    @endif
                                </div><hr>
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

    function applyJob(formModal,formId,submitUrl,reload_id,reloadUrl,token){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var postVars = new FormData(form);
        postVars.append('token',token);
        $('#loading_modal').modal('show');
        $('#'+formModal).modal('hide');

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

                    var successMessage = swalSuccess('Your application was successful, we will get back to you');
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

    function navigatePage(pageUrl){
        window.location.replace(pageUrl);
    }
</script>

</html>