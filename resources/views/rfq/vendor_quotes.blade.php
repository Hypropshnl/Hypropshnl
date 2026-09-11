
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>RFQ's | Open</title>
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

</head>

<body class="theme-red">
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
                        <span>OPEN RFQ'S</span>
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
            <h2>OPEN RFQ'S</h2>
        </div>
        @foreach($mainData as $data)
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header" style="cursor:pointer;" onclick="navigatePage('<?php echo url('rfq_vendor_quotes/'.$data->id)?>')">
                        <h2>
                           {{$data->rfq_no}}
                            <small>Posted {{$data->updated_at->diffForHumans()}}</small>
                        </h2>
                    </div>
                    <div class="body">
                        @foreach($data->rfqDetail as $val)
                            @if($loop->first)
                                <h5>{{$val->rfq_desc}}.....</h5>
                            @endif
                        @endforeach
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>

<!-- Jquery Core Js -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('plugins/node-waves/waves.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('js/admin.js') }}"></script>

</body>

<script>

    function navigatePage(pageUrl){
        window.location.replace(pageUrl);
    }
</script>

</html>