@extends('layouts.app')

@section('content')

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Certificate Template</h4>
                </div>
                <div class="modal-body" style="height: 500px; overflow-y: auto;">
                    <form id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6"><div class="form-group"><label>Template Name <span class="text-danger">*</span></label><div class="form-line"><input type="text" class="form-control" name="name"></div></div></div>
                                <div class="col-sm-6"><div class="form-group"><label>Certificate Name</label><div class="form-line"><input type="text" class="form-control" name="cert_name"></div></div></div>
                                <div class="col-sm-6"><div class="form-group"><label>Logo</label><div class="form-line"><input type="file" class="form-control" name="logo"></div></div></div>
                                <div class="col-sm-6"><div class="form-group"><label>Company Name</label><div class="form-line"><input type="text" class="form-control" name="company_name"></div></div></div>
                                <div class="col-sm-6"><div class="form-group"><label>Heading</label><div class="form-line"><input type="text" class="form-control" name="heading"></div></div></div>
                                <div class="col-sm-6"><div class="form-group"><label>Sub Heading</label><div class="form-line"><input type="text" class="form-control" name="sub_heading"></div></div></div>
                                <div class="col-sm-6"><div class="form-group"><label>Sub Heading Two</label><div class="form-line"><input type="text" class="form-control" name="sub_heading_two"></div></div></div>
                                <div class="col-sm-6"><div class="form-group"><label>Cert Number Format(eg. CERT/DOC-) <span class="text-danger">*</span></label><div class="form-line"><input type="text" class="form-control" name="cert_num_format"></div></div></div>
                                <div class="col-sm-6"><div class="form-group"><label>Certificate Template(image width:3600px* height:2550px) <span class="text-danger">*</span></label><div class="form-line"><input type="file" class="form-control" name="template_doc"></div></div></div>
                                <div class="col-sm-6"><div class="form-group"><label>Cert ID Display(eg. Certificate ID,Document ID)</label><div class="form-line"><input type="text" class="form-control" name="cert_id_display"></div></div></div>
                                <div class="col-sm-6"><div class="form-group"><label>Stamp</label><div class="form-line"><input type="file" class="form-control" name="stamp"></div></div></div>
                                <div class="col-sm-12"><div class="form-group"><label>Cert Name Position</label><div class="row clearfix"><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="cert_name_pos_x" placeholder="X Position"></div></div><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="cert_name_pos_y" placeholder="Y Position"></div></div></div></div></div>
                                <div class="col-sm-12"><div class="form-group"><label>Logo Position</label><div class="row clearfix"><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="logo_pos_x" placeholder="X Position"></div></div><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="logo_pos_y" placeholder="Y Position"></div></div></div></div></div>
                                <div class="col-sm-12"><div class="form-group"><label>Company Name Position</label><div class="row clearfix"><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="company_name_pos_x" placeholder="X Position"></div></div><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="company_name_pos_y" placeholder="Y Position"></div></div></div></div></div>
                                <div class="col-sm-12"><div class="form-group"><label>Heading Position</label><div class="row clearfix"><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="heading_pos_x" placeholder="X Position"></div></div><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="heading_pos_y" placeholder="Y Position"></div></div></div></div></div>
                                <div class="col-sm-12"><div class="form-group"><label>Sub Heading Position</label><div class="row clearfix"><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="sub_heading_pos_x" placeholder="X Position"></div></div><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="sub_heading_pos_y" placeholder="Y Position"></div></div></div></div></div>
                                <div class="col-sm-12"><div class="form-group"><label>Sub Heading Two Position</label><div class="row clearfix"><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="sub_heading_two_pos_x" placeholder="X Position"></div></div><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="sub_heading_two_pos_y" placeholder="Y Position"></div></div></div></div></div>
                                <div class="col-sm-12"><div class="form-group"><label>Cert Number Format Position</label><div class="row clearfix"><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="cert_num_format_pos_x" placeholder="X Position"></div></div><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="cert_num_format_pos_y" placeholder="Y Position"></div></div></div></div></div>
                                <div class="col-sm-12"><div class="form-group"><label>Cert ID Display Position</label><div class="row clearfix"><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="cert_id_display_pos_x" placeholder="X Position"></div></div><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="cert_id_display_pos_y" placeholder="Y Position"></div></div></div></div></div>
                                <div class="col-sm-12"><div class="form-group"><label>Stamp Position</label><div class="row clearfix"><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="stamp_pos_x" placeholder="X Position"></div></div><div class="col-sm-6"><div class="form-line"><input type="number" class="form-control" name="stamp_pos_y" placeholder="Y Position"></div></div></div></div></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_certificate_template'); ?>','reload_data','<?php echo url('certificate_template'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-success">SAVE</button>
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
                    <h4 class="modal-title">Edit Certificate Template</h4>
                </div>
                <div class="modal-body" id="edit_content" style="height: 500px; overflow-y: auto;"></div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_certificate_template'); ?>','reload_data','<?php echo url('certificate_template'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-success">SAVE CHANGES</button>
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
                    <h2>Certificate Templates</h2>
                    <ul class="header-dropdown m-r--5">
                        <li><button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> Add</button></li>
                        <li><button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('certificate_template'); ?>','<?php echo url('delete_certificate_template'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button></li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body table-responsive" id="reload_data">
                    @include('certificate_template.reload')
                </div>
            </div>
        </div>
    </div>

@endsection
