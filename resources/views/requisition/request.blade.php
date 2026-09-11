@extends('layouts.app')

@section('content')

     <!-- Default Size Attachment-->
     <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
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

    <!-- RESPONSE MODAL -->
     @include('includes/general_response_form',[$submitUrl = 'requisition_response', $reloadUrl = 'my_requests', $itemClass = 'kid_checkbox'])

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Requisition Approval
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        @if($appAccess === 1 || $projectAppAccess === 1)
                        <li>
                            <button type="button" onclick="RequestApproval('kid_checkbox','reload_data','<?php echo url('my_requests'); ?>',
                                    '<?php echo url('approve_requisition'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Approve
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-info" data-toggle="modal" data-target="#generalResponseModal"><i class="fa fa-solid fa-reply"></i>Respond</button>
                        </li>
                        <li>
                            <button type="button" onclick="RequestApproval('kid_checkbox','reload_data','<?php echo url('my_requests'); ?>',
                                    '<?php echo url('approve_requisition'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Deny
                            </button>
                        </li>
                        @endif
                        <li>
                            <!--<button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('requisition'); ?>',
                                    '<?php echo url('delete_requisition'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>-->
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
                <div class="body table-responsive tbl_scroll" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Attachment</th>
                            <th>Purchase Order</th>
                            <th>Description</th>
                            <th>Edited</th>
                            <th>Response Message(s)</th>
                            <th>Request Category</th>
                            <th>Request Type</th>
                            <th>Project Category</th>
                            <th>Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Foreign Amount</th>
                            <th>Transaction Type</th>
                            <th>Material Request</th>
                            <th>Requested by</th>
                            <th>Department</th>
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
                            @php
                            $transType = (!empty($data->transaction_type)) ? $transactionTypes[$data->transaction_type] : 'Local';
                            $foreignCurr = (Utility::currencyArrayItem('id') == $data->curr_id) ? '' : '('.$data->currencyDetail->code.')'.$data->currencyDetail->symbol;
                            @endphp
                            @if($data->complete_status == 0)
                                @if($data->approval_view == 1 && $data->deny_reason == '')
                                    @if($data->next_user == Auth::user()->id)
                                    <tr>
                                        <td scope="row">
                                            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                        </td>
                                        <!--<td>
                                            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_requisition_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                        </td>-->
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>
                                            <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                        </td>
                                        <td>
                                            @if(!empty($data->po_id))
                                            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->po_id}}','print_preview','printPreviewModal','<?php echo url('po_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Preview</a>|
                                            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('po_print_preview') ?>','<?php echo csrf_token(); ?>','vendor')"><i class="fa fa-pencil-square-o"></i>Vendor Preview
                                            @endif
                                        </td>
                                        <td>{{$data->req_desc}}</td>
                                        <td>
                                            @if($data->edit_request != '')
                                                <?php $edited = json_decode($data->edit_request,true); ?>
                                                @foreach($edited as $key => $val)
                                                    {{$key}} : {{$val}}<br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @include('includes/general_response_view')
                                        </td>
                                        <td>{{$data->requestCat->request_name}}</td>
                                        <td>{{$data->requestType->request_type}}</td>
                                        <td>
                                            @if($data->proj_id != 0)
                                                {{$data->project->project_name}}
                                            @endif
                                        </td>
                                        <td>{{Utility::numberFormat($data->amount)}}</td>
                                        <td>{{$foreignCurr}}{{Utility::numberFormat($data->foreign_amount)}}</td>
                                        <td>
                                            {{$transType}}
                                        </td>
                                        <td>{{$data->mrData->mr_number}}</td>
                                        <td>{{$data->requestUser->firstname}} &nbsp; {{$data->requestUser->lastname}}</td>
                                        <td>{{$data->department->dept_id}}</td>
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
                                        <td>
                                            @if($data->created_by != '0')
                                                {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($data->updated_by != '0')
                                                {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                            @endif
                                        </td>
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