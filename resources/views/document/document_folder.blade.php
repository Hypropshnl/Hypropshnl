@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Folder with Document(s)</h4>
                </div>
                <div class="modal-body" style="height: 400px; overflow-y:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <input type="hidden" name="parent_id" value="{{$document->id}}">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="document_name" placeholder="Document Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" multiple name="department[]" >
                                                <option value="">Department(s) Accessible to Document(s) </option>
                                                @foreach($dept as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div><hr/>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" class="form-control" name="document_details" placeholder="Document Details"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="document_category" >
                                                <option value="">Document Category </option>
                                                @foreach($docCategory as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div><hr/>

                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        Upload File (multiple selection allowed)
                                        <div class="form-line">
                                            <input type="file" class="form-control" multiple="multiple" name="attachment[]" placeholder="Attachment">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-4" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="user" id="user" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>

                                <div class="col-sm-1" id="hide_button">
                                    <div class="form-group">
                                        <div onclick="addMoreEditable('add_more','hide_button','1','<?php echo URL::to('add_more'); ?>','multiple_users','hide_button','user_class');">
                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="" id="add_more">

                            </div>

                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitDocument('createModal','createMainForm','<?php echo url('create_document'); ?>','reload_data',
                            '<?php echo url('document_folder/' . $document->id); ?>','<?php echo csrf_token(); ?>','user_class')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Upload File(s)</h4>
                </div>
                <div class="modal-body" id="upload_content" style="height: 400px; overflow-y:scroll;">

                    <form name="" id="attachForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-12">
                                    Choose File(s) to Upload (multiple selection allowed)
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" multiple="multiple" class="form-control" name="attachment[]" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="edit_id" value="{{$document->id}}" >
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('uploadModal','attachForm','<?php echo url('edit_document_attachment'); ?>','reload_data',
                    '<?php echo url('document_folder/' . $document->id); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="height: 400px; overflow-y:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitDocument('editModal','editMainForm','<?php echo url('edit_document'); ?>','reload_data',
                            '<?php echo url('document_folder/' . $document->id); ?>','<?php echo csrf_token(); ?>','user_class_edit')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size Edit Department Form -->
    <div class="modal fade" id="editDeptModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Modify Department(s)</h4>
                </div>
                <ul class="header-dropdown m-r--5 " style="list-style-type: none;">
                    <li class="pull-right">
                            <button type="button" onclick="removeAddItem('kid_checkbox_add','reload_data','<?php echo url('document_folder/' . $document->id); ?>',
                                    '<?php echo url('modify_document_dept'); ?>','<?php echo csrf_token(); ?>','1','add selected Item(s)','document_id','editDeptModal');" class="btn btn-success">
                                <i class="fa fa-plus"></i>Add
                            </button>
                    </li>
                    <li>
                        <button type="button" onclick="removeAddItem('kid_checkbox_remove','reload_data','<?php echo url('document_folder/' . $document->id); ?>',
                                '<?php echo url('modify_document_dept'); ?>','<?php echo csrf_token(); ?>','0','remove selected Item(s)','document_id','editDeptModal');" class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>Remove
                        </button>
                    </li>
                </ul>
                <div class="modal-body" id="edit_dept_content" style="height: 400px; overflow-y:scroll;">

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size Attachment-->
    <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
                </div>
                <div class="modal-body" id="attach_content" style="height: 400px; overflow-y:scroll;">


                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>{{ $document->doc_name }} </h2>
                <small>Folder </small>
                <div class="row">
                    <div class="col-md-6">
                        <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="search_document" class="form-control"
                                        onkeyup="searchItemParam('search_document','reload_data','<?php echo url('search_document_file') ?>','{{url('document_folder/' . $document->id)}}','<?php echo csrf_token(); ?>','type_id')"
                                        name="search_user" placeholder="Search Files" >
                                </div>
                                <input type="hidden" id="type_id" value="1" name="type"/>
                            </div>
                        <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->
                    </div>
                    <div class="col-md-6">
                        <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="search_document1" class="form-control"
                                            onkeyup="searchItemParam('search_document1','reload_data','<?php echo url('search_document') ?>','{{url('document_folder/' . $document->id)}}','<?php echo csrf_token(); ?>','type_id2')"
                                            name="search_user" placeholder="Search Folders" >
                                    </div>
                                    <input type="hidden" id="type_id2" value="1" name="type"/>
                                </div>
                            <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->
                    </div>
                </div>
                <ul class="header-dropdown m-r--5">
                    <li>
                        <a class="btn btn-default" href="{{ url('document') }}"><i class="fa fa-home "></i> Home</a>
                    </li>
                    @if(!empty($document->parent_id))
                    <li>
                        <a class="btn btn-default" href="{{ url('document_folder', $document->parentDocument->id) }}"><i class="fa fa-arrow-circle-up "></i> Parent Folder</a>
                    </li>
                    @endif
                    <li>
                        <button class="btn btn-default waves-effect " type="button" data-toggle="collapse" data-target="#folder_details" aria-expanded="false"
                                aria-controls="folder_details">
                            <i class="fa fa-info-circle"></i> Folder Details
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-default waves-effect" type="button" data-toggle="collapse" data-target="#access_details" aria-expanded="false"
                                aria-controls="access_details">
                            <i class="fa fa-info-circle"></i> Access Details
                        </button>
                    </li>
                    
                    <li>
                        <button class="btn btn-default" onclick="location.reload()"><i class="fa fa-refresh "></i> Refresh</button>
                    </li>
                    <li>
                        <button class="btn btn-default" onclick="history.back()"><i class="fa fa-arrow-left"></i> Go Back</button>
                    </li>
                    <li>
                        <button class="btn btn-default" data-toggle="modal" data-target="#uploadModal"><i class="fa fa-cloud-upload"></i> Upload File(s)</button>
                    </li>
                    <li>
                        <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> Add Folder</button>
                    </li>
                    <li>
                        <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('document_folder/' . $document->id); ?>',
                                '<?php echo url('delete_document'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                            <i class="fa fa-trash-o"></i> Delete Folder(s)
                        </button>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                        </ul>
                    </li>

                </ul>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-md-6">
                        <!-- BEGIN OF SEARCH WITH DATE INTERVALS -->
                        <form name="search_file_form" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                            <div class=" body">

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="from_date" placeholder="From e.g 2019-02-22">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="to_date" placeholder="To e.g 2019-04-21">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="1" name="param"/>

                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="" style="">
                                        <div class="form-group">
                                            <button class="btn btn-info col-sm-12" type="button" onclick="searchUsingDate('searchMainForm','<?php echo url('search_document_file_using_date'); ?>','reload_data',
                                                    '<?php echo url('document'); ?>','<?php echo csrf_token(); ?>','start_date','end_date')" id="search_files_button">Search File(s)</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                        <!-- END OF SEARCH WITH DATE INTERVALS -->
                    </div>
                    <div class="col-md-6">
                        <!-- BEGIN OF SEARCH WITH DATE INTERVALS -->
                            <form name="searchFolderForm" id="searchFolderForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                <div class=" body">

                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select  class="form-control" multiple name="document_category[]" >
                                                        <option value="0" selected>All Document Category </option>
                                                        @foreach($docCategory as $ap)
                                                            <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control datepicker" autocomplete="off" id="start_date1" name="from_date" placeholder="From e.g 2019-02-22">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control datepicker" autocomplete="off" id="end_date1" name="to_date" placeholder="To e.g 2019-04-21">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="1" name="param"/>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12" id="" style="">
                                            <div class="form-group">
                                                <button class="btn btn-info col-sm-12" type="button" onclick="searchUsingDate('searchFolderForm','<?php echo url('search_document_using_date'); ?>','reload_data',
                                                        '<?php echo url('document_folder/'.$document->id); ?>','<?php echo csrf_token(); ?>','start_date1','end_date1')" id="search_hse_button">Search Folder(s)</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        <!-- END OF SEARCH WITH DATE INTERVALS -->
                    </div>
                </div>
            </div>
            <div class="body" id="reload_data">
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
                        <p><strong>Parent document Folder:</strong> <a href="{{ url('document_folder', $document->parentDocument->id) }}">{{ $document->parentDocument->doc_name }}</a></p>
                        <p><strong>Folder id:</strong> {{ $document->id }}</p>
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
                        @if(!empty($docsAttachments) && count($docsAttachments) && count($attachments) <= 0)
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
            </div>
        </div>
    </div>
</div>

<script>

        //SUBMIT FORM WITH A FILE
        function submitDocument(formModal,formId,submitUrl,reload_id,reloadUrl,token,userClass){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var postVars = new FormData(form);
            postVars.append('token',token);
            postVars.append('users',sanitizeDataWithoutEncode(userClass));

            $('#'+formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');
            
            sendRequestMediaForm(submitUrl,token,postVars);
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {
                    //HIDE LOADING ICON
					overlayBody('none');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){

                        //RESET FORM
						resetForm(formId);
                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", successMessage, "success");

                    }else if(message2 == 'token_mismatch'){

                        location.reload();

                    }else {
                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");
                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id,reloadUrl);
                }
            }

        }

        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            page = window.location.hash.replace('#','');
            getProducts(page);
        });

        $(document).on('click','.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getProducts(page);
            location.hash = page;
        });

        function getProducts(page){

            $.ajax({
                url: '?page=' + page
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

    </script>

@endsection
