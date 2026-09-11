<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Job Title</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->job_title}}" class="form-control" name="job_title" placeholder="Job Title">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Job Type</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="job_type" >
                            <option value="{{$edit->job_type}}">{{$edit->job_type}}</option>
                            <option value="Temporary">Temporary</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Contract">Contract</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Job Status</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="job_status" >
                            <option value="{{$edit->job_status}}">{{\App\Helpers\Utility::statusDisplay($edit->job_status)}}</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-12">
                <b>Job Purpose</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control ckeditor" id="job_purpose_edit" name="job_purpose" placeholder="Job Purpose">{{$edit->job_purpose}}</textarea>
                        <script>
                            CKEDITOR.replace('job_purpose_edit');
                            CKEDITOR.config.height = 70;     // 500 pixels tall.
                        </script>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <b>Job Description</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control ckeditor" id="job_desc_edit" name="job_desc" placeholder="Job Description">{{$edit->job_desc}}</textarea>
                        <script>
                            CKEDITOR.replace('job_desc_edit');
                            CKEDITOR.config.height = 70;     // 500 pixels tall.
                        </script>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <b>Job Specification</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control ckeditor" id="job_spec_edit" name="job_spec" placeholder="Job Specification">{{$edit->job_spec}}</textarea>
                        <script>
                            CKEDITOR.replace('job_spec_edit');
                            CKEDITOR.config.height = 70;     // 500 pixels tall.
                        </script>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Job Location</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="location" placeholder="Job Location">{{$edit->location}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <b>Closing Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="datepicker form-control" value="{{$edit->closing_date}}" name="closing_date" placeholder="Closing Date" >
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Salary Range</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->salary_range}}" name="salary_range" placeholder="Salary Range">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Experience</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="experience" >
                            <option value="{{$edit->experience}}">{{$edit->experience}}</option>
                            @for($i=0;$i<=30;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Job Category</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="job_category" >
                            <option value="{{$edit->category_id}}">{{$edit->category->name}}</option>
                            @foreach($jobCategory as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <h3>Applicant Filtering/Matching Settings</h3>
        @php $keywords = !empty($edit->keywords) ? json_decode($edit->keywords, true) : []; @endphp
        <div class="row clearfix">
            <div class="col-sm-5">
                <b>Keywords</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class="form-control" name="keywords" placeholder="Keywords(e.g sales, procurement, marketing) use comma to separate keywords. Keywords are weighted from low to high in order of importance from left to right " >{{!empty($edit->keywords) ? implode(', ', $keywords) : ''}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Pass Score</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" value="{{$edit->weighted_score}}" class="form-control" name="weighted_score" placeholder="Enter Pass Score" >
                    </div>
                </div>
            </div>
            @php $actionTaken = ($edit->action_taken == 0) ? 'Do Not delete Disqualified Applicant' : 'Delete Disqualified Applicant'; @endphp
            <div class="col-sm-4">
                <b>Action Taken on Disqualified Applicant</b>
                <div class="form-group">
                    <div class="form-line">
                        <select type="text" class="form-control" name="action_taken" >
                            <option value="{{$edit->action_taken}}">{{$actionTaken}}</option>
                            <option value="1">Delete Disqualified Applicant</option>
                            <option value="0">Do Not delete Disqualified Applicant</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>