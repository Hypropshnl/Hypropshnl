@extends('layouts.app')

@section('content')


    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Work Order</h4>
                </div>
                <div class="modal-body" style="overflow-y:scroll; height:400px;">

                    <form name="vehicleForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
                                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || \App\Helpers\Utility::moduleAccessCheck('vehicle_fleet_access'))
                                    <div class="col-sm-4">
                                        <b>Vehicle*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" autocomplete="off" id="select_vehicle" onkeyup="searchOptionListParamCheck('select_vehicle','myUL1','{{url('default_select')}}','search_vehicle_param_repair','vehicle','','fault_desc_id','select_vehicle_repair','{{url('default_select')}}');" name="select_vehicle" placeholder="Select Vehicle">

                                                <input type="hidden" class="vehicle_class" name="vehicle" id="vehicle" />
                                            </div>
                                        </div>
                                        <ul id="myUL1" class="myUL"></ul>
                                    </div>
                                @else

                                    <div class="col-sm-4">
                                        <b>Vehicle*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" name="vehicle" id="vehicle" required onchange="fillNextInput('vehicle','fault_desc_id','<?php echo url('default_select'); ?>','select_vehicle_repair')" >
                                                    <option value="">Select Vehicle</option>
                                                    @foreach(\App\Helpers\Utility::driverVehicles() as $data)
                                                        <option value="{{$data->id}}">{{$data->make->make_name}} {{$data->model->model_name}} ({{$data->license_plate}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                @endif

                                <div class="col-md-4">
                                    <b>Repair Requests/Fault Description</b>
                                    <div class="form-group">
                                        <div class="form-line fault_desc" id="fault_desc_id" >
                                            <select  class="form-control" name="fault_description"  >
                                                <option value="">Vehicle Fault Description</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Total Bill {{\App\Helpers\Utility::defaultCurrency()}}</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" name="total_bill" placeholder="Total Bill" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <b>Add/Remove Spare Parts by selection</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_item1" onkeyup="searchOptionListMultipleDetail('select_item1','myUL501','{{url('default_select')}}','search_multiple_vehicle_spare_parts_detail','inv501','spare_parts_desc','spare_parts_array_id','vehicle_spare_parts');" name="select_spare_parts" placeholder="Select Spare parts">

                                            <input type="hidden" class="inv_class" value="" name="spare_part" id="inv501" />
                                        </div>
                                    </div>
                                    <ul id="myUL501" class="myUL"></ul>
                                </div>
                                <div class="col-sm-6">
                                    <b>Spares Required</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" readonly id="spare_parts_desc" name="spares_required" placeholder="Vehicle Spare Parts" required></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" id="spare_parts_array_id" name="spare_parts_array">
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Service Type/Repair Solution*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="service_type"  required>
                                                <option value="">Select Service Type</option>
                                                @foreach($serviceType as $data)
                                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <b>Action Taken So Far</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="action_taken" placeholder="Action Taken So Far" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <b>Next Action</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="next_action" placeholder="Next Action" required></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Service/Repair Start Date</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="service_date" placeholder="Service Date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Estimated Complete Date</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" class="form-control" id="" name="estimated_complete_date" placeholder="Estimated Completion Date" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Actual Complete Date</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" class="form-control" id="" name="actual_complete_date" placeholder="Actual Completion Date" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Invoice Reference*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="invoice_reference" placeholder="Invoice Reference" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Mileage In</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" id="" name="mileage_in" placeholder="Mileage In" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Mileage Out</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" id="" name="mileage_out" placeholder="Mileage Out">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Location</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="location" id="" placeholder="Location" required>
                                        </div>
                                    </div>
                                </div>
                               <div class="col-sm-4">
                                    <b>Diagnosis Date</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" class="form-control" id="" name="diagnosis_date" placeholder="Diagnosis Date" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Attachment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" multiple="multiple" class="form-control" name="attachment[]" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Workshop*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="workshop"  required>
                                                @foreach($workshop as $data)
                                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <b>Comment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="comment" placeholder="Comment" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_vehicle_service_log'); ?>','reload_data',
                            '<?php echo url('vehicle_service_log'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size Attachment-->
    <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
                </div>
                <div class="modal-body" id="attach_content" style="overflow-y:scroll; height:400px;">


                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_vehicle_service_log_attachment'); ?>','reload_data',
                            '<?php echo url('vehicle_service_log'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit modal Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="overflow-y:scroll; height:400px;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_vehicle_service_log'); ?>','reload_data',
                            '<?php echo url('vehicle_service_log'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editMiniModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                    <li class="dropdown pull-right">
                        
                        @include('includes/print_pdf',[$exportId = 'editMainForm', $exportDocId = 'editMainForm'])
                    </li>

                </div>
                <div class="modal-body" id="edit_mini_content" style="height:400px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editMiniModal','editMiniMainForm','<?php echo url('edit_vehicle_service_log_mini'); ?>','reload_data',
                            '<?php echo url('vehicle_service_log'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-info waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
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
                        Vehicle Work Order
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('vehicle_service_log'); ?>',
                                    '<?php echo url('delete_vehicle_service_log'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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

                <div class="body table-responsive tbl_scroll" id="reload_data">
                <table class="table table-bordered table-hover table-striped" id="main_table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                    name="check_all" class="" />

                            </th>

                            <th>Manage</th>
                            <th>Micro Update</th>
                            <th>Attachment</th>
                            <th>Vehicle</th>
                            <th>Service Type</th>
                            <th>Total Bill {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Driver</th>
                            <th>Workshop</th>
                            <th>Mileage In({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
                            <th>Mileage Out({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
                            <th>Location</th>
                            <th>Service Date</th>
                            <th>Comment</th>
                            <th>Invoice Reference</th>
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
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vehicle_service_log_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="fetchHtml2('{{$data->id}}','edit_mini_content','editMiniModal','<?php echo url('edit_vehicle_service_log_mini_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_vehicle_service_log_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->vehicle_make}} {{$data->vehicle_model}} ({{$data->vehicleDetail->license_plate}})</td>
                            <td>{{$data->service->name}}</td>
                            <td>{{Utility::numberFormat($data->total_price)}}</td>
                            <td>{{$data->driver->firstname}} &nbsp; {{$data->driver->lastname}}</td>
                            <td>{{$data->workshopDetail->name}}</td>
                            <td>{{Utility::numberFormat($data->mileage_in)}}</td>
                            <td>{{Utility::numberFormat($data->mileage_out)}}</td>
                            <td>{{$data->location}}</td>
                            <td>{{$data->service_date}}</td>
                            <td>{{$data->comment}}</td>
                            <td>{{$data->invoice_reference}}</td>

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