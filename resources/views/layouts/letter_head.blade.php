
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>ERP|External Page</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Sweet Alert Css -->
    <link rel="stylesheet" href="{{ asset('sweetalert/dist/sweetalert.css') }}">
    
    <script type="text/javascript">
        var csrfToken = $('[name="csrf_token"]').attr('content');

        //setInterval(refreshToken, 3600000); // 1 hour

        function refreshToken(){
            var refreshCsrf = "{{url('refresh-csrf')}}";
            $.get(refreshCsrf).done(function(data){
                csrfToken = data; // the new token
            });
        }

        setInterval(refreshToken, 3600000); // 1 hour

        function checkUserAuth(){
            var checkAuthUrl = "{{url('check_user_auth')}}";
            $.get(checkAuthUrl).done(function(data){
                if(data == 0){
                    swal("Session Expired!", "Your login session has expired!", "warning");
                    window.location.href = "{{url('/logout')}}";
                }
            });
        }
        setInterval(checkUserAuth, 30000); // 1 second

    </script>

</head>

<body class="container">
<div class="body table-responsive" id="print_preview_data">
    <table class="table table-bordered table-hover table-striped" id="payslip_table">
        <thead>
        </thead>
        <tbody>
        <tr>
            <?php $companyInfo = \App\Helpers\Utility::companyInfo(); ?>
            @if(!empty($companyInfo))
                <td>
                    <table class="  ">
                        <tbody>
                        <tr>
                            <td>{{$companyInfo->name}}</td>
                        </tr>
                        <tr>
                            <td>{{$companyInfo->address}}</td>
                        </tr>
                        <tr>
                            <td>{{$companyInfo->phone1}}&nbsp; {{$companyInfo->phone2}}</td>
                        </tr>
                        <tr>
                            <td>{{$companyInfo->email}}</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <?php $imgUrl = \App\Helpers\Utility::IMG_URL(); ?>
                <td><img class="pull-right" src="{{ asset('images/'.$companyInfo->logo)}}"> </td>
            @else
                <td>
                    <table>
                        <tbody>
                        <tr>
                            <td>Company Name</td>
                        </tr>
                        <tr>
                            <td>Company Address</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                        </tr>
                        </tbody>
                    </table>
                </td>

                <td><img class="pull-right" src="{{ asset('images/'.\App\Helpers\Utility::DEFAULT_LOGO) }}"></td>
            @endif
        </tr>
        </tbody>
    </table>

    <section class="">
        <div class="container-fluid">
            <div class="">
                @yield('content')
            </div>
        </div>
    </section>

</div>
<!-- Jquery Core Js -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap Core Js -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
<!-- Sweet Alert -->
<script src="{{ asset('sweetalert/dist/sweetalert.js') }}"></script>
<!-- Waves Effect Plugin Js -->
<script src="{{ asset('plugins/node-waves/waves.js') }}"></script>
<!-- App Custom Helpers -->
<script src="{{ asset('js/app-helpers.js') }}"></script>
</body>

</html>