<p>
    {{$edit->req_desc}}
</p>

<form name="" id="attachForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" multiple="multiple" class="form-control" name="attachment[]" >
                    </div>
                </div>
            </div>

        </div>
    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>
<?php $attach = json_decode($edit->attachment,true); $num=0; ?>
<?php $mrAttach = (!empty($mrData)) ? json_decode($mrData->attachment,true) : ''; $num=0; ?>
@if(count($attach) < 1)
    No Document
@else

    <table class="table table-responsive">
        <thead>
        <th>Fund Request Attachment</th>
        <th>Download</th>
        <th>Preview</th>
        <th>Remove Attachment</th>
        </thead>
        <tbody>
        @foreach($attach as $at)
            <?php $num++; ?>
        <tr>
            <td>{{$at}}</td>
            <td><a target="_blank" href="<?php echo URL::to('download_attachment?file='); ?>{{$at}}">
                    <i class="fa fa-files-o fa-2x"></i>
                </a>
            </td>
            <td>
                <button id="file_{{$num}}" class="btn btn-outline-primary btn-view"
                                data-file-url="{{ asset('files/'.$at) }}" onclick="previewFile('<?php echo 'file_'.$num; ?>');">
                            <i class="fa fa-eye me-2"></i>View File
                        </button>
            </td>
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
                @if($edit->created_by == Auth::user()->id)
                <button type="button"  onclick="submitMediaForm('attachModal','removeAttachForm','<?php echo url('remove_attachment'); ?>','reload_data',
                        '<?php echo url('requisition'); ?>','<?php echo csrf_token(); ?>')"
                        class="btn btn-danger waves-effect">
                    Remove
                </button>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endif

@if(!empty($mrAttach))

    <table class="table table-responsive">
        <thead>
        <th>Material Request Attachment</th>
        <th>Download/Open</th>
        <th>Preview</th>
        </thead>
        <tbody>
        @foreach($mrAttach as $at)
            <?php $num++; ?>
        <tr>
            <td>{{$at}}</td>
            <td><a target="_blank" href="<?php echo URL::to('download_attachment?file='); ?>{{$at}}">
                    <i class="fa fa-files-o fa-2x"></i>
                </a>
            </td>
            <td>
                <button id="mr_file_{{$num}}" class="btn btn-outline-primary btn-file-preview"
                                data-file-url="{{ asset('files/'.$at) }}" onclick="previewFile('<?php echo 'mr_file_'.$num; ?>');">
                            <i class="fa fa-eye me-2"></i>View
                        </button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

@endif