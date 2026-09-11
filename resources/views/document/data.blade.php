<div class="container-fluid mb-5">
    <div class="row mb-3">
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check" name="check_all">
                
            </div>
        </div>
    </div>

    <div class="row g-3" id="main_table">
        @foreach($mainData as $data)
            @if(in_array(Auth::user()->dept_id,$data->deptArray) || in_array(Auth::user()->id,$data->userArray) || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS) || $data->created_by == Auth::user()->id)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm position-relative h-100">
                        <!-- Checkbox -->
                        <div class="position-absolute top-0 start-0 m-2" style="z-index: 10;">
                            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="form-check-input kid_checkbox">
                        </div>

                        <!-- Action Icons -->
                        <div class="position-absolute top-0 end-0 m-2" style="z-index: 10;">
                            <div class="btn-group-vertical btn-group-sm" role="group">
                                @if($data->created_by == Auth::user()->id || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                                    <button type="button" class="btn btn-outline-primary btn-sm" title="Edit Folder & Manage User Access" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_document_form') ?>','<?php echo csrf_token(); ?>')">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-info btn-sm" title="Manage Department Access" onclick="fetchHtml('{{$data->id}}','edit_dept_content','editDeptModal','<?php echo url('edit_document_dept_form') ?>','<?php echo csrf_token(); ?>')">
                                        <i class="fa fa-sitemap"></i>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-outline-success btn-sm" title="View some Last Uploaded Document(s)" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_document_attachment_form') ?>','<?php echo csrf_token(); ?>')">
                                    <i class="fa fa-file"></i>
                                </button>
                                <a href="<?php echo url('document_comments/'.$data->id) ?>" class="btn btn-outline-secondary btn-sm" title="View/Comment">
                                    <i class="fa fa-comments"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Folder Icon -->
                        <div class="card-body text-center py-5">
                            <a href="<?php echo url('document_folder/'.$data->id) ?>" class="text-decoration-none">
                                <i class="fa fa-folder fa-5x text-warning mb-3"></i>
                                <h5 class="card-title mt-3">{{$data->doc_name}}</h5>
                            </a>
                        </div>

                        <!-- Footer Info -->
                        <div class="card-footer bg-light border-top">
                            <small class="text-muted d-block">{{$data->docCategory->category_name}}</small>
                            <!-- <small class="text-muted d-block text-truncate" title="{{$data->doc_desc}}">{{$data->doc_desc}}</small> -->
                            
                            @if(!empty($data->deptAccess))
                                <small class="d-block mt-2">
                                    <span class="badge bg-info" data-bs-toggle="tooltip" title="@foreach($data->deptAccess as $dept){{$dept->dept_name}}@if(!$loop->last), @endif @endforeach">Depts: {{count($data->deptAccess)}}</span>
                                </small>
                            @endif

                            @if(!empty($data->userAccess))
                                <small class="d-block mt-1">
                                    <span class="badge bg-secondary" data-bs-toggle="tooltip" title="@foreach($data->userAccess as $user){{$user->firstname}} {{$user->lastname}}@if(!$loop->last), @endif @endforeach">Users: {{count($data->userAccess)}}</span>
                                </small>
                            @endif

                            <small class="d-block mt-1">
                                <span class="badge bg-secondary" data-bs-toggle="tooltip" title="created_by {{$data->user_c->firstname}} {{$data->user_c->lastname}}, Created at {{$data->created_at}}, updated by {{$data->user_u->firstname}} {{$data->user_u->lastname}}, Updated at {{$data->updated_at}}">Audit</span>
                            </small>

                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>

