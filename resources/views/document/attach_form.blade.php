<p>
    {{$edit->doc_name}}
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
<?php $attach = json_decode($edit->docs,true); $num=0; ?>
@if(!empty($attach))
<table class="table table-responsive">
    <thead>
    <th> Attachment</th>
    <th>Download</th>
    <th>Preview</th>
    <th>Remove Attachment</th>
    </thead>
    <tbody>
    @foreach($attach as $at)
        <?php $num++; ?>
    <tr>
        <td>{{$at}}</td>
        <td><a target="_blank" href="<?php echo URL::to('download_document_attachment?file='); ?>{{$at}}">
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

            @if($edit->created_by == Auth::user()->id || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
            <button type="button"  onclick="submitMediaForm('attachModal','removeAttachForm','<?php echo url('remove_document_attachment'); ?>','reload_data',
                    '<?php echo url('document'); ?>','<?php echo csrf_token(); ?>')"
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

@if(!empty($docFiles))
    <table class="table table-responsive">
    <thead>
    <th> Attachment</th>
    <th>Download</th>
    <th>Preview</th>
    <th>Remove Attachment</th>
    </thead>
    <tbody>
    @foreach($docFiles as $data)
        <?php $num++; ?>
    <tr>
        <td>{{$data->original_name}}</td>
        <td><a target="_blank" href="<?php echo URL::to('download_document_attachment?file='); ?>{{$data->file_name}}">
                <i class="fa fa-files-o fa-2x"></i>
            </a>
        </td>
        <td>
            <button id="file5_{{$num}}" class="btn btn-outline-primary btn-view"
                    data-file-url="{{ asset('files/'.$data->file_name) }}" onclick="previewFile('<?php echo 'file5_'.$num; ?>');">
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
                                    <input type="hidden" value="{{$data->file_name}}"  class="form-control" name="attachment" >
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <input type="hidden" name="edit_id" value="{{$edit->id}}" >
            </form>

            @if($edit->created_by == Auth::user()->id || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
            <button type="button"  onclick="submitMediaForm('attachModal','removeAttachForm','<?php echo url('remove_document_attachment'); ?>','reload_data',
                    '<?php echo url('document'); ?>','<?php echo csrf_token(); ?>')"
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

@if($edit->created_by == Auth::user()->id || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
    <div class="row clearfix">
        <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_document_attachment'); ?>','reload_data',
                '<?php echo url('document'); ?>','<?php echo csrf_token(); ?>')"
                class="btn btn-info waves-effect pull-right">
            SAVE CHANGES
        </button>
    </div>
@endif



