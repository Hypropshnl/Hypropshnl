

<!-- Bordered Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="">
            <div class="table-responsive" id="reload_data">
                                                        
                <div class="table table-bordered table-hover table-striped">
                    <table id="" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr id="">
                                @php $quoteType = ($rfqBid->submit_status == Utility::STATUS_ACTIVE) ? 'Vendor' : 'Custom'  @endphp
                                <th>
                                    {{$rfqBid->name}}({{$rfqBid->currencyData->code}}({{$rfqBid->currencyData->symbol}}))
                                </th>
                                <th>{{$quoteType}} Quote</th>

                            </tr>
                        </thead>
                        <tbody id="">
                            <tr>
                                <td>Grand Total</td>
                                <td>
                                    <input type="number" readonly class="form-control" value="{{$rfqBid->total_amount}}">

                                </td>
                            </tr>
                             <tr>
                                <td>Delivery Date</td>
                                <td>
                                    {{$rfqBid->delivery_date}}

                                </td>
                            </tr>
                            <tr>
                                <td>Attachment </td>
                                <td>
                                    @if(!empty($rfqBid->attachment) && Utility::isValidJson($rfqBid->attachment))
                                        @php $docs = json_decode($rfqBid->attachment); $num = 500; @endphp
                                        @foreach($docs as $file)
                                        @php $num++; @endphp
                                            <button id="file_{{$rfqBid->id}}_{{$num}}" class="btn btn-outline-primary btn-view"
                                                    data-file-url="{{ asset('files/'.$file) }}" onclick="previewFile('<?php echo 'file_'.$rfqBid->id.'_'.$num; ?>');">
                                                <i class="fa fa-eye me-2"></i>View File
                                            </button>
                                        @endforeach
                                    @elseif(!empty($rfqBid->attachment) && !Utility::isValidJson($rfqBid->attachment))
                                        <button id="file_{{$rfqBid->id}}" class="btn btn-outline-primary btn-view"
                                            data-file-url="{{ asset('files/'.$rfqBid->attachment) }}" onclick="previewFile('<?php echo 'file_'.$rfqBid->id; ?>');">
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
                            @foreach ($rfqBid->commentMany as $com)
                                
                                <tr>
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
                            <tr>
                                <td>
                                    <b>Message(@ Quote Submission):</b> <br>
                                    {{$rfqBid->custom_message}}<br>
                                    Created At : {{$rfqBid->created_at}}
                                </td>
                                <td></td>
                            </tr>
                                                                    
                        </tbody>
                    </table>
                </div>
                
            </div>
            <!-- #END OF TABLE BODY -->
        </div>

    </div>
</div>

<!-- #END# Bordered Table -->

