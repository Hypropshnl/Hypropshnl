@extends('layouts.app')

@section('content')


    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_bin'); ?>','reload_data',
                            '<?php echo url('bin'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Geo Tagging
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('geo_tag'); ?>',
                                    '<?php echo url('delete_geo_tag'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
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
                

                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class="active"><a href="#home" data-toggle="tab">HOME</a></li>
                        <li role="presentation"><a href="#tags" data-toggle="tab">Tags</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                            <div class="body" >
                                <div class="row clearfix">
                                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <b>Tag Name/Location</b>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="tag_name" placeholder="Tag Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                Description
                                                <div class="form-line">
                                                    <textarea class="form-control" name="tag_description" placeholder="Description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="app-container">
                                    <div class="map-section">
                                        <div class="card">
                                            <h2>Interactive Map</h2>
                                            <div class="search-container">
                                                <input type="text" id="search-input" placeholder="Search for a location...">
                                                <button id="search-button">Search</button>
                                            </div>
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="controls-section">
                                        <div class="card">
                                            <h2>Coordinates</h2>
                                            <div class="coordinates-list" id="coordinates-list">
                                                <p>No coordinates added yet. Click on the map to add points.</p>
                                            </div>
                                            
                                            <div class="button-group">
                                                <button id="clear-markers" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i> Clear All Markers
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="card">
                                            <h2>Location Check</h2>
                                            <p>Check if your current location is within the polygon area.</p>
                                            <button id="check-location" class="btn btn-primary">
                                                <i class="fas fa-location-arrow"></i> Check My Location
                                            </button>
                                            
                                            <div id="location-status" class="status">
                                                Click the button to check your location
                                            </div>
                                        </div>
                                        
                                        <div class="card">
                                            <h2>Save Coordinates</h2>
                                            <p>Save the polygon coordinates to the database.</p>
                                            <button id="save-coordinates" class="btn btn-success">
                                                <i class="fas fa-save"></i> Save Coordinates
                                            </button>
                                        </div>
                                        
                                        <div class="instructions">
                                            <h3>How to use:</h3>
                                            <ol>
                                                <li>Search for a location or click directly on the map to place markers</li>
                                                <li>Place exactly 4 markers to define a polygon area</li>
                                                <li>Click "Check My Location" to verify if you're inside the polygon</li>
                                                <li>Click "Save Coordinates" to store the polygon in the database</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tags">
                            <div class="body table-responsive" id="reload_data">
                                <table class="table table-bordered table-hover table-striped" id="main_table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                                name="check_all" class="" />

                                        </th>

                                        <th>Tag Name</th>
                                        <th>Description</th>
                                        <th>Created by</th>
                                        <th>Updated by</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($mainData as $data)
                                        <tr>
                                            <td scope="row">
                                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                            </td>
                                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                            <td>{{$data->tag_name}}</td>
                                            <td>{{$data->desc}}</td>
                                            <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                            <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                                            <td>{{$data->created_at}}</td>
                                            <td>{{$data->updated_at}}</td>
                                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class=" pagination pull-right">
                                    {!! $mainData->render() !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

 <!-- Include Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
   <!-- Include Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAANKKFTcD-XPySiIy7LCf59FwarFlapI4&libraries=geometry,places&callback=initMap" async defer></script>
 
    <script>
        // Global variables
        let map;
        let markers = [];
        let polygon = null;
        let geocoder;
        let autocomplete;
        
        // Initialize the map
        function initMap() {
            // Default center (New York)
            const defaultCenter = { lat: 40.7128, lng: -74.0060 };
            
            // Create the map
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: defaultCenter,
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true
            });
            
            // Initialize geocoder
            geocoder = new google.maps.Geocoder();
            
            // Initialize autocomplete for search
            const input = document.getElementById('search-input');
            autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            
            // Add click event listener to the map
            map.addListener('click', function(event) {
                if (markers.length < 4) {
                    addMarker(event.latLng);
                } else {
                    alert('Maximum of 4 markers allowed. Clear existing markers to add new ones.');
                }
            });
            
            // Search button event listener
            document.getElementById('search-button').addEventListener('click', function() {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    map.setCenter(place.geometry.location);
                    map.setZoom(15);
                } else {
                    geocodeAddress(autocomplete.get('query'));
                }
            });
            
            // Enter key for search
            document.getElementById('search-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('search-button').click();
                }
            });
            
            // Clear markers button
            document.getElementById('clear-markers').addEventListener('click', clearMarkers);
            
            // Check location button
            document.getElementById('check-location').addEventListener('click', checkUserLocation);
            
            // Save coordinates button
            document.getElementById('save-coordinates').addEventListener('click', saveCoordinates);
            
            // Update coordinates list initially
            updateCoordinatesList();
        }
        
        // Add a marker to the map
        function addMarker(location) {
            const marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true,
                label: (markers.length + 1).toString()
            });
            
            markers.push(marker);
            
            // Update polygon when marker is added
            updatePolygon();
            
            // Update coordinates list
            updateCoordinatesList();
            
            // Add drag event to update polygon when marker is moved
            marker.addListener('drag', updatePolygon);
        }
        
        // Update the polygon based on markers
        function updatePolygon() {
            // Remove existing polygon
            if (polygon) {
                polygon.setMap(null);
            }
            
            // Create new polygon if we have at least 3 markers
            if (markers.length >= 3) {
                const path = markers.map(marker => marker.getPosition());
                
                polygon = new google.maps.Polygon({
                    paths: path,
                    strokeColor: '#1a2a6c',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#1a2a6c',
                    fillOpacity: 0.35,
                    map: map
                });
            }
        }
        
        // Clear all markers
        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
            
            if (polygon) {
                polygon.setMap(null);
                polygon = null;
            }
            
            updateCoordinatesList();
            
            // Reset location status
            document.getElementById('location-status').textContent = 'Click the button to check your location';
            document.getElementById('location-status').className = 'status';
        }
        
        // Update the coordinates list display
        function updateCoordinatesList() {
            const coordinatesList = document.getElementById('coordinates-list');
            
            if (markers.length === 0) {
                coordinatesList.innerHTML = '<p>No coordinates added yet. Click on the map to add points.</p>';
                return;
            }
            
            let html = '';
            markers.forEach((marker, index) => {
                const lat = marker.getPosition().lat().toFixed(6);
                const lng = marker.getPosition().lng().toFixed(6);
                html += `
                    <div class="coordinate-item">
                        <span>Point(Lat,Long) ${index + 1}</span>
                        <span>${lat}, ${lng}</span>
                    </div>
                `;
            });
            
            coordinatesList.innerHTML = html;
        }
        
        // Geocode an address
        function geocodeAddress(address) {
            geocoder.geocode({ 'address': address }, function(results, status) {
                if (status === 'OK') {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(15);
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
        
        // Check if user's location is within the polygon
        function checkUserLocation() {
            if (markers.length < 3) {
                alert('Please place at least 3 markers to define a polygon area.');
                return;
            }
            
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by this browser.');
                return;
            }
            
            const statusElement = document.getElementById('location-status');
            statusElement.textContent = 'Getting your location...';
            statusElement.className = 'status';
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    
                    // Create a polygon path from markers
                    const polygonPath = markers.map(marker => marker.getPosition());
                    
                    // Check if the user's location is inside the polygon
                    const isInside = google.maps.geometry.poly.containsLocation(
                        new google.maps.LatLng(userLocation.lat, userLocation.lng),
                        new google.maps.Polygon({ paths: polygonPath })
                    );
                    
                    // Update status
                    if (isInside) {
                        statusElement.textContent = 'Your location is INSIDE the polygon area.';
                        statusElement.className = 'status inside';
                    } else {
                        statusElement.textContent = 'Your location is OUTSIDE the polygon area.';
                        statusElement.className = 'status outside';
                    }
                    
                    // Add a marker for user's location
                    new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: 'Your Location',
                        icon: {
                            url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                        }
                    });
                },
                function(error) {
                    let errorMessage = 'Error getting your location: ';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage += 'User denied the request for Geolocation.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage += 'Location information is unavailable.';
                            break;
                        case error.TIMEOUT:
                            errorMessage += 'The request to get user location timed out.';
                            break;
                        case error.UNKNOWN_ERROR:
                            errorMessage += 'An unknown error occurred.';
                            break;
                    }
                    
                    statusElement.textContent = errorMessage;
                    statusElement.className = 'status outside';
                }
            );
        }
        
        // Save coordinates to backend
        function saveCoordinates() {
            if (markers.length < 3) {
                alert('Please place at least 3 markers to define a polygon area.');
                return;
            }
            
            // Prepare coordinates data
            const coordinates = markers.map(marker => {
                return {
                    lat: marker.getPosition().lat(),
                    lng: marker.getPosition().lng()
                };
            });

            var inputVars = $('#createMainForm').serialize();
            var postVars = inputVars+'&_token='+CSRF_TOKEN+'&coordinates='+JSON.stringify(coordinates);
            
            // In a real application, you would send this data to your backend
            // For this demo, we'll just show a success message
            //alert('Coordinates saved successfully! In a real application, these would be sent to the backend.'+postVars);
            
            // Example of how to send data to Laravel backend using AJAX
            
            $.ajax({
                url: "{{ url('create_geo_tag') }}",
                method: 'POST',
                data: postVars,
                success: function(response) {
                    //swal("Success!", "Coordinates saved successfully!", "success");
                    var message2 = response.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(response.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){
                        //RESET FORM
                        //resetForm(formId);
                    var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                        reloadContent("reload_data","{{ url('geo_tag') }}");

                    }else if(message2 == 'token_mismatch'){

                        location.reload();

                    }else {
                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");
                    }


                },
                error: function(xhr, status, error) {
                    swal("Warning!", "Error saving coordinates", "warning");
                }
            });
            
        }
        
        // Function to check if a point is within the polygon (for backend)
        // This would be implemented in Laravel PHP
        /*
        function isPointInPolygon($point, $polygon) {
            $inside = false;
            $x = $point['lat'];
            $y = $point['lng'];
            
            for ($i = 0, $j = count($polygon) - 1; $i < count($polygon); $j = $i++) {
                $xi = $polygon[$i]['lat'];
                $yi = $polygon[$i]['lng'];
                $xj = $polygon[$j]['lat'];
                $yj = $polygon[$j]['lng'];
                
                $intersect = (($yi > $y) != ($yj > $y))
                    && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
                
                if ($intersect) {
                    $inside = !$inside;
                }
            }
            
            return $inside;
        }
        */
    </script>

<script>
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