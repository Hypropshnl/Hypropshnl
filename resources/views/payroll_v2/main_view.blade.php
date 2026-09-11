@extends('layouts.app')

@section('content')

   
    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Details</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="edit_content">

                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Payroll V2
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox_payroll','reload_data','<?php echo url('payroll_v2'); ?>',
                                    '<?php echo url('delete_payroll_v2'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
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
                    @if(in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT))
                    <div class="row">
                        <form name="import_excel" id="payForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input class="form-control datepicker" name="date" placeholder="Date" >
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="processPayroll('kid_checkbox_payroll','reload_data','<?php echo url('payroll_v2'); ?>',
                            '<?php echo url('approve_payroll_v2'); ?>','<?php echo csrf_token(); ?>','1','payForm');" class="btn btn-success">
                        <i class="fa fa-check-square-o"></i>Pay Salary
                        </button>
                        </form>
                    </div>
                    @endif
                    <hr/>

                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                    <b>Search Users For Payment</b>
                    <form name="searchOtherForm" id="searchOtherForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        
                        <div class="row clearfix">

                            <div class="col-sm-3" id="department" >
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control show-tick" id="" name="department" data-selected-text-format="count">
                                            <option value="">Select Department</option>
                                            @foreach($dept as $val)
                                                <option value="{{$val->id}}">{{$val->dept_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3" id="" style="">
                                <div class="form-group">
                                    <button class="btn btn-info col-sm-8" type="button" onclick="searchReport('searchOtherForm','<?php echo url('search_payroll_v2_user_strict'); ?>','reload_data',
                                            '','<?php echo csrf_token(); ?>')" id="">Search</button>
                                </div>
                            </div>

                        </div>
                    </form><hr>

                    <div class="row">
                        <div class="col-sm-12 pull-right">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="search_user" class="form-control"
                                        onkeyup="searchItem2('search_user','reload_data','<?php echo url('search_payroll_v2_user') ?>','{{url('payroll_v2')}}','<?php echo csrf_token(); ?>')"
                                        name="search_user" placeholder="Search users for payment" >
                                </div>
                            </div>
                        </div>
                    </div><hr>

                    
                @endif

                <form name="searchUsingDateForm" id="searchUsingDateForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                    <b>Search Processing/Paid Users</b>
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="from_date" placeholder="From Date">
                                </div>
                            </div>
                        </div>
    
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="to_date" placeholder="To Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3" id="department" >
                            <div class="form-group">
                                <div class="form-line">
                                    <select  class="form-control show-tick" id="" name="department" data-selected-text-format="count">
                                        <option value="">Select Department</option>
                                        @foreach($dept as $val)
                                            <option value="{{$val->id}}">{{$val->dept_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-sm-3" id="" style="">
                            <div class="form-group">
                                <button class="btn btn-info col-sm-8" type="button" onclick="searchUsingDate('searchUsingDateForm','<?php echo url('search_payroll_v2_lite'); ?>','reload_data',
                                        '','<?php echo csrf_token(); ?>','start_date','end_date')" id="">Search</button>
                            </div>
                        </div>
    
                    </div>
                </form>

            </div>
                
                <div class="body table-responsive tbl_scroll" id="reload_data">
                  
                    <table class="table table-bordered table-hover table-striped tbl_order" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox_payroll');" id="parent_check_payroll"
                                       name="check_all_payroll" class="" />
                    
                            </th>
                    
                            <th>User</th>
                            <th>Payroll Status</th>
                            <th>Salary</th>
                            <th>Total/Net Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Ext Hours/Days Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Ext Desc</th>
                            <th>Days Engaged</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Process Date</th>
                            <th>Pay Date</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                            @php $monthName = date("F", mktime(0, 0, 0, $data->month,10)); @endphp
                            <tr>
                                <td scope="row">
                                    <input value="{{$data->id}}" type="checkbox" id="payroll_{{$data->id}}" class="kid_checkbox_payroll" />
                    
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$data->userDetail->firstname}}&nbsp;{{$data->userDetail->lastname}} </td>
                                <td>
                                    @if($data->payroll_status == \App\Helpers\Utility::PROCESSING)
                                        Processing
                                    @else
                                        Paid
                                    @endif
                                </td>
                                <td>{{$data->salary->salary_name}}</td>
                                <td>{{Utility::numberFormat($data->total_amount)}}</td>
                                <td> {{Utility::numberFormat($data->bonus_deduc)}}</td>
                                <td>{{$data->bonus_deduc_desc}}</td>
                                <td>{{$data->days_hours_engage}}</td>
                                <td>{{$monthName}}</td>
                                <td>{{$data->pay_year}}</td>
                                <td>{{$data->process_date}}</td>
                                <td>{{$data->pay_date}}</td>
                                <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>{{$data->updated_at}}</td>
                                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                
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
            //location.hash = page;
        });

        function getData(page){

            var searchVal = $('#search_user').val();
            var pageData = '';
            if(searchVal == ''){
                pageData = '?page=' + page;
            }else{
                pageData = '<?php echo url('search_payroll_user') ?>?page=' + page+'&searchVar='+searchVal;
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