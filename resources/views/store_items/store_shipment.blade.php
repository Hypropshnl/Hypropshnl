@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Receive Store Item(s)</h4>
                </div>
                <div class="modal-body" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('store_shipment_create'); ?>','reload_data',
                            '<?php echo url('store_shipment'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <form name="shipmentForm" id="shipmentform"></form>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Store Shipment Management
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button type="button"  onclick="fetchHtmlWithItemsOpenModal('editModal','edit_content','<?php echo url('store_shipment_form'); ?>','kid_checkbox')" class="btn btn-success">
                                <i class="fa fa-check"></i>Ship Store Items
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-print"></i>Print</a></li>
                                <li><a class="btn bg-red waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                                <li><a class="btn btn-warning" onClick ="$('#main_table').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                                <li><a class="btn  bg-light-green waves-effect" onClick ="$('#main_table').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                                <li><a class="btn btn-info" onClick ="$('#main_table').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>
                <div class=" body">
                    <form name="searchMainForm" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="store" >
                                                <option value="" selected>Store</option>
                                                @foreach($store as $de)
                                                <option value="{{$de->id}}">{{$de->name}} ({{$de->name}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_inv2" onkeyup="searchOptionList('select_inv2','myUL501','{{url('default_select')}}','search_inventory','inv501');" name="select_user" placeholder="Inventory Item">

                                            <input type="hidden" class="" value="" name="inventory" id="inv501" />
                                        </div>
                                    </div>
                                    <ul id="myUL501" class="myUL"></ul>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_po" onkeyup="searchOptionList('select_po','myUL100','{{url('default_select')}}','search_po_select','convertPo');" name="select_po" placeholder="Select PO">
        
                                            <input type="hidden" class="user_class" name="purchase_order" id="convertPo" />
                                        </div>
                                    </div>
                                    <ul id="myUL100" class="myUL"></ul>
                                </div>

                                <div class="col-sm-3" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info col-sm-8" type="button" onclick="searchReport('searchMainForm','<?php echo url('store_shipment_search'); ?>','reload_data',
                                                '<?php echo url('store_items'); ?>','<?php echo csrf_token(); ?>')">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>


                </div>
                <div class="body table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Store</th>
                            <th>Inventory Item</th>
                            <th>Sales Number</th>
                            <th>Quantity Shipped</th>
                            <th>Updated Inventory Quantity</th>
                            <th>Status</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            <th>Updated by</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                @if(in_array(Auth::user()->id, Utility::TOP_USERS) || Auth::user()->id == $data->storeDetail->user_id)
                                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />
                                @else
                                    Not Manager
                                @endif

                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->storeDetail->name}}({{$data->storeDetail->code}})</td>
                            <td>{{$data->inventory->item_name}}({{$data->inventory->code}})</td>
                            <td>{{$data->salesItem->sales_number}}</td>
                            <td>{{$data->qty}}</td>
                            <td>
                                 @if (!empty($data->qty_remain) || $data->qty_remain != 0)
                                <a href="#" class="badge bg-green">{{$data->qty_remain}}</a>
                                @else
                                
                                <a href="#" class="badge bg-blue">{{$data->inventory->qty}}</a>
                                @endif
                            </td>
                            <td>
                                @if (!empty($data->qty_remain) || $data->qty_remain != 0)
                                <a href="#" class="badge bg-green">Placed</a>
                                @else
                                
                                <a href="#" class="badge bg-red">Not Placed</a>
                                @endif
                            </td>
                            <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
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