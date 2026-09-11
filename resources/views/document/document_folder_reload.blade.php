
<div class="row clearfix">
    <div class="col-sm-6 collapse" id="folder_details">
        <h4>Document Details</h4>
        <p><strong>Name:</strong> {{ $document->doc_name }}</p>
        <p><strong>Category:</strong> {{ optional($document->docCategory)->category_name ?: '-' }}</p>
        <p><strong>Description:</strong> {{ $document->doc_desc ?: '-' }}</p>
        <p><strong>Created by:</strong> {{ optional($document->user_c)->firstname }} {{ optional($document->user_c)->lastname }}</p>
        <p><strong>Created at:</strong> {{ $document->created_at }}</p>
        <p><strong>Updated by:</strong> {{ optional($document->user_u)->firstname }} {{ optional($document->user_u)->lastname }}</p>
        <p><strong>Updated at:</strong> {{ $document->updated_at }}</p>
    </div>
    <div class="col-sm-6 collapse" id="access_details">
        <h4>Access</h4>
        <p><strong>Departments:</strong>
            @if(!empty($departmentAccess) && count($departmentAccess))
                {{ $departmentAccess->pluck('dept_name')->implode(', ') }}
            @else
                <span class="text-muted">None</span>
            @endif
        </p>
        <p><strong>Users:</strong>
            @if(!empty($userAccess) && count($userAccess))
                @foreach($userAccess as $accessUser)
                    {{ trim($accessUser->firstname . ' ' . $accessUser->lastname) }}@if(!$loop->last), @endif
                @endforeach
            @else
                <span class="text-muted">None</span>
            @endif
        </p>
        <p><strong>Parent document Folder:</strong> {{ $document->parentDocument->doc_name }}</p>
        <p><strong>Document id:</strong> {{ $document->id }}</p>
    </div>
</div>

<div class="row">
    @if(!empty($childDocuments) && count($childDocuments))
        @include('document.data', ['mainData' => $childDocuments])
    @endif
</div>

<div class="row clearfix">
    <div class="col-sm-12">
        @if(!empty($attachments))
            <div class="table-responsive">
                @foreach($attachments as $data)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm position-relative h-100">
                            <!-- Checkbox -->
                            
                            <!-- Action Icons -->
                            <div class="position-absolute top-0 end-0 m-2" style="z-index: 10;">
                                <div class="btn-group-vertical btn-group-sm" role="group">
                                    @if(in_array(Auth::user()->role,Utility::TOP_USERS) || $document->created_by == Auth::user()->id)
                                        <button type="button" class="btn btn-outline-primary btn-sm" title="Delete File" onclick="submitMediaFormNoModal('removeAttachForm1','<?php echo url('remove_document_attachment'); ?>','reload_data','<?php echo url('document_folder/'.$document->id); ?>','<?php echo csrf_token(); ?>')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endif
                                    <a class="btn btn-outline-info btn-sm" target="_blank" title="Download File" href="<?php echo URL::to('download_attachment?file='); ?>{{$data->file_name}}">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    <button id="file1_{{$data->id}}" class="btn btn-outline-primary btn-view btn-sm"
                                            data-file-url="{{ asset('files/'.$data->file_name) }}" onclick="previewFile('<?php echo 'file1_'.$data->id; ?>');">
                                        <i class="fa fa-eye me-2"></i>
                                    </button>
                                </div>
                                <form name="removeAttachForm1" id="removeAttachForm1" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                    <input type="hidden" value="{{$data->file_name}}"  class="form-control" name="attachment" >
                                    <input type="hidden" name="edit_id" value="{{$document->id}}" >
                                </form>
                            </div>

                            <!-- Folder Icon -->
                            <div class="card-body text-center py-5">
                                <a id="file1_{{$data->id}}" data-file-url="{{ asset('files/'.$data->file_name) }}" onclick="previewFile('<?php echo 'file1_'.$data->id; ?>');" class="text-decoration-none btn-view">
                                    <i class="fa fa-file-text-o fa-5x text-warning mb-3"></i>
                                    <h5 class="card-title mt-3">{{$data->original_name}}</h5>
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">No child documents found for this folder.</p>
        @endif
    </div>
</div>

<div class="row clearfix">
    <div class="col-sm-12">
        @php $num = 0; @endphp
        @if(!empty($docsAttachments) && count($docsAttachments)  && count($attachments) <= 0)
            @foreach($docsAttachments as $file)
                @php $num++; @endphp
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm position-relative h-100">
                        <!-- Checkbox -->
                        
                        <!-- Action Icons -->
                        <div class="position-absolute top-0 end-0 m-2" style="z-index: 10;">
                            <div class="btn-group-vertical btn-group-sm" role="group">
                                @if(in_array(Auth::user()->role,Utility::TOP_USERS) || $document->created_by == Auth::user()->id)
                                    <button type="button" class="btn btn-outline-primary btn-sm" title="Delete File" onclick="submitMediaFormNoModal('removeAttachForm2','<?php echo url('remove_document_attachment'); ?>','reload_data','<?php echo url('document_folder/'.$document->id); ?>','<?php echo csrf_token(); ?>')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif
                                <a class="btn btn-outline-info btn-sm" target="_blank" title="Download File" href="<?php echo URL::to('download_attachment?file='); ?>{{$file}}">
                                    <i class="fa fa-download"></i>
                                </a>
                                <button id="file_{{$num}}" class="btn btn-outline-primary btn-view"
                                        data-file-url="{{ asset('files/'.$file) }}" onclick="previewFile('<?php echo 'file_'.$num; ?>');">
                                    <i class="fa fa-eye me-2"></i>
                                </button>
                            </div>
                            <form name="removeAttachForm2" id="removeAttachForm2" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="hidden" value="{{$file}}"  class="form-control" name="attachment" >
                                <input type="hidden" name="edit_id" value="{{$document->id}}" >
                            </form>
                        </div>

                        <!-- Folder Icon -->
                        <div class="card-body text-center py-5">
                            <a id="file_{{$num}}" data-file-url="{{ asset('files/'.$file) }}" style="cursor:pointer"
                            onclick="previewFile('<?php echo 'file_'.$num; ?>');" class="text-decoration-none btn-view">
                                <i class="fa fa-file-text-o fa-5x text-warning mb-3"></i>
                                <h5 class="card-title mt-3">{{$file}}</h5>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        @endif
        
    </div>
</div>
