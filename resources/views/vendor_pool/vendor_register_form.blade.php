
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vendor Registration</title>
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

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

    <!-- Multiselect Css -->
    <link rel="stylesheet" href="{{ asset('multiselect/dist/css/bootstrap-multiselect.css') }}">
    
    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Sweet Alert Css -->
    <link rel="stylesheet" href="{{ asset('sweetalert/dist/sweetalert.css') }}">

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

<style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
    }

    .dropdown-container {
      width: 300px;
      position: relative;
    }

    .dropdown-toggle-custom {
      border: 1px solid #ccc;
      padding: 10px 12px;
      background: #fff;
      cursor: pointer;
      border-radius: 6px;
      user-select: none;
    }

    .dropdown-menu-custom {
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      max-height: 300px;
      border: 1px solid #ccc;
      background: white;
      border-radius: 6px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      overflow-y: auto;
      display: none;
      z-index: 9999;
    }

    .accordion-item {
      border-top: 1px solid #eee;
    }

    .accordion-header {
      background: #f7f7f7;
      padding: 10px 12px;
      cursor: pointer;
    }

    .accordion-content {
      display: none;
      margin: 0;
      padding: 0;
    }

    .accordion-content.open-sub {
      display: block;
    }

    .sublist-item {
      list-style: none;
      padding: 10px 12px;
      display: flex;
      align-items: center;
      cursor: pointer;
      gap: 8px;
      border-top: 1px solid #f0f0f0;
    }

    .sublist-item:hover {
      background-color: #f0f8ff;
    }

    .sublist-item input[type="checkbox"] {
      pointer-events: none;
    }
  </style>

</head>

<body class="container large-signup-page">

<!-- LOADING MODAL -->
    <div class="modal fade" id="loading_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel"></h4>
                </div>
                <div class="modal-body" id="loading_icon">
                    PROCESSING, PLEASE WAIT......
                <img src="{{asset('icons/loading_icon.gif')}}" />
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

<div class="large-signup-box">
    <div class="card">
        <div class="body">
          
            <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
            <div class="image">
                <b>HNL-QMS-F-047</b>
            </div>
            <div class="mx-auto">
                <div class=" mt-5 text-center">
                    <img class="text-center" src="{{ asset('images/'.Utility::companyInfo()->logo) }}" width="200" height="120" alt="User" />
                </div><br>
                
            </div>
            <div class="msg"><b>VENDOR REGISTRATION FORM</b></div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <b>Company Name</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="company_name" placeholder="Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Currency</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" name="currency" placeholder="currency" required>
                                        <option value="">Select Currency</option>
                                        @foreach($currency as $curr)
                                        <option value="{{$curr->id}}">{{$curr->code}} ({{$curr->symbol}}) ({{$curr->currency}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <b>Memorandum of Association (Max 2mb)</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" class="form-control" name="memo" >
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <b>Address</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="address" placeholder="Address" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Country</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" name="country" placeholder="country" required>
                                        <option value="">Select Country</option>
                                        @foreach($country as $curr)
                                        <option value="{{$curr->id}}">{{$curr->countryName}} ({{$curr->countryCode}}) ({{$curr->continentName}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>City</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="city" placeholder="City" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <b>Company/RC. No.</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="company_no" placeholder="company_no" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Website</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="website" placeholder="website" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Email</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="email" placeholder="Email" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <b>Fax</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="fax" placeholder="Fax" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Phone</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Bank Reference</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="reference" placeholder="Bank Reference Detail" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <b>Bank Reference Document(Max 2mb)</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" class="form-control" name="reference_doc" >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <b>Contact Name</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="contact_name" placeholder="Contact Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Contact Email</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="contact_email" placeholder="Contact Email" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Contact Designation</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="contact_designation" placeholder="Contact Designation" required>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <b>VAT Registration No</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="vat_registration_no" placeholder="VAT Registration No" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Tax Identification No</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="tax_no" placeholder="Tax Identification No" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Bank Branch</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="bank_branch" placeholder="Bank Branch" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <b>Bank Name</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="bank_name" placeholder="bank_name">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Account Name</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control " name="account_name" placeholder="account name" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Account No</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="account_no" placeholder="Account No" >
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <b>Services/Product Category (Multiple Select)</b><span style="color:red">*</span>
                            <div class="dropdown-container">
                                <div class="dropdown-toggle-custom">Select job categories</div>
                                <div class="dropdown-menu-custom">
                                    @foreach($inventoryCategory as $data)
                                        <div class="accordion-item">
                                            <div class="accordion-header">{{$data->category_name}}</div>
                                            <ul class="accordion-content">
                                                @foreach($data->subcategoryMany as $sub)
                                                    <li class="sublist-item">
                                                        <input type="checkbox" name="job_category[]" value="{{$sub->id}}" />
                                                        {{$sub->name}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                            
                    </div>

                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <b>Other Services/Product Category (Please Specify)</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control" name="other_services" placeholder="Other Services/Product Category  (Please Specify)" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <b>Company Profile(Max 5mb)</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" class="form-control" name="company_profile" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="col-sm-4">
                            <b>Bank Sort Code</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="bank_sort_code" placeholder="Bank Sort Code" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <b>Annual Turnover</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="annual_turnover" placeholder="Annual Turnover" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <b>Do you have a written Health, Safety and Environment policy?</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" name="hse_cert" placeholder="HSE Certificate" required>
                                        <option value="Yes" selected>Yes</option>
                                        <option value="No" >No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <b>Is your company certified to any of the ISO Standards?</b><span style="color:red">*</span>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" name="iso_cert" placeholder="ISO Certificate" required>
                                        <option value="Yes" selected>Yes</option>
                                        <option value="No" >No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <b>HSE Policy Document(Max 2mb)</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" class="form-control" name="hse_policy_doc" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <b>ISO Document(Max 2mb)</b>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" class="form-control" name="iso_doc" >
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <button id="create_button" onclick="createForm('createMainForm','<?php echo url('vendor_pool_create'); ?>','<?php echo csrf_token(); ?>')" class="btn btn-block btn-lg bg-pink waves-effect" type="button">Submit Profile</button>
            </form>
        </div>
    </div>
</div>

<script>
    function createForm(formId,submitUrl,token){
       
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var postVars = new FormData(form);
        postVars.append('token',token);
       //DISPLAY LOADING ICON
        $('#loading_modal').modal('show');
        sendRequestMediaForm(submitUrl,token,postVars);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //HIDE LOADING ICON
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Your Information has been saved in our system, Thank you!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
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

<!-- Sweet Alert -->
<script src="{{ asset('sweetalert/dist/sweetalert.js') }}"></script>


<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<script src="{{ asset('multiselect/dist/js/bootstrap-multiselect.js') }}"></script>

<!-- Validation Plugin Js -->
<script src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('js/admin.js') }}"></script>
<script src="{{ asset('js/pages/examples/sign-up.js') }}"></script>

<!-- App Custom Helpers -->
<script src="{{ asset('js/app-helpers.js') }}"></script>

<script>
  function updateSelectedCount() {
    const selected = $("input[name='job_category[]']:checked").length;
    $(".dropdown-toggle-custom").text(
      selected > 0 ? `${selected} selected` : "Select job categories"
    );
  }

  $(document).ready(function () {
    const $dropdown = $(".dropdown-menu-custom");

    // Toggle dropdown like a select
    $(".dropdown-toggle-custom").on("click", function (e) {
      e.stopPropagation();
      $dropdown.slideToggle(150);
    });

    // Close on outside click
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".dropdown-container").length) {
        $dropdown.slideUp(150);
      }
    });

    // Accordion toggle
    $(".accordion-header").on("click", function () {
      $(this).next(".accordion-content").slideToggle(150).toggleClass("open-sub");
    });

    // Select sublist by clicking full item
    $(".sublist-item").on("click", function (e) {
      if (e.target.tagName !== "INPUT") {
        const $checkbox = $(this).find("input[type='checkbox']");
        $checkbox.prop("checked", !$checkbox.prop("checked"));
      }
      updateSelectedCount();
    });

   
    updateSelectedCount();
  });
</script>

</body>

</html>