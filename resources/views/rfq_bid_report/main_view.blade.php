@extends('layouts.app')

@section('content')


    <!-- RESPONSE MODAL -->
     @include('includes/general_response_form',[$submitUrl = 'rfq_bid_report_response', $reloadUrl = 'rfq_bid_report_requests', $itemClass = 'kid_checkbox'])

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        RFQ Bid Analysis Approval
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        @if($appAccess === 1)
                        <li>
                            <button type="button" onclick="RequestApproval('kid_checkbox','reload_data','<?php echo url('rfq_bid_report_requests'); ?>',
                                    '<?php echo url('approve_rfq_bid_report'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Approve
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-info" data-toggle="modal" data-target="#generalResponseModal"><i class="fa fa-solid fa-reply"></i>Respond</button>
                        </li>
                        <li>
                            <button type="button" onclick="RequestApproval('kid_checkbox','reload_data','<?php echo url('rfq_bid_report_requests'); ?>',
                                    '<?php echo url('approve_rfq_bid_report'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Deny
                            </button>
                        </li>
                        @endif
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
                <div class="body table-responsive " id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Review Analysis</th>
                            <th>RFQ No.</th>
                            <th>Total Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Response Message(s)</th>
                            <th>Approval Status</th>
                            <th>Approved by</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                            @if($data->complete_status == 0)
                                @if($data->approval_view == 1 && $data->deny_reason == '')
                                    @if($data->next_user == Auth::user()->id)
                                    <tr>
                                        <td scope="row">
                                            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>
                                            <a class="btn btn-info" href="{{url('rfq_bid_report_analysis/'.$data->rfq_id)}}">Review</a>
                                        </td>
                                        <td>{{$data->rfqDetail->rfq_no}}</td>
                                        <td>{{Utility::numberFormat($data->total_amount)}}</td>
                                        <td>
                                            @include('includes/general_response_view')
                                        </td>
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
                                        <td>
                                            @include('includes/approved_by')
                                        </td>
                                        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->updated_at}}</td>
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                                    </tr>
                                    @endif
                            @endif
                          @endif
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

    <!-- #END# Bordered Table -->

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