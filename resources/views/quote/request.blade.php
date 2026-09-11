@extends('layouts.app')

@section('content')

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')

     <!-- Default Size Attachment-->
     <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
                </div>
                <div class="modal-body" id="attach_content">


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
                        Quotes Approval
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        @if($appAccess === 1)
                        <li>
                            <button type="button" onclick="RequestApproval('kid_checkbox','reload_data','<?php echo url('my_quote_requests'); ?>',
                                    '<?php echo url('approve_quote'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Approve
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="RequestApproval('kid_checkbox','reload_data','<?php echo url('my_quote_requests'); ?>',
                                    '<?php echo url('approve_quote'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
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
                <div class="body table-responsive" id="reload_data">
                <table class="table table-bordered table-hover table-striped" id="main_table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                    name="check_all" class="" />

                            </th>
                            <th>Attachment</th>
                            <th>Customer Preview</th>
                            <th>Default Preview</th>
                            <th>Quote Number</th>
                            <th>Assigned User</th>
                            <th>Due date</th>
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
                                        <td>
                                            <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_quote_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                        </td>
                                        <td>
                                            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('quote_print_preview') ?>','<?php echo csrf_token(); ?>','vendor')"><i class="fa fa-pencil-square-o"></i>Customer Preview</a>
                                        </td>
                                        <td>
                                            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('quote_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Preview</a>
                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    
                                        <td>{{$data->quote_number}}</td>
                                        <td>{{$data->assigned->firstname}} {{$data->assigned->lastname}}</td>
                                        <td>{{$data->due_date}}</td>
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
                                            @if($data->approved_users != '')
                                                <table class="table table-bordered table-responsive">
                                                    <thead>
                                                    <th>Name</th>
                                                    <th>Reason</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($data->approved_by as $users)
                                                        <tr>
                                                            <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                                                            <td>Approved</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        @if($data->deny_reason != '')
                                                            <td>{{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}</td>
                                                            <td>Denied: {{$data->deny_reason}}</td>
                                                        @endif
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        </td>
                                        <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
                                        <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
                                        <td>{{$data->created_at}} </td>
                                        <td>{{$data->updated_at}}</td>
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <input type="hidden" id="vendorDisplay" value="{{$data->vendor}}">

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