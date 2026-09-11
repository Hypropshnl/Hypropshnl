@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="letterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Cover Letter</h4>
                </div>
                <div class="modal-body" id="letter_content">

                </div>
                <div class="modal-footer">

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
                        Job Applicants
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li class="dropdown">
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('job_item/'.$jobId); ?>',
                                    '<?php echo url('delete_applicants'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                        <ul class="dropdown-menu pull-right">
                            @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                        </ul>
                        </li>

                    </ul>
                </div>
                <div class="container body">
                    <form name="import_excel" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="from_date" placeholder="From e.g 2019-02-22">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="to_date" placeholder="To e.g 2019-04-21">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="{{$jobId}}" name="job" id="job_item" />
                                <input type="hidden" name="job_category_id" id="job_category_id" value="" />

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" multiple name="experience[]" >
                                                <option selected value="">Select Experience (Multiple)</option>
                                                @for($i=0;$i<=30;$i++)
                                                    <option value="{{$i}}">{{$i}} yr(s)</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="min_match_score" >
                                                <option selected value="0">Min Match Score</option>
                                                @for($i=0;$i<=100;$i+=10)
                                                    <option value="{{$i}}">{{$i}}%</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick"  name="max_match_score" >
                                                <option selected value="100">Max Match Score</option>
                                                @for($i=0;$i<=100;$i+=10)
                                                    <option value="{{$i}}">{{$i}}%</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clear-fix">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button id="search_applicants" class="form-control btn btn-info col-sm-8" type="button" onclick="searchUsingDate('searchMainForm','<?php echo url('search_job_applicants'); ?>','reload_data',
                                                '<?php echo url('job_item/'.$jobId); ?>','<?php echo csrf_token(); ?>','start_date','end_date')">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>
                <div class="body table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Cover Letter</th>
                            <th>Preview</th>
                            <th>Download CV</th>
                            <th>Job Title</th>
                            <th>Fullname</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Experience</th>
                            <th>Match Score</th>
                            <th>Created at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <td>
                                <a style="cursor: pointer;" id="cover_letter{{$data->id}}" data-val="{{$data->cover_letter}}" onclick="viewLetter('letterModal','letter_content','cover_letter{{$data->id}}')">View Cover Letter</a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                             <td>
                                <button id="file_{{$data->id}}" class="btn btn-outline-primary btn-view"
                                        data-file-url="{{ asset('files/'.$data->cv_file) }}" onclick="previewFile('<?php echo 'file_'.$data->id; ?>');">
                                    <i class="fa fa-eye me-2"></i>View File
                                </button>
                            </td>
                            <td><a target="_blank" href="<?php echo URL::to('download_cv_attachment?file='); ?>{{$data->cv_file}}">
                                    <i class="fa fa-files-o fa-2x"></i>Download
                                </a>
                            </td>
                            <td>{{$data->job->job_title}}</td>
                            <td>{{$data->firstname}} {{$data->lastname}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->address}}</td>
                            <td>{{$data->experience}} yrs</td>
                            <td>{{$data->match_score}}%</td>
                            <td>{{date('d M Y',strtotime($data->created_at))}}</td>

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

    <!-- #END# Bordered Table -->

<script>

    function viewLetter(modalId,divId,letterId){
        $('#'+modalId).modal('show');
        var coverLetter = $('#'+letterId).attr('data-val');
        $('#'+divId).html(coverLetter);
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

    <script>
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection