<div class="row clearfix">
                    <div class="col-sm-12">
                        @if(!empty($mainData))
                            <div class="table-responsive">
                                @foreach($mainData as $data)
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="card border-0 shadow-sm position-relative h-100">
                                            <!-- Checkbox -->
                                            
                                            <!-- Action Icons -->
                                            <div class="position-absolute top-0 end-0 m-2" style="z-index: 10;">
                                                <div class="btn-group-vertical btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-outline-primary btn-sm" title="Delete File" onclick="submitMediaFormNoModal('removeAttachForm1','<?php echo url('remove_document_attachment'); ?>','reload_data','<?php echo url('document_folder/'.$data->document_id); ?>','<?php echo csrf_token(); ?>')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
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
                                                    <input type="hidden" name="edit_id" value="{{$data->document_id}}" >
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