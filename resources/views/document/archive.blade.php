@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Archived Document(s)
                    </h2>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="search_document" class="form-control"
                                            onkeyup="searchItemParam('search_document','reload_data','<?php echo url('search_document_file') ?>','{{url('document_archive')}}','<?php echo csrf_token(); ?>','type_id')"
                                            name="search_user" placeholder="Search Files" >
                                    </div>
                                    <input type="hidden" id="type_id" value="0" name="type"/>
                                </div>
                            <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->
                        </div>
                        <div class="col-md-6">
                            <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="search_document1" class="form-control"
                                                onkeyup="searchItemParam('search_document1','reload_data','<?php echo url('search_document') ?>','{{url('document_archive')}}','<?php echo csrf_token(); ?>','type_id2')"
                                                name="search_user" placeholder="Search Folders" >
                                        </div>
                                        <input type="hidden" id="type_id2" value="0" name="type"/>
                                    </div>
                                <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->
                        </div>
                    </div>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-default" onclick="location.reload()"><i class="fa fa-refresh "></i> Refresh</button>
                        </li>
                        <li>
                            <button type="button" onclick="restoreDeletedItems('kid_checkbox','reload_data','<?php echo url('document_archive'); ?>',
                                    '<?php echo url('restore_document_archive'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-success">
                                <i class="fa fa-check"></i>Restore
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('document_archive'); ?>',
                                    '<?php echo url('delete_document_archive'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete from archive
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

                <div class="row">
                    <div class="col-md-6">
                        <!-- BEGIN OF SEARCH WITH DATE INTERVALS -->
                        <form name="search_file_form" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                            <div class=" body">

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="from_date" placeholder="From e.g 2019-02-22">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="to_date" placeholder="To e.g 2019-04-21">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="1" name="param"/>

                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="" style="">
                                        <div class="form-group">
                                            <button class="btn btn-info col-sm-12" type="button" onclick="searchUsingDate('searchMainForm','<?php echo url('search_document_file_using_date'); ?>','reload_data',
                                                    '<?php echo url('document_archive'); ?>','<?php echo csrf_token(); ?>','start_date','end_date')" id="search_files_button">Search File(s)</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                        <!-- END OF SEARCH WITH DATE INTERVALS -->
                    </div>
                    <div class="col-md-6">
                        <!-- BEGIN OF SEARCH WITH DATE INTERVALS -->
                            <form name="searchFolderForm" id="searchFolderForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                <div class=" body">

                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select  class="form-control" multiple name="document_category[]" >
                                                        <option value="0" selected>All Document Category </option>
                                                        @foreach($docCategory as $ap)
                                                            <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control datepicker" autocomplete="off" id="start_date1" name="from_date" placeholder="From e.g 2019-02-22">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control datepicker" autocomplete="off" id="end_date1" name="to_date" placeholder="To e.g 2019-04-21">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="1" name="param"/>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12" id="" style="">
                                            <div class="form-group">
                                                <button class="btn btn-info col-sm-12" type="button" onclick="searchUsingDate('searchFolderForm','<?php echo url('search_document_using_date'); ?>','reload_data',
                                                        '<?php echo url('document_archive'); ?>','<?php echo csrf_token(); ?>','start_date1','end_date1')" id="search_hse_button">Search Folder(s)</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        <!-- END OF SEARCH WITH DATE INTERVALS -->
                    </div>
                </div>
                <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->


                <div class="body table-responsive tbl_scroll" id="reload_data">
                    @include('document.data', ['mainData' => $mainData])

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