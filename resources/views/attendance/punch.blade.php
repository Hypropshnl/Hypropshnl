@extends('layouts.app')

@section('content')

   
    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Attendance Punch In/Out (Ensure your location is enabled/allowed)
                    </h2>
                    <ul class="header-dropdown m-r--5">
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
                <div class="cam-container " id="reload_data">
                     <div class="body">
                        <div class="header">
                            <h1>Webcam Photo Capture</h1>
                            <p>Take a photo to punch In/Out</p>
                        </div>
                        
                        <div class="content">
                            <div class="camera-section">
                                <div class="camera-container">
                                    <video id="camera-video" autoplay playsinline style="display: none;"></video>
                                    <canvas id="camera-canvas"></canvas>
                                    <div class="placeholder" id="placeholder">
                                        <span style="font-size: 60px;">📷</span>
                                        <p>Camera feed will appear here</p>
                                    </div>
                                </div>
                                
                                <div class="camera-controls">
                                    <button id="startCamera" class="btn btn-primary">
                                        📷 Start Camera
                                    </button>
                                    <button id="snapPhoto" class="btn btn-success" disabled>
                                        📸 Take Photo
                                    </button>
                                    <button id="resetCamera" class="btn btn-danger" disabled>
                                        🔄 Reset
                                    </button>
                                </div>
                            </div>
                            
                            <div class="note-section">
                                <label for="note">Add a note to your photo:</label>
                                <textarea id="note" cols="50" placeholder="Enter your note here..."></textarea>
                            </div>
                            
                            <div class="preview-section">
                                <h3>Photo Preview</h3>
                                <img id="photoPreview" alt="Captured photo preview">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button id="savePhoto" class="btn btn-primary" style="width: 100%;" disabled>
                                        💾 Punch In
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button id="savePhotoPunchOut" class="btn btn-primary" style="width: 100%;" disabled>
                                        💾 Punch Out
                                    </button>
                                </div>
                            </div>
                            
                            
                            <div class="camera-loading" id="loading">
                                <div class="camera-spinner"></div>
                                <p>Saving your photo...</p>
                            </div>
                            
                            <div id="statusMessage" class="status"></div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->



<script>
     $(document).ready(function() {
            // DOM elements using jQuery
            var video = document.getElementById('camera-video');
            var canvas = document.getElementById('camera-canvas');
            var context = canvas.getContext('2d');
            var photoPreview = $('#photoPreview');
            var placeholder = $('#placeholder');
            var startCameraBtn = $('#startCamera');
            var snapPhotoBtn = $('#snapPhoto');
            var resetCameraBtn = $('#resetCamera');
            var savePhotoBtn = $('#savePhoto');
            var savePhotoPunchOutBtn = $('#savePhotoPunchOut');
            var noteTextarea = $('#note');
            var statusMessage = $('#statusMessage');
            var loadingIndicator = $('#loading');
            
            var stream = null;
            var photoDataUrl = null;
            
            var coordinates = {};
            navigator.geolocation.getCurrentPosition(function(pos) {

                let lat = pos.coords.latitude;
                let lng = pos.coords.longitude;
                coordinates = {
                    'lat':lat,
                    'lng':lng
                };
            });

            // Start camera function
            startCameraBtn.on('click', function() {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    showStatus('Camera API not supported in this browser', 'error');
                    return;
                }

                // Show loading state
                startCameraBtn.prop('disabled', true).text('Starting Camera...');

                navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'user',
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }, 
                    audio: false 
                })
                .then(function(mediaStream) {
                    stream = mediaStream;
                    
                    // Set video source and show it
                    video.srcObject = stream;
                    $(video).show();
                    placeholder.hide();
                    
                    // Enable/disable buttons
                    startCameraBtn.prop('disabled', true).text('Camera Started');
                    snapPhotoBtn.prop('disabled', false);
                    resetCameraBtn.prop('disabled', false);
                    
                    showStatus('Camera started successfully!', 'success');
                    
                    // Wait for video to be loaded and ready
                    video.onloadedmetadata = function() {
                        console.log('Video ready, dimensions:', video.videoWidth, 'x', video.videoHeight);
                    };
                })
                .catch(function(err) {
                    console.error('Error accessing camera:', err);
                    var errorMessage = 'Error accessing camera: ';
                    
                    if (err.name === 'NotAllowedError') {
                        errorMessage += 'Camera permission denied.';
                    } else if (err.name === 'NotFoundError') {
                        errorMessage += 'No camera found.';
                    } else if (err.name === 'NotSupportedError') {
                        errorMessage += 'Camera not supported. Please use HTTPS or localhost.';
                    } else {
                        errorMessage += err.message;
                    }
                    
                    showStatus(errorMessage, 'error');
                    startCameraBtn.prop('disabled', false).text('📷 Start Camera');
                });
            });

            // Take photo function - FIXED VERSION
            snapPhotoBtn.on('click', function() {
                if (!stream) {
                    showStatus('No camera stream available', 'error');
                    return;
                }

                // Check if video is ready and has valid dimensions
                if (!video.videoWidth || !video.videoHeight) {
                    showStatus('Video not ready yet. Please wait...', 'error');
                    return;
                }

                try {
                    // Set canvas dimensions to match video
                    var videoWidth = video.videoWidth;
                    var videoHeight = video.videoHeight;
                    
                    console.log('Setting canvas dimensions:', videoWidth, 'x', videoHeight);
                    
                    // Set canvas dimensions
                    canvas.width = videoWidth;
                    canvas.height = videoHeight;
                    
                    // Draw current video frame to canvas
                    context.drawImage(video, 0, 0, videoWidth, videoHeight);
                    
                    // Convert canvas to data URL (JPEG format with quality 0.8)
                    photoDataUrl = canvas.toDataURL('image/jpeg', 0.8);
                    
                    // Display the captured photo preview
                    photoPreview.attr('src', photoDataUrl).show();
                    
                    // Enable save button
                    savePhotoBtn.prop('disabled', false);
                    savePhotoPunchOutBtn.prop('disabled', false);
                    
                    showStatus('Photo captured successfully! Ready to save.', 'success');
                    
                } catch (error) {
                    console.error('Error capturing photo:', error);
                    showStatus('Error capturing photo: ' + error.message, 'error');
                }
            });

            // Reset camera function
            resetCameraBtn.on('click', function() {
                resetCamera();
            });

            // Save photo function
            savePhotoBtn.on('click', function() {
                punchIn();
            });
            savePhotoPunchOutBtn.on('click', function() {
                punchOut();
            });

            // SEND PUNCH IN DATA TO BACKEND
            function punchIn() {
                if (!photoDataUrl) {
                    showStatus('No photo to save!', 'error');
                    return;
                }

                var note = noteTextarea.val().trim();
                // if (!note) {
                //     showStatus('Please add a note to your photo!', 'error');
                //     return;
                // }

                //photo Data
                const photoDataURLA = $('#photoPreview').attr('src');
                // Convert base64 to blob for better performance with large images
                const blob = dataURLtoBlob(photoDataURLA);

                // Show loading indicator
                loadingIndicator.show();
                savePhotoBtn.prop('disabled', true);
                snapPhotoBtn.prop('disabled', true);

                // Prepare the data
                var formData = new FormData();
                //formData.append('photo', photoDataUrl);
                formData.append('photo', blob, 'captured_photo_' + Date.now() + '.jpg');
                formData.append('comment', note);
                formData.append('coordinates',JSON.stringify(coordinates));
                
                // AJAX request to Laravel backend
                $.ajax({
                    url: "{{ url('create_attendance_record') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
                    success: function(response) {
                        loadingIndicator.hide();

                        var message2 = response.message2;
                        if(message2 == 'fail'){

                            //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                            var serverError = phpValidationError(response.message);

                            var messageError = swalFormError(serverError);
                            swal("Error",messageError, "error");
                            showStatus('Error: ' + (response.message || 'Unknown error'), 'error');
                            savePhotoBtn.prop('disabled', false);
                            snapPhotoBtn.prop('disabled', false);

                        }else if(message2 == 'saved'){
                            //RESET FORM
                            //resetForm(formId);
                            var successMessage = swalSuccess('Data saved successfully');
                            swal("Success!", "Data saved successfully!", "success");
                            showStatus('Photo saved successfully! Photo ID: ' + response.photo_id, 'success');
                            resetForm();

                        }else if(message2 == 'token_mismatch'){
                            showStatus('Error: ' + (response.message || 'Unknown error'), 'error');
                            savePhotoBtn.prop('disabled', false);
                            snapPhotoBtn.prop('disabled', false);
                            location.reload();

                        }else {
                            showStatus('Error: ' + (response.message || 'Unknown error'), 'error');
                            savePhotoBtn.prop('disabled', false);
                            snapPhotoBtn.prop('disabled', false);
                            var infoMessage = swalWarningError(message2);
                            swal("Warning!", infoMessage, "warning");
                        }

                    },
                    error: function(xhr, status, error) {
                        loadingIndicator.hide();
                        savePhotoBtn.prop('disabled', false);
                        snapPhotoBtn.prop('disabled', false);
                        
                        var errorMsg = 'Error saving photo: ';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg += xhr.responseJSON.message;
                        } else if (xhr.status === 422) {
                            // Validation errors
                            var errors = xhr.responseJSON.errors;
                            errorMsg = 'Validation errors: ' + Object.values(errors).join(', ');
                        } else if (xhr.status === 419) {
                            errorMsg += 'CSRF token mismatch. Please refresh the page.';
                        } else {
                            errorMsg += error;
                        }
                        
                        showStatus(errorMsg, 'error');
                        console.error('AJAX Error:', xhr.responseText);
                    }
                });
            }

            // SEND PUNCH IN DATA TO BACKEND
            function punchOut() {
                if (!photoDataUrl) {
                    showStatus('No photo to save!', 'error');
                    return;
                }

                var note = noteTextarea.val().trim();
                // if (!note) {
                //     showStatus('Please add a note to your photo!', 'error');
                //     return;
                // }

                //photo Data
                const photoDataURLA = $('#photoPreview').attr('src');
                // Convert base64 to blob for better performance with large images
                const blob = dataURLtoBlob(photoDataURLA);

                // Show loading indicator
                loadingIndicator.show();
                savePhotoPunchOutBtn.prop('disabled', true);
                snapPhotoBtn.prop('disabled', true);

                // Prepare the data
                var formData = new FormData();
                //formData.append('photo', photoDataUrl);
                formData.append('photo', blob, 'captured_photo_' + Date.now() + '.jpg');
                formData.append('comment', note);
                formData.append('coordinates',JSON.stringify(coordinates));
                
                // AJAX request to Laravel backend
                $.ajax({
                    url: "{{ url('edit_attendance_record') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
                    success: function(response) {
                        loadingIndicator.hide();

                        var message2 = response.message2;
                        if(message2 == 'fail'){

                            //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                            var serverError = phpValidationError(response.message);

                            var messageError = swalFormError(serverError);
                            swal("Error",messageError, "error");
                            showStatus('Error: ' + (response.message || 'Unknown error'), 'error');
                            savePhotoPunchOutBtn.prop('disabled', false);
                            snapPhotoBtn.prop('disabled', false);

                        }else if(message2 == 'saved'){
                            //RESET FORM
                            //resetForm(formId);
                            var successMessage = swalSuccess('Data saved successfully');
                            swal("Success!", "Data saved successfully!", "success");
                            showStatus('Photo saved successfully! Photo ID: ' + response.photo_id, 'success');
                            resetForm();

                        }else if(message2 == 'token_mismatch'){
                            showStatus('Error: ' + (response.message || 'Unknown error'), 'error');
                            savePhotoPunchOutBtn.prop('disabled', false);
                            snapPhotoBtn.prop('disabled', false);
                            location.reload();

                        }else {
                            showStatus('Error: ' + (response.message || 'Unknown error'), 'error');
                            savePhotoPunchOutBtn.prop('disabled', false);
                            snapPhotoBtn.prop('disabled', false);
                            var infoMessage = swalWarningError(message2);
                            swal("Warning!", infoMessage, "warning");
                        }

                    },
                    error: function(xhr, status, error) {
                        loadingIndicator.hide();
                        savePhotoPunchOutBtn.prop('disabled', false);
                        snapPhotoBtn.prop('disabled', false);
                        
                        var errorMsg = 'Error saving photo: ';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg += xhr.responseJSON.message;
                        } else if (xhr.status === 422) {
                            // Validation errors
                            var errors = xhr.responseJSON.errors;
                            errorMsg = 'Validation errors: ' + Object.values(errors).join(', ');
                        } else if (xhr.status === 419) {
                            errorMsg += 'CSRF token mismatch. Please refresh the page.';
                        } else {
                            errorMsg += error;
                        }
                        
                        showStatus(errorMsg, 'error');
                        console.error('AJAX Error:', xhr.responseText);
                    }
                });
            }

             // Utility function to convert base64 to blob
            function dataURLtoBlob(dataURL) {
                const arr = dataURL.split(',');
                const mime = arr[0].match(/:(.*?);/)[1];
                const bstr = atob(arr[1]);
                let n = bstr.length;
                const u8arr = new Uint8Array(n);
                
                while (n--) {
                    u8arr[n] = bstr.charCodeAt(n);
                }
                
                return new Blob([u8arr], { type: mime });
            }

            // Reset camera function
            function resetCamera() {
                if (stream) {
                    stream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                    stream = null;
                }
                
                $(video).hide();
                placeholder.show();
                photoPreview.hide();
                photoDataUrl = null;
                
                startCameraBtn.prop('disabled', false).text('📷 Start Camera');
                snapPhotoBtn.prop('disabled', true);
                resetCameraBtn.prop('disabled', true);
                savePhotoBtn.prop('disabled', true);
                savePhotoPunchOutBtn.prop('disabled', true);
                
                showStatus('Camera reset. You can start again.', 'success');
            }

            // Reset form after successful save
            function resetForm() {
                noteTextarea.val('');
                photoDataUrl = null;
                savePhotoBtn.prop('disabled', true);
                savePhotoPunchOutBtn.prop('disabled', true);
                snapPhotoBtn.prop('disabled', false);
                photoPreview.hide();
            }

            // Show status message
            function showStatus(message, type) {
                statusMessage.removeClass('success error')
                    .addClass(type)
                    .text(message)
                    .show();
                
                // Auto-hide after 5 seconds
                setTimeout(function() {
                    statusMessage.fadeOut();
                }, 5000);
            }

            // Handle page unload to cleanup camera
            $(window).on('beforeunload', function() {
                if (stream) {
                    stream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                }
            });
        });
</script>

@endsection