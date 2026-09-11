<form name="" id="editMainFormMini" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-6">
                Purchase Order Status
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control ship_status" name="po_status" >

                            @foreach(\App\Helpers\Utility::accountStatus() as $val)
                                @if($edit->purchase_status == $val->id)
                                    <option selected value="{{$edit->dataStatus->id}}">{{$val->name}}</option>

                                @endif
                                <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                                <option value="">Select PO status</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <b>Mail Option</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="mail_option" >
                            @php $status = ($edit->mail_status == 1 ? 'Send Mail' : 'Do not send mail') @endphp
                            <option selected value="{{$edit->mail_status}}">{{$status}}</option>
                            <option value="1">Send Mail</option>
                            <option value="0">Do not send mail</option>
                        </select>
                    </div>
                </div>
            </div>

            
        </div>
        <hr/>

        <div class="row clearfix container">

            <div class="row clearfix">
                <div class="col-sm-6">
                    <b>Send Mail To</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control" name="emails" id="emails" placeholder="Enter Email(s), use a comma to separate them" >{{$edit->mails}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <b>Copy (cc)</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control" name="mail_copy" id="copy_mails" placeholder="Enter Email(s), use a comma to separate them" >{{$edit->mail_copy}}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<?php
$attach = (!empty($edit->attachment)) ? json_decode($edit->attachment,true) : []; $num=0;
$approvalDocs = (!empty($edit->approval_docs)) ? json_decode($edit->approval_docs,true) : [];
?>

@if(count($attach) < 1)
    No Vendor Document
@else

    <table class="table table-responsive">
        <thead>
        <th>Vendor Attachment</th>
        <th>Download</th>
        <th>Preview</th>
        <th>Remove Attachment</th>
        </thead>
        <tbody>
        @foreach($attach as $at)
            <?php $num++; ?>
            <tr id="removeAttach{{$num}}">
                <td>File{{$num}}</td>
                <td><a target="_blank" href="<?php echo URL::to('po_download_attachment?file='); ?>{{$at}}">
                        <i class="fa fa-files-o fa-2x"></i>
                    </a>
                </td>
                <td>
                    <button id="file_{{$num}}" class="btn btn-outline-primary btn-view"
                                    data-file-url="{{ asset('files/'.$at) }}" onclick="previewFile('<?php echo 'file_'.$num; ?>');">
                                <i class="fa fa-eye me-2"></i>View File
                            </button>
                </td>

                    <form name="" id="removeAttachForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="hidden" value="{{$at}}"  class="form-control" name="attachment" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                    </form>

                    <button type="button"  onclick="removeMediaForm('removeAttach{{$num}}','removeAttachForm','<?php echo url('po_remove_attachment'); ?>','reload_data',
                            '<?php echo url('purchase_order'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-danger waves-effect">
                        Remove
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

@if(count($approvalDocs) < 1)
    No Approval Document(s)
@else

    <table class="table table-responsive">
        <thead>
        <th>Approval Document(s)</th>
        <th>Download</th>
        <th>Preview</th>
        <th>Remove Attachment</th>
        </thead>
        <tbody>
        @foreach($approvalDocs as $at)
            <?php $num++; ?>
            <tr id="removeApprovalDocs{{$num}}">
                <td>File{{$num}}</td>
                <td><a target="_blank" href="<?php echo URL::to('po_download_attachment?file='); ?>{{$at}}">
                        <i class="fa fa-files-o fa-2x"></i>
                    </a>
                </td>
                <td>
                    <button id="file_approval_docs_{{$num}}" class="btn btn-outline-primary btn-view"
                                    data-file-url="{{ asset('files/'.$at) }}" onclick="previewFile('<?php echo 'file_approval_docs_'.$num; ?>');">
                                <i class="fa fa-eye me-2"></i>View File
                            </button>
                </td>

                    <form name="" id="removeApprovalDocsForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="hidden" value="{{$at}}"  class="form-control" name="attachment" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                    </form>

                    <button type="button"  onclick="removeMediaForm('removeApprovalDocs{{$num}}','removeapprovalDocsForm','<?php echo url('po_remove_approval_docs'); ?>','reload_data',
                            '<?php echo url('purchase_order'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-danger waves-effect">
                        Remove
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });

</script>