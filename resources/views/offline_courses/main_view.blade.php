@extends('layouts.app')

@section('content')

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Offline Course</h4>
                </div>
                <div class="modal-body">
                    <form id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Course Title</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="location">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Certificate Template</label>
                                        <div class="form-line">
                                            <select class="form-control" name="cert_template_id" required>
                                                <option value="">Select certificate template</option>
                                                @foreach($certificateTemplates as $template)
                                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name One</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name_one">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name One Role</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name_one_role">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name Two</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name_two">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name Two Role</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name_two_role">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name One Signature</label>
                                        <div class="form-line">
                                            <input type="file" class="form-control" name="name_one_sign">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name Two Signature</label>
                                        <div class="form-line">
                                            <input type="file" class="form-control" name="name_two_sign">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_offline_course'); ?>','reload_data','<?php echo url('offline_courses'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-success">SAVE</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Offline Course</h4>
                </div>
                <div class="modal-body" id="edit_content"></div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_offline_course'); ?>','reload_data','<?php echo url('offline_courses'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-success">SAVE CHANGES</button>
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
                    <h2>Offline Courses</h2>
                    <ul class="header-dropdown m-r--5">
                        <li><button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> Add</button></li>
                        <li><button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('offline_courses'); ?>','<?php echo url('delete_offline_course'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button></li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body table-responsive" id="reload_data">
                    @include('offline_courses.reload')
                </div>
            </div>
        </div>
    </div>

@endsection
