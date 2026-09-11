@extends('layouts.app')

@section('content')


    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Vehicle Spare Part</h4>
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
                                                <input type="text" class="form-control" autocomplete="off" id="select_vehicle" onkeyup="searchOptionList('select_vehicle','myUL1','{{url('default_select')}}','search_vehicle','vehicle');" name="select_vehicle" placeholder="Select Vehicle">

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
                                                <select class="form-control" name="vehicle"  required>
                                                    <option value="">Select Vehicle</option>
                                                    @foreach(\App\Helpers\Utility::driverVehicles() as $data)
                                                        <option value="{{$data->id}}">{{$data->make->make_name}} {{$data->model->model_name}} ({{$data->license_plate}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                @endif

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <b>Name*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="" name="name" placeholder="Part Name" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <b>Part Number</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="" name="part_no" placeholder="Part Number" >
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-8">
                                    <b>Location</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="location" placeholder="Location" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Quantity*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" id="" name="quantity" placeholder="Quantity" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_vehicle_spare_parts'); ?>','reload_data',
                            '<?php echo url('vehicle_spare_parts'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
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
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_vehicle_spare_parts_attachment'); ?>','reload_data',
                            '<?php echo url('vehicle_spare_parts'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="overflow-y:scroll; height:400px;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_vehicle_spare_parts'); ?>','reload_data',
                            '<?php echo url('vehicle_spare_parts'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
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
                        Vehicle Spare Part(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('vehicle_spare_parts'); ?>',
                                    '<?php echo url('delete_vehicle_spare_parts'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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

                <div class="row container">
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_vehicle_spare_parts" class="form-control"
                                       onkeyup="searchItem('search_vehicle_spare_parts','reload_data','<?php echo url('search_vehicle_spare_parts') ?>','{{url('vehicle_spare_parts')}}','<?php echo csrf_token(); ?>')"
                                       name="search_vehicle_spare_parts" placeholder="Search Vehicle Spare Parts" >
                            </div>
                        </div>
                    </div>
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
                            <th>Vehicle</th>
                            <th>Part Name</th>
                            <th>Part No</th>
                            <th>Quantity</th>
                            <th>Location</th>
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
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vehicle_spare_parts_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->vehicle_make}} {{$data->vehicle_model}} ({{$data->vehicleDetail->license_plate}})</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->part_no}}</td>
                            <td>{{$data->quantity}}</td>
                            <td>{{$data->location}}</td>

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