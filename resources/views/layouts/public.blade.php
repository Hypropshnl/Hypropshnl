<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <title>{{ Utility::companyInfo()->name }} ERP SOFTWARE</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('images/'.Utility::companyInfo()->logo) }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}">
    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Animation Css -->
    <link href="{{ asset('plugins/animate-css/animate.css') }}" rel="stylesheet">

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />


    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my_style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tabs.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('css/themes/all-themes.css') }}" rel="stylesheet">
    <!-- Sweet Alert Css -->
    <link rel="stylesheet" href="{{ asset('sweetalert/dist/sweetalert.css') }}">
    <!-- SummerNote Css -->
    <link rel="stylesheet" href="{{ asset('summernote/dist/summernote.css') }}">
    <!-- Multiselect Css -->
    <link rel="stylesheet" href="{{ asset('multiselect/dist/css/bootstrap-multiselect.css') }}">

    <!-- Full Event Calendar !-->
    <link rel="stylesheet" href="{{ asset('full_calendar/packages/core/main.css') }}">
    <link rel="stylesheet" href="{{ asset('full_calendar/packages/daygrid/main.css') }}">
    <link rel="stylesheet" href="{{ asset('full_calendar/packages/timegrid/main.css') }}">
    <link rel="stylesheet" href="{{ asset('full_calendar/packages/list/main.css') }}">

    <!-- Calculator Styling Sheets !-->
    <link rel="stylesheet" href="{{ asset('calculator/jsRapCalculator.css') }}">

    <!-- Light Gallery Plugin Css -->
    <link href="{{ asset('plugins/light-gallery/css/lightgallery.css') }}" rel="stylesheet">

     <!-- Nestable Plugin Css -->
     <link href="{{ asset('plugins/nestable/jquery-nestable.css') }}" rel="stylesheet">

    <!-- Jquery Core Js -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('templateEditor/ckeditor/ckeditor.js') }}"></script>

    

</head>

<body class="theme-red">
    @yield('content')

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
    <!-- Select Plugin Js -->
    <script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('plugins/node-waves/waves.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/pages/forms/form-validation.js') }}"></script>
    <script src="{{ asset('js/pages/forms/basic-form-elements.js') }}"></script>
    {{--<script src="{{ asset('js/pages/tables/jquery-datatable.js') }}"></script>--}}
    <!-- Autosize Plugin Js -->
    <script src="{{ asset('plugins/autosize/autosize.js') }}"></script>

    <!-- Moment Plugin Js -->
    <script src="{{ asset('plugins/momentjs/moment.js') }}"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('js/demo.js') }}"></script>

    <!-- High Chart Js -->
    <script src="{{ asset('js/high_chart.js') }}"></script>
    <script src="{{ asset('js/highchartTable.js') }}"></script>

    <!-- TAB JS -->
    <script src="{{ asset('js/tabs2.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('sweetalert/dist/sweetalert.js') }}"></script>

    <script src="{{ asset('summernote/dist/summernote.js') }}"></script>
    <script src="{{ asset('multiselect/dist/js/bootstrap-multiselect.js') }}"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('plugins/node-waves/waves.js') }}"></script>

    <!-- JQUERY NESTABLE Plugin Js -->
    <script src="{{ asset('plugins/nestable/jquery.nestable.js') }}"></script>

    <!-- App Custom Helpers -->
    <script src="{{ asset('js/app-helpers.js') }}"></script>
    <script src="{{ asset('js/pages/ui/sortable-nestable.js') }}"></script>

    <!-- FORM WIZARD -->
    <script src="{{ asset('js/pages/forms/form-wizard.js') }}"></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="{{ asset('/plugins/jquery-steps/jquery.steps.js') }}"></script>

    <!-- LIGHT IMAGE GALLERY Plugin Js -->
    <script src="{{ asset('/plugins/light-gallery/js/lightgallery-all.js') }}"></script>

    <!-- Full Event Calendar -->
    <script src="{{ asset('full_calendar/packages/core/main.js') }}"></script>
    <script src="{{ asset('full_calendar/packages/interaction/main.js') }}"></script>
    <script src="{{ asset('full_calendar/packages/daygrid/main.js') }}"></script>
    <script src="{{ asset('full_calendar/packages/timegrid/main.js') }}"></script>
    <script src="{{ asset('full_calendar/packages/list/main.js') }}"></script>

    <!-- Export to DOCS,PDF,EXCEL,MSWORD,CSV -->
    <script src="{{ asset('export/tableExport.js') }}"></script>
    <script src="{{ asset('export/jquery.base64.js') }}"></script>
    <script src="{{ asset('export/html2canvas.js') }}"></script>
    <script src="{{ asset('export/jspdf/libs/sprintf.js') }}"></script>
    <script src="{{ asset('export/jspdf/jspdf.js') }}"></script>
    <script src="{{ asset('export/jspdf/libs/base64.js') }}"></script>

    <!-- Calculator JS-->
    <script src="{{ asset('calculator/jsRapCalculator.js') }}"></script>

    <!-- EXPORT HTML TO WORD JS-->
    <script src="{{ asset('export-html-to-word/FileSaver.js') }}"></script>
    <script src="{{ asset('export-html-to-word/jquery.wordexport.js') }}"></script>

    <!-- App Custom Helpers -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>

        //getCurrency('{{url('get_currency')}}','{{csrf_token()}}');    //GET NEW CURRENCY RATES FROM CURRENCYLAYER API

        //exchangeRate('vendorCust','curr_rate','posting_date','<?php echo url('exchange_rate'); ?>')

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
