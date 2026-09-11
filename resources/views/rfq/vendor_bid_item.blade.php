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
                        <li>
                            <a class="btn btn-info" href="{{url('rfq_vendor_bids')}}">Previous Page</a>
                        </li>
                        <li>
                            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$mainData->id}}','print_preview','printPreviewModal','<?php echo url('rfq_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Preview RFQ</a>
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
                <div class="row clearfix">
                
                    <div class="body table-responsive" id="reload_data">

                        <table class="table table-bordered table-hover table-striped" id="main_table">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                        name="check_all" class="" />

                                </th>

                                <th>RFQ ID</th>
                                <th>Preview</th>
                                <th>Download Quote</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>RFQ Due Date</th>
                                <th>Quote Type</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bids as $data)
                            <tr>
                                <td scope="row">
                                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$mainData->rfq_no}}</td>
                                <td>
                                    @if(!empty($rfqBidReport))
                                        @if(!empty($data->attachment) && Utility::isValidJson($data->attachment))
                                            @php $docs = json_decode($data->attachment); $num = 500; @endphp
                                            @foreach($docs as $file)
                                                @php $num++; @endphp
                                                <button id="file_{{$data->id}}_{{$num}}" class="btn btn-outline-primary btn-view"
                                                        data-file-url="{{ asset('files/'.$file) }}" onclick="previewFile('<?php echo 'file_'.$data->id.'_'.$num; ?>');">
                                                    <i class="fa fa-eye me-2"></i>View File
                                                </button>
                                            @endforeach
                                        @elseif(!empty($data->attachment) && !Utility::isValidJson($data->attachment))
                                            <button id="file_{{$data->id}}" class="btn btn-outline-primary btn-view"
                                                data-file-url="{{ asset('files/'.$data->attachment) }}" onclick="previewFile('<?php echo 'file_'.$data->id; ?>');">
                                            <i class="fa fa-eye me-2"></i>View File
                                            </button>
                                        @else
                                        No Attachment
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($rfqBidReport))
                                        @if(!empty($data->attachment) && Utility::isValidJson($data->attachment))
                                            @php $docs = json_decode($data->attachment); $num = 500; @endphp
                                            @foreach($docs as $file)
                                                <a target="_blank" href="<?php echo URL::to('download_rfq_bid_attachment?file='); ?>{{$file}}">
                                                    <i class="fa fa-files-o fa-2x"></i>Download
                                                </a>
                                            @endforeach
                                        @elseif(!empty($data->attachment) && !Utility::isValidJson($data->attachment))
                                            <a target="_blank" href="<?php echo URL::to('download_rfq_bid_attachment?file='); ?>{{$data->attachment}}">
                                                <i class="fa fa-files-o fa-2x"></i>Download
                                            </a>
                                        @else
                                        No Attachment
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if(empty($data->vendor_id))
                                    {{$data->name}}
                                    @else
                                    {{$data->vendorCon->name}}
                                    @endif
                                </td>
                                <td>{{$data->email}}</td>
                                <td>{{$data->due_date}}</td>
                                <td>
                                    @if($data->submit_status == Utility::STATUS_ACTIVE)
                                    <a href="#" class="badge bg-green">Vendor Submission</a>
                                    @else
                                    
                                    <a href="#" class="badge bg-cyan">User Generated</a>
                                    @endif
                                </td>
                                <td>{{$data->created_at}}</td>

                                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

@endsection
