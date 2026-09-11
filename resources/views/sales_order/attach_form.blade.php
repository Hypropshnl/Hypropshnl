<?php $attach = json_decode($edit->attachment,true); $num=0; ?>
@if(count($attach) < 1)
    No Document
@else

    <table class="table table-responsive">
        <thead>
        <th> Attachment</th>
        <th>Download/Open</th>
        <th>Remove Attachment</th>
        </thead>
        <tbody>
        @foreach($attach as $at)
            <?php $num++; ?>
            <tr id="removeAttach{{$num}}">
                <td>File{{$num}}</td>
                <td><a target="_blank" href="<?php echo URL::to('sales_download_attachment?file='); ?>{{$at}}">
                        <i class="fa fa-files-o fa-2x"></i>
                    </a></td>
                <td>

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

                    <button type="button"  onclick="removeMediaForm('removeAttach{{$num}}','removeAttachForm','<?php echo url('sales_remove_attachment'); ?>','reload_data',
                            '<?php echo url('sales_order'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-danger waves-effect">
                        Remove
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif