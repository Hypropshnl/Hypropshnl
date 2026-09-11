@extends('layouts.app')

@section('content')

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        RFQ Bids/Quotes
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

                <div class="body">
                <div class="row clearfix">
                
                    <div class="body table-responsive" id="reload_data">
                        <table class="table">
                            <thead>
                            <th></th><th></th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>RFQ Quote Submission Link</td>
                                <td class="btn-link"><a href="{{url('rfq_vendor_quotes')}}" target="_blank">{{url('rfq_vendor_quotes')}}</a></td>
                            </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover table-striped" id="main_table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                            name="check_all" class="" />

                                    </th>
                                    <th>View Quotes/Bids</th>
                                    <th>Viewers</th>
                                    <th>Bid Analysis</th>
                                    <th>Default Preview</th>
                                    <th>RFQ Number</th>
                                    <th>Assigned User</th>
                                    <th>Approval Status</th>
                                    <th>Analysis Status</th>
                                    <th>Due date</th>
                                    <th>Due date Time</th>
                                    <th>Created by</th>
                                    <th>Updated by</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mainData as $data)
                                @php
                                    $dueDate = (!empty($data->due_date_time)) ? $data->due_date_time : $data->due_date;
                                    $deadline = (!empty($data->due_date_time)) ? now() : Date('Y-m-d');
                                @endphp
                                    <tr>
                                        <td scope="row">
                                            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />
                                        </td>
                                        <td>
                                            @if($dueDate < $deadline)
                                            <a class="btn btn-info" href="{{url('rfq_vendor_bids/'.$data->id)}}">View</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($dueDate < $deadline)
                                            <a class="btn btn-info" href="{{url('rfq_vendor_bid_viewers/'.$data->id)}}">View</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($dueDate < $deadline && empty($data->rfqReport->id) && ($data->assigned_user == Auth::user()->id || $data->created_by == Auth::user()->id))
                                            <a class="btn btn-info" href="{{url('rfq_bid_report_analysis/'.$data->id)}}">Analysis</a>
                                            @endif
                                            @if($dueDate < $deadline && !empty($data->rfqReport->id))
                                            <a class="btn btn-info" href="{{url('rfq_bid_report_analysis/'.$data->id)}}">Analysis</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('rfq_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Preview</a>
                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    
                                        <td>{{$data->rfq_no}}</td>
                                        <td>{{$data->assigned->firstname}} {{$data->assigned->lastname}}</td>
                                        <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
                                            @if($data->approval_status === 1)
                                                Request Approved
                                            @endif
                                            @if($data->approval_status === 0)
                                                Processing Request
                                            @endif
                                            @if($data->approval_status === 2)
                                                Request Denied
                                            @endif
                                        </td>
                                        <td class="{{\App\Helpers\Utility::statusIndicator($data->rfqReport->approval_status)}}">
                                            @if($data->rfqReport->approval_status === 1)
                                                Request Approved
                                            @endif
                                            @if($data->rfqReport->approval_status === 0 || empty($data->rfqReport->approval_status))
                                                Processing Request
                                            @endif
                                            @if($data->rfqReport->approval_status === 2)
                                                Request Denied
                                            @endif
                                        </td>
                                        <td>{{$data->due_date}}</td>
                                        <td>{{$data->due_date_time}}</td>
                                        <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
                                        <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
                                        <td>{{$data->created_at}} </td>
                                        <td>{{$data->updated_at}}</td>
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <input type="hidden" id="vendorDisplay" value="{{$data->vendor}}">

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

    <!-- #END# Bordered Table -->

    <script>
     

    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getData(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
        location.hash = page;
    });

    function getData(page){
        var searchVal = $('#search_rfq').val();
        var pageData = '';
        if(searchVal == ''){
            pageData = '?page=' + page;
        }else{
            pageData = '<?php echo url('search_rfq') ?>?page=' + page+'&searchVar='+searchVal;
        }

        $.ajax({
            url: pageData
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