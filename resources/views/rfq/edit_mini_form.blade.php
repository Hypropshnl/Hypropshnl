<form name="" id="editMiniForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

        <div class="row clearfix">
            <!-- <div class="col-sm-4">
                <div class="form-group">
                    Due Date
                    <div class="form-line">
                        <input type="date" class="form-control date" value="{{$edit->due_date}}" id="due_date_edit" name="due_date" placeholder="Due Date">
                    </div>
                </div>
            </div> -->

            <div class="col-sm-4">
                <div class="form-group">
                    RFQ Status
                    <div class="form-line">
                        <select class="form-control rfq_status_mini" name="rfq_status" >

                            @foreach(\App\Helpers\Utility::accountStatus() as $val)
                                @if($edit->rfq_status == $val->id)
                                    <option selected value="{{$edit->dataStatus->id}}">{{$val->name}}</option>
                                @endif
                                <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                                <option value="">Select RFQ status</option>
                        </select>
                    </div>
                </div>
            </div>
        
            <div class="col-sm-4">
                <b>Mail Option</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="mail_option" >
                            <option selected value="1">Send Mail</option>
                            <option value="0">Do not send mail</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <hr/>
        <div class="row clearfix">
                <div class="col-sm-6">
                    <b>Vendor(s)(Add/Remove to the Vendor Mail text box by selection)</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" autocomplete="off" id="select_item_33" onkeyup="searchOptionListMultipleDetail('select_item_33','myUL_33','{{url('default_select')}}','search_multiple_vendor_detail','inv_33','vendor_desc_33','vendor_array_id_33','vendor_cust_mails');" name="select_vendor" placeholder="Select Vendor">

                            <input type="hidden" class="inv_class" value="" name="vendor_data" id="inv_33" />
                        </div>
                    </div>
                    <ul id="myUL_33" class="myUL"></ul>
                </div>
                <div class="col-sm-6">
                    <b>Vendor Emails</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control" id="vendor_desc_33" name="emails" placeholder="Vendor Emails" required>{{$edit->mails}}</textarea>
                        </div>
                    </div>
                    <input type="hidden" id="vendor_array_id_33" name="vendor_array">
                </div>
            </div>
        <div class="row clearfix container">

            <div class="row clearfix">
                
            <div class="col-sm-4">
                <div class="form-group">
                    Due Date & Time
                    <div class="form-line">
                        <input type="datetime-local" class="form-control " value="{{$edit->due_date_time}}" name="due_date_time" placeholder="Due Date and Time">
                    </div>
                </div>
            </div>
                <div class="col-sm-6">
                    <b>Copy (cc)</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control" name="mail_copy" placeholder="Enter Email(s), use a comma to separate them" >{{$edit->mail_copy}}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row clearfix">

                <textarea id="mail_message_mini_edit" name="message" class="ckeditor" placeholder="Message">{{$edit->message}}</textarea>
                <script>
                    CKEDITOR.replace('mail_message_mini_edit');
                </script>
                <script src="{{ asset('templateEditor/ckeditor/ckeditor.js') }}"></script>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    // $(function() {
    //     $( ".datepicker4" ).datepicker({
    //         changeMonth: true,
    //         changeYear: true,
    //         dateFormat: "yy-mm-dd"
    //         /*yearRange: "-90:+00"*/

    //     });
    // });

</script>