
    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="">
                <div class="table-responsive " id="">
                    <table id="table-bordered" class="table table-bordered table-hover">
                        <thead>
                            <tr id="">
                                @foreach ($rfqBid as $data)
                                    <th>
                                        {{$data->name}}({{$data->currencyData->code}}({{$data->currencyData->symbol}}))
                                                            
                                    </th>
                                @endforeach

                                <!-- CUSTOM QUOTES NOT SUBMITTED BY VENDORS -->
                                @foreach ($customQuotes as $data)
                                <form onsubmit="false;" class="form form-horizontal form_custom_{{$data->id}}" method="post" enctype="multipart/form-data">
                                    <th>
                                        {{$data->name}}({{$data->currencyData->code}}({{$data->currencyData->symbol}}))
                                    </th>
                                </form>
                                @endforeach
                                <!-- END OF CUSTOM QUOTES NOT SUBMITTED BY VENDORS -->
                            </tr>
                        </thead>
                        <tbody id="">
                            
                            <tr id="">
                                @foreach ($rfqBid as $data)
                                    <td>
                                        <table class="">
                                            <thead>
                                                <th>Vendor Quote</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td>Grand Total</td>
                                                        <td>
                                                            {{$data->total_amount}}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Delivery Date</td>
                                                        <td>
                                                            {{$data->delivery_date}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Attacment </td>
                                                        <td>
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
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vendor</td>
                                                        <td>User</td>
                                                    </tr>
                                                    @foreach ($data->commentMany as $com)
                                                        
                                                        <tr id="show_comment_{{$data->id}}" >
                                                            @if (!empty($com->user_id))
                                                            <td></td>
                                                            <td>
                                                                Comment : {{$com->comment}}<br>
                                                                Name : {{$com->userData->firstname}}<br>
                                                                Created At : {{$com->created_at}}
                                                            </td>
                                                            @else
                                                            <td>
                                                                Name : {{$com->rfqBidData->name}}<br>
                                                                Comment : {{$com->comment}}<br>
                                                                Created At : {{$com->created_at}}<br>
                                                                @if(!empty($com->attachment) && Utility::isValidJson($com->attachment))
                                                                    @php $docs = json_decode($com->attachment); $num = 500; @endphp
                                                                    @foreach($docs as $file)
                                                                    @php $num++; @endphp
                                                                        <button id="com_{{$com->id}}_{{$num}}" class="btn btn-outline-primary btn-view"
                                                                                data-file-url="{{ asset('files/'.$file) }}" onclick="previewFile('<?php echo 'com_'.$com->id.'_'.$num; ?>');">
                                                                            <i class="fa fa-eye me-2"></i>View File
                                                                        </button>|
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td>
                                                            <b> Message(@ Quote Submission):</b> <br>
                                                            {{$data->custom_message}}<br>
                                                            Created At : {{$data->created_at}}
                                                        </td>
                                                        <td></td>
                                                    </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                @endforeach

                                    <!-- CUSTOM QUOTES NOT SUBMITTED BY VENDORS -->
                                @foreach ($customQuotes as $data)
                                    <td>
                                        <table>
                                            <thead>
                                                <th>Custom Quote</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td>Grand Total</td>
                                                        <td>
                                                            {{$data->total_amount}}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Delivery Date</td>
                                                        <td>
                                                            {{$data->delivery_date}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Attachment </td>
                                                        <td>
                                                            @if(!empty($data->attachment))
                                                            <button id="file_{{$data->id}}" class="btn btn-outline-primary btn-view"
                                                                    data-file-url="{{ asset('files/'.$data->attachment) }}" onclick="previewFile('<?php echo 'file_'.$data->id; ?>');">
                                                                <i class="fa fa-eye me-2"></i>View File
                                                            </button>
                                                            @else
                                                            No Attachment
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Contact Vendor Mails
                                                        </td>
                                                        <td>
                                                            @php $vendorMails = json_decode($data->vendor_mails); @endphp
                                                                    @if (!empty($vendorMails))
                                                                        @foreach($vendorMails as $mail)
                                                                            {{$mail}},
                                                                        @endforeach
                                                                    @endif
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>Vendor</td>
                                                        <td>User</td>
                                                    </tr>
                                                    @foreach ($data->commentMany as $com)
                                                        
                                                    <tr id="show_comment_{{$data->id}}" >
                                                        @if (!empty($com->user_id))
                                                        <td></td>
                                                        <td>
                                                            Comment : {{$com->comment}}<br>
                                                            Name : {{$com->userData->firstname}}<br>
                                                            Created At : {{$com->created_at}}
                                                        </td>
                                                        @else
                                                        <td>
                                                            Comment : {{$com->comment}}<br>
                                                            Name : {{$com->name}}<br>
                                                            Created At : {{$com->created_at}}<br>
                                                            @if(!empty($com->attachment) && Utility::isValidJson($com->attachment))
                                                                @php $docs = json_decode($com->attachment); $num = 500; @endphp
                                                                @foreach($docs as $file)
                                                                @php $num++; @endphp
                                                                    <button id="com_{{$com->id}}_{{$num}}" class="btn btn-outline-primary btn-view"
                                                                            data-file-url="{{ asset('files/'.$file) }}" onclick="previewFile('<?php echo 'com_'.$com->id.'_'.$num; ?>');">
                                                                        <i class="fa fa-eye me-2"></i>View File
                                                                    </button>|
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td></td>
                                                        @endif
                                                    </tr>
                                                    @endforeach

                                            </tbody>
                                        </table>
                                    </td>
                                @endforeach
                                    <!-- END OF CUSTOM QUOTES NOT SUBMITTED BY VENDORS -->
                            </tr>
                                                                    
                        </tbody>
                    </table>
                 
                </div>
                <!-- #END OF TABLE BODY -->
            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->
