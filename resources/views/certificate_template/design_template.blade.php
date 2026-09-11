@extends('layouts.app')

@section('content')

<div class="container-fluid" style="">
    <!-- Header with cool badge -->
    <div class="row" style="">
        <div class="col-md-7">
            <h2 style="color: #337ab7; font-weight: bold;"><i class="fa fa-certificate"></i> CertDesigner Pro</h2>
            <p class="text-muted">Drag & drop elements on certificate · Real-time coordinates sync</p>
        </div>
        <div class="col-md-2 text-right">
            <button class="btn btn-info" style="" 
                onclick="submitDesignTemplate('editMainForm','editMainForm2','<?php echo url('edit_certificate_template'); ?>','','','<?php echo csrf_token(); ?>')">
                <i class="fa fa-save"></i> Save your design
            </button>
        </div>
        <div class="col-md-3 text-right">
            <div class="alert btn-info" style="padding: 8px 15px; margin-bottom: 0;">
                <i class="fa fa-arrows-alt"></i> Drag any colored tag → updates X/Y instantly
            </div>
        </div>
    </div>

    <?php 
        $cert_name_pos = json_decode($edit->cert_name_pos, true) ?? ['x_pos' => 420, 'y_pos' => 320];
        $logo_pos = json_decode($edit->logo_pos, true) ?? ['x_pos' => 120, 'y_pos' => 80];
        $company_name_pos = json_decode($edit->company_name_pos, true) ?? ['x_pos' => 360, 'y_pos' => 160];
        $heading_pos = json_decode($edit->heading_pos, true) ?? ['x_pos' => 600, 'y_pos' => 440];
        $sub_heading_pos = json_decode($edit->sub_heading_pos, true) ?? ['x_pos' => 600, 'y_pos' => 496];
        $sub_heading_two_pos = json_decode($edit->sub_heading_two_pos, true) ?? ['x_pos' => 600, 'y_pos' => 544];
        $cert_num_format_pos = json_decode($edit->cert_num_format_pos, true) ?? ['x_pos' => 240, 'y_pos' => 600];
        $cert_id_display_pos = json_decode($edit->cert_id_display_pos, true) ?? ['x_pos' => 840, 'y_pos' => 640];
        $stamp_pos = json_decode($edit->stamp_pos, true) ?? ['x_pos' => 960, 'y_pos' => 680];
        $qr_code_pos = json_decode($edit->qr_code_pos, true) ?? ['x_pos' => 860, 'y_pos' => 580];
    ?>

    <div class="row">
        <!-- LEFT COLUMN: FORM + FIELDS -->
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading" style="background: #fff; border-bottom: none; padding-bottom: 0;">
                    <ul class="nav nav-tabs" id="formTab">
                        <li class="active"><a href="#details" data-toggle="tab"><i class="fa fa-pencil-alt"></i> Certificate Data</a></li>
                        <li><a href="#positions" data-toggle="tab"><i class="fa fa-map-marker"></i> Live Positions</a></li>
                    </ul>
                </div>
                <div class="panel-body tab-content">
                    <!-- Tab 1: Main form fields -->
                    <div class="tab-pane fade in active" id="details">
                        <form id="editMainForm" name="editMainForm" onsubmit="return false;" class="form-horizontal">
                            <div class="row" style="margin: 0 -10px;">
                                <input type="hidden" name="edit_id" value="{{$edit->id}}">
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-tag"></i> Template Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{$edit->name}}" id="tmpl_name" placeholder="e.g., Gold Standard">
                                </div>
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-id-card"></i> Certificate Name</label>
                                    <input type="text" class="form-control" name="cert_name" id="cert_name" value="{{$edit->cert_name}}">
                                </div>
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-image"></i> Logo (Upload)</label>
                                    <input type="file" class="form-control" name="logo" id="logo_upload" accept="image/*">
                                </div>
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-building"></i> Company Name</label>
                                    <input type="text" class="form-control" name="company_name" id="company_name" value="{{$edit->company_name}}">
                                </div>
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-header"></i> Heading</label>
                                    <input type="text" class="form-control" name="heading" id="heading" value="{{$edit->heading}}">
                                </div>
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-subscript"></i> Sub Heading</label>
                                    <input type="text" class="form-control" name="sub_heading" id="sub_heading" value="{{$edit->sub_heading}}">
                                </div>
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-asterisk"></i> Sub Heading Two</label>
                                    <input type="text" class="form-control" name="sub_heading_two" id="sub_heading_two" value="{{$edit->sub_heading_two}}">
                                </div>
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-hashtag"></i> Cert Number Format <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="cert_num_format" id="cert_num_format" value="{{$edit->cert_num_format}}" placeholder="e.g., CERT/DOC/">
                                </div>
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-upload"></i> Certificate Template (Image)</label>
                                    <input type="file" class="form-control" name="template_doc" id="template_image_upload" accept="image/jpeg,image/png,image/webp">
                                </div>
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-qrcode"></i> Cert ID Display</label>
                                    <input type="text" class="form-control" name="cert_id_display" id="cert_id_display" value="{{$edit->cert_id_display}}" placeholder="e.g., Certificate ID: 2025-001">
                                </div>
                                <div class="col-sm-6" style="padding: 0 10px 15px 10px;">
                                    <label class="control-label"><i class="fa fa-stamp"></i> Stamp (Image)</label>
                                    <input type="file" class="form-control" name="stamp" id="stamp_upload" accept="image/*">
                                </div>
                            </div>
                            <div class="alert btn-info" style="">
                                <i class="fa fa-info-circle"></i> Update any text → preview updates instantly
                            </div>
                        </form>
                    </div>
                    <!-- Tab 2: realtime position fields (sync with drag) -->
                    <div class="tab-pane fade" id="positions">
                        <form id="editMainForm2" name="editMainForm2" onsubmit="return false;" class="form-horizontal">
                            <div class="row position-fields-panel" style="padding: 15px;">
                                <h4 style="border-bottom: 1px solid #eee; padding-bottom: 8px;"><i class="fa fa-crosshairs"></i> Draggable Coordinates (X,Y)</h4>
                                <div class="col-sm-6" style="margin-bottom: 12px;">
                                    <label class="control-label small">🎓 Cert Name</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">X</span>
                                        <input type="number" id="cert_name_pos_x" name="cert_name_pos_x" class="form-control" placeholder="X" value="{{ $cert_name_pos['x_pos'] }}">
                                        <span class="input-group-addon">Y</span>
                                        <input type="number" id="cert_name_pos_y" name="cert_name_pos_y" class="form-control" placeholder="Y" value="{{ $cert_name_pos['y_pos'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 12px;">
                                    <label class="control-label small">🖼️ Logo</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">X</span>
                                        <input type="number" id="logo_pos_x" name="logo_pos_x" class="form-control" value="{{ $logo_pos['x_pos'] }}">
                                        <span class="input-group-addon">Y</span>
                                        <input type="number" id="logo_pos_y" name="logo_pos_y" class="form-control" value="{{ $logo_pos['y_pos'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 12px;">
                                    <label class="control-label small">🏢 Company Name</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">X</span>
                                        <input type="number" id="company_name_pos_x" name="company_name_pos_x" class="form-control" value="{{ $company_name_pos['x_pos'] }}">
                                        <span class="input-group-addon">Y</span>
                                        <input type="number" id="company_name_pos_y" name="company_name_pos_y" class="form-control" value="{{ $company_name_pos['y_pos'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 12px;">
                                    <label class="control-label small">📌 Heading</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">X</span>
                                        <input type="number" id="heading_pos_x" name="heading_pos_x" class="form-control" value="{{ $heading_pos['x_pos'] }}">
                                        <span class="input-group-addon">Y</span>
                                        <input type="number" id="heading_pos_y" name="heading_pos_y" class="form-control" value="{{ $heading_pos['y_pos'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 12px;">
                                    <label class="control-label small">🔖 Sub Heading</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">X</span>
                                        <input type="number" id="sub_heading_pos_x" name="sub_heading_pos_x" class="form-control" value="{{ $sub_heading_pos['x_pos'] }}">
                                        <span class="input-group-addon">Y</span>
                                        <input type="number" id="sub_heading_pos_y" name="sub_heading_pos_y" class="form-control" value="{{ $sub_heading_pos['y_pos'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 12px;">
                                    <label class="control-label small">📑 Sub Heading Two</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">X</span>
                                        <input type="number" id="sub_heading_two_pos_x" name="sub_heading_two_pos_x" class="form-control" value="{{ $sub_heading_two_pos['x_pos'] }}">
                                        <span class="input-group-addon">Y</span>
                                        <input type="number" id="sub_heading_two_pos_y" name="sub_heading_two_pos_y" class="form-control" value="{{ $sub_heading_two_pos['y_pos'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 12px;">
                                    <label class="control-label small">🔢 Cert Number Format</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">X</span>
                                        <input type="number" id="cert_num_format_pos_x" name="cert_num_format_pos_x" class="form-control" value="{{ $cert_num_format_pos['x_pos'] }}">
                                        <span class="input-group-addon">Y</span>
                                        <input type="number" id="cert_num_format_pos_y" name="cert_num_format_pos_y" class="form-control" value="{{ $cert_num_format_pos['y_pos'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 12px;">
                                    <label class="control-label small">🆔 Cert ID Display</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">X</span>
                                        <input type="number" id="cert_id_display_pos_x" name="cert_id_display_pos_x" class="form-control" value="{{ $cert_id_display_pos['x_pos'] }}">
                                        <span class="input-group-addon">Y</span>
                                        <input type="number" id="cert_id_display_pos_y" name="cert_id_display_pos_y" class="form-control" value="{{ $cert_id_display_pos['y_pos'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 12px;">
                                    <label class="control-label small">📜 Stamp</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">X</span>
                                        <input type="number" id="stamp_pos_x" name="stamp_pos_x" class="form-control" value="{{ $stamp_pos['x_pos'] }}">
                                        <span class="input-group-addon">Y</span>
                                        <input type="number" id="stamp_pos_y" name="stamp_pos_y" class="form-control" value="{{ $stamp_pos['y_pos'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 12px;">
                                    <label class="control-label small">🔳 QR Code (Dummy)</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">X</span>
                                        <input type="number" id="qr_code_pos_x" name="qr_code_pos_x" class="form-control" value="{{ $qr_code_pos['x_pos'] }}">
                                        <span class="input-group-addon">Y</span>
                                        <input type="number" id="qr_code_pos_y" name="qr_code_pos_y" class="form-control" value="{{ $qr_code_pos['y_pos'] }}">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="alert btn-info" style="">
                            <i class="fa fa-mouse-pointer"></i> Tip: Drag tags directly on canvas → coordinates update here automatically
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: CERTIFICATE CANVAS + DRAG ZONE -->
        <div class="col-md-7">
            <div class="panel panel-default" style="overflow: hidden;">
                <div class="panel-heading">
                    <i class="fa fa-vector-square"></i> Certificate Preview (Drag markers)
                    <div class="pull-right">
                        <span class="label label-info"><i class="fa fa-arrows-alt"></i> Draggable items</span>
                        <span id="imageDimensionsDisplay" class="label label-default" style="margin-left: 10px;"><i class="fa fa-ruler"></i> Width: -- px | Height: -- px</span>
                    </div>
                </div>
                <div class="panel-body text-center" style="background: #f5f5f5;">
                    <div class="canvas-container" id="canvasContainer" style="position: relative; display: inline-block; width: 100%;">
                        <img id="certificateCanvas" src="{{ url('files/'.$edit->template_doc) }}" alt="Certificate Template" style="max-width:100%; height:auto; display:block; margin:0 auto; border-radius:8px;">
                        <div id="draggableOverlay" class="overlay-layer" style="position: absolute; top:0; left:0; width:100%; height:100%; pointer-events: none;">
                            <!-- Draggable items will be injected here -->
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-6 text-muted small"><i class="fa fa-lightbulb-o"></i> Use dummy images: Logo & Stamp are dummy placeholders until you upload.</div>
                        <div class="col-md-6 text-muted small"><i class="fa fa-qrcode"></i> QR Code dummy displayed as stylish placeholder.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery v1.12.4 -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<!-- jQuery UI v1.10.3 -->
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!-- Bootstrap v3 JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- Font Awesome 4.7 (compatible with Bootstrap 3) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap v3 CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

<style>
    .draggable-item {
        position: absolute;
        cursor: move;
        background: rgba(52, 152, 219, 0.9);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        pointer-events: auto;
        z-index: 1000;
        white-space: nowrap;
        border: 1px solid rgba(255,255,255,0.3);
        transition: all 0.1s ease;
    }
    .draggable-item:hover {
        background: rgba(41, 128, 185, 0.95);
        transform: scale(1.02);
    }
    .draggable-item img {
        max-width: 60px;
        max-height: 45px;
        border-radius: 5px;
        display: block;
    }
    .panel-heading {
        background-color: #f5f5f5;
        border-bottom: 1px solid #ddd;
    }
    .input-group-addon {
        min-width: 30px;
    }
    .tab-content {
        padding-top: 20px;
    }
</style>

<script>

    //SUBMIT FORM WITH A FILE
    function submitDesignTemplate(formId,formId2,submitUrl,reload_id,reloadUrl,token){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var form2 = document.forms.namedItem(formId2);
        var postVars = new FormData(form);
        var postVars2 = new FormData(form2);
        postVars.append('token',token);
        console.log($('#'+formId2).serialize());
        // Create a new FormData to hold merged data
        var mergedFormData = new FormData();

        // Append all entries from postVars
        postVars.forEach(function(value, key) {
            mergedFormData.append(key, value);
        });

        // Append all entries from postVars2
        postVars2.forEach(function(value, key) {
            mergedFormData.append(key, value);
        });

       //DISPLAY LOADING ICON
        overlayBody('block');

        sendRequestMediaForm(submitUrl,token,mergedFormData);
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
                    //resetForm(formId);
                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", successMessage, "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                if(reload_id != '' || reloadUrl != ''){
                    reloadContent(reload_id,reloadUrl);
                }

            }
        }

    }

</script>

<script>
    // ---------- Global state ----------
    let currentImageWidth = 0;
    let currentImageHeight = 0;
    let templateImgElement = null;

    var imageSrc = "{{ url('files/'.$edit->template_doc) }}";

    // Elements mapping for drag & text updates
    const elements = {
        certName: { id: 'certNameElem', label: 'Certificate Name', fieldId: 'cert_name', defaultText: 'John Doe', xInput: 'cert_name_pos_x', yInput: 'cert_name_pos_y', defaultX: 0.35, defaultY: 0.4 },
        logo: { id: 'logoElem', isImage: true, type: 'logo', fieldId: 'logo_upload', defaultImg: 'https://placehold.co/200x80/2c3e66/white?text=LOGO', xInput: 'logo_pos_x', yInput: 'logo_pos_y', defaultX: 0.1, defaultY: 0.1 },
        companyName: { id: 'companyElem', label: 'Company Name', fieldId: 'company_name', defaultText: 'Acme Global Inc.', xInput: 'company_name_pos_x', yInput: 'company_name_pos_y', defaultX: 0.3, defaultY: 0.2 },
        heading: { id: 'headingElem', label: 'Heading', fieldId: 'heading', defaultText: 'CERTIFICATE OF EXCELLENCE', xInput: 'heading_pos_x', yInput: 'heading_pos_y', defaultX: 0.5, defaultY: 0.55 },
        subHeading: { id: 'subHeadingElem', label: 'Sub Heading', fieldId: 'sub_heading', defaultText: 'Awarded for Outstanding Performance', xInput: 'sub_heading_pos_x', yInput: 'sub_heading_pos_y', defaultX: 0.5, defaultY: 0.62 },
        subHeadingTwo: { id: 'subHeadingTwoElem', label: 'Sub Heading Two', fieldId: 'sub_heading_two', defaultText: 'Year 2025', xInput: 'sub_heading_two_pos_x', yInput: 'sub_heading_two_pos_y', defaultX: 0.5, defaultY: 0.68 },
        certNumber: { id: 'certNumberElem', label: 'Cert Number Format', fieldId: 'cert_num_format', defaultText: 'CERT/DOC-', xInput: 'cert_num_format_pos_x', yInput: 'cert_num_format_pos_y', defaultX: 0.2, defaultY: 0.75 },
        certIdDisplay: { id: 'certIdDisplayElem', label: 'Cert ID Display', fieldId: 'cert_id_display', defaultText: 'Certificate ID: 2025-001', xInput: 'cert_id_display_pos_x', yInput: 'cert_id_display_pos_y', defaultX: 0.7, defaultY: 0.8 },
        stamp: { id: 'stampElem', isImage: true, type: 'stamp', fieldId: 'stamp_upload', defaultImg: 'https://placehold.co/150x150/6c757d/white?text=STAMP', xInput: 'stamp_pos_x', yInput: 'stamp_pos_y', defaultX: 0.8, defaultY: 0.85 },
        qrcodeDummy: { id: 'qrcodeElem', isImage: true, type: 'qrcode', defaultImg: 'https://placehold.co/120x120/198754/white?text=QR', xInput: 'qr_code_pos_x', yInput: 'qr_code_pos_y', defaultX: 0.75, defaultY: 0.6 }
    };

    let draggableInstances = {};

    function updateImageDimensions() {
        if (templateImgElement) {
            currentImageWidth = templateImgElement.naturalWidth;
            currentImageHeight = templateImgElement.naturalHeight;
            document.getElementById('imageDimensionsDisplay').innerHTML = '<i class="fa fa-ruler"></i> Width: ' + currentImageWidth + 'px | Height: ' + currentImageHeight + 'px';
        } else {
            document.getElementById('imageDimensionsDisplay').innerHTML = '<i class="fa fa-ruler"></i> Width: -- px | Height: -- px';
        }
    }

    function updateAllElementsPositionFromStored() {
        if (!templateImgElement || currentImageWidth === 0) return;
        for (let key in elements) {
            let elem = elements[key];
            let xInput = document.getElementById(elem.xInput);
            let yInput = document.getElementById(elem.yInput);
            if (xInput && yInput) {
                let xVal = parseFloat(xInput.value);
                let yVal = parseFloat(yInput.value);
                if (isNaN(xVal)) xVal = elem.defaultX * currentImageWidth;
                if (isNaN(yVal)) yVal = elem.defaultY * currentImageHeight;
                const containerDiv = document.getElementById('canvasContainer');
                const imgElement = document.getElementById('certificateCanvas');
                if (imgElement && containerDiv) {
                    const imgRect = imgElement.getBoundingClientRect();
                    const containerRect = containerDiv.getBoundingClientRect();
                    const relativeLeft = (xVal / currentImageWidth) * 100;
                    const relativeTop = (yVal / currentImageHeight) * 100;
                    const draggableDiv = document.getElementById(elem.id);
                    if (draggableDiv) {
                        draggableDiv.style.left = 'calc(' + relativeLeft + '% - ' + (draggableDiv.offsetWidth/2) + 'px)';
                        draggableDiv.style.top = 'calc(' + relativeTop + '% - ' + (draggableDiv.offsetHeight/2) + 'px)';
                        draggableDiv.style.position = 'absolute';
                        draggableDiv.style.transform = 'translate(0,0)';
                    }
                }
            }
        }
        renderDynamicTextAndImages();
    }

    function storeCoordinatesFromDrag(elemKey, leftPx, topPx, draggableDiv) {
        if (!templateImgElement || currentImageWidth === 0) return;
        const imgRect = templateImgElement.getBoundingClientRect();
        const containerRect = document.getElementById('canvasContainer').getBoundingClientRect();
        let relativeX = (leftPx + draggableDiv.offsetWidth/2) / imgRect.width;
        let relativeY = (topPx + draggableDiv.offsetHeight/2) / imgRect.height;
        let absoluteX = Math.round(relativeX * currentImageWidth);
        let absoluteY = Math.round(relativeY * currentImageHeight);
        absoluteX = Math.min(currentImageWidth, Math.max(0, absoluteX));
        absoluteY = Math.min(currentImageHeight, Math.max(0, absoluteY));
        let elem = elements[elemKey];
        if (elem.xInput) {
            let xField = document.getElementById(elem.xInput);
            let yField = document.getElementById(elem.yInput);
            if (xField) xField.value = absoluteX;
            if (yField) yField.value = absoluteY;
        }
    }

    function renderDynamicTextAndImages() {
        if (elements.certName) {
            const certNameDiv = document.getElementById('certNameElem');
            if (certNameDiv) certNameDiv.innerText = document.getElementById('cert_name').value || 'Certificate Name';
        }
        if (elements.companyName) {
            const compDiv = document.getElementById('companyElem');
            if (compDiv) compDiv.innerText = document.getElementById('company_name').value;
        }
        if (elements.heading) {
            const headingDiv = document.getElementById('headingElem');
            if (headingDiv) headingDiv.innerText = document.getElementById('heading').value;
        }
        if (elements.subHeading) {
            const subDiv = document.getElementById('subHeadingElem');
            if (subDiv) subDiv.innerText = document.getElementById('sub_heading').value;
        }
        if (elements.subHeadingTwo) {
            const subDiv2 = document.getElementById('subHeadingTwoElem');
            if (subDiv2) subDiv2.innerText = document.getElementById('sub_heading_two').value;
        }
        if (elements.certNumber) {
            const certNumDiv = document.getElementById('certNumberElem');
            if (certNumDiv) certNumDiv.innerText = document.getElementById('cert_num_format').value;
        }
        if (elements.certIdDisplay) {
            const certIdDiv = document.getElementById('certIdDisplayElem');
            if (certIdDiv) certIdDiv.innerText = document.getElementById('cert_id_display').value;
        }
        const logoFile = document.getElementById('logo_upload').files[0];
        if (logoFile && elements.logo) {
            const url = URL.createObjectURL(logoFile);
            const logoImg = document.getElementById('logoElem');
            if (logoImg && logoImg.tagName === 'IMG') logoImg.src = url;
        }
        const stampFile = document.getElementById('stamp_upload').files[0];
        if (stampFile && elements.stamp) {
            const url = URL.createObjectURL(stampFile);
            const stampImg = document.getElementById('stampElem');
            if (stampImg && stampImg.tagName === 'IMG') stampImg.src = url;
        }
    }

    function rebuildDraggables() {
        const overlay = document.getElementById('draggableOverlay');
        overlay.innerHTML = '';
        for (let key in elements) {
            let cfg = elements[key];
            let div = document.createElement('div');
            div.id = cfg.id;
            div.className = 'draggable-item';
            if (cfg.isImage) {
                let img = document.createElement('img');
                img.style.maxWidth = '80px';
                img.style.maxHeight = '60px';
                img.style.borderRadius = '8px';
                img.src = cfg.defaultImg;
                if (cfg.type === 'qrcode') img.src = 'https://placehold.co/100x100/0a58ca/white?text=QR+Code';
                div.appendChild(img);
            } else {
                div.innerText = cfg.defaultText;
            }
            overlay.appendChild(div);
        }
        
        $('.draggable-item').draggable({
            containment: '#canvasContainer',
            scroll: false,
            drag: function(event, ui) {
                let id = this.id;
                let elemKey = null;
                for (let k in elements) {
                    if (elements[k].id === id) {
                        elemKey = k;
                        break;
                    }
                }
                if (elemKey) {
                    let left = ui.position.left;
                    let top = ui.position.top;
                    storeCoordinatesFromDrag(elemKey, left, top, this);
                }
            },
            stop: function(event, ui) {
                let id = this.id;
                let elemKey = null;
                for (let k in elements) {
                    if (elements[k].id === id) {
                        elemKey = k;
                        break;
                    }
                }
                if (elemKey) storeCoordinatesFromDrag(elemKey, ui.position.left, ui.position.top, this);
            }
        });
        
        setTimeout(() => {
            if (templateImgElement) updateAllElementsPositionFromStored();
        }, 50);
    }

    function loadTemplateImage(file) {
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                templateImgElement = img;
                currentImageWidth = img.width;
                currentImageHeight = img.height;
                document.getElementById('certificateCanvas').src = e.target.result;
                updateImageDimensions();
                setTimeout(() => {
                    updateAllElementsPositionFromStored();
                    renderDynamicTextAndImages();
                }, 100);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Event listeners: form inputs update real-time text
    const textFields = ['cert_name','company_name','heading','sub_heading','sub_heading_two','cert_num_format','cert_id_display'];
    for (let i = 0; i < textFields.length; i++) {
        let field = textFields[i];
        document.getElementById(field).addEventListener('input', function() { renderDynamicTextAndImages(); });
    }
    document.getElementById('logo_upload').addEventListener('change', function() { renderDynamicTextAndImages(); });
    document.getElementById('stamp_upload').addEventListener('change', function() { renderDynamicTextAndImages(); });
    document.getElementById('template_image_upload').addEventListener('change', function(e) {
        if (e.target.files.length) loadTemplateImage(e.target.files[0]);
    });
    
    const allPosInputs = ['cert_name_pos_x','cert_name_pos_y','logo_pos_x','logo_pos_y','company_name_pos_x','company_name_pos_y','heading_pos_x','heading_pos_y','sub_heading_pos_x','sub_heading_pos_y','sub_heading_two_pos_x','sub_heading_two_pos_y','cert_num_format_pos_x','cert_num_format_pos_y','cert_id_display_pos_x','cert_id_display_pos_y','stamp_pos_x','stamp_pos_y'];
    for (let i = 0; i < allPosInputs.length; i++) {
        let id = allPosInputs[i];
        let el = document.getElementById(id);
        if(el) el.addEventListener('change', function() { updateAllElementsPositionFromStored(); });
    }
    
    window.addEventListener('load', function() {
        rebuildDraggables();
        const mockW = 3600, mockH = 2250;
        currentImageWidth = 3600;
        currentImageHeight = 2250;
        templateImgElement = { naturalWidth:3600, naturalHeight:2250, getBoundingClientRect:function(){ var img = document.getElementById('certificateCanvas'); return img ? img.getBoundingClientRect() : {width:3600,height:2250}; } };
        for(let key in elements){
            let elem = elements[key];
            let xField = document.getElementById(elem.xInput);
            let yField = document.getElementById(elem.yInput);
            if(xField && !xField.value) xField.value = Math.round(elem.defaultX * mockW);
            if(yField && !yField.value) yField.value = Math.round(elem.defaultY * mockH);
        }
        document.getElementById('certificateCanvas').src = imageSrc;
        updateImageDimensions();
        setTimeout(function() {
            updateAllElementsPositionFromStored();
            renderDynamicTextAndImages();
        }, 200);
    });
    
    window.addEventListener('resize', function() { updateAllElementsPositionFromStored(); });
</script>

@endsection