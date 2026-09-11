<form id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Course Title</label>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->title}}" name="title">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Location</label>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->location}}" name="location">
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
                                <option value="{{ $template->id }}" {{ $edit->cert_template_id == $template->id ? 'selected' : '' }}>{{ $template->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Name One</label>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name_one}}" name="name_one">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Name One Role</label>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name_one_role}}" name="name_one_role">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Name Two</label>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name_two}}" name="name_two">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Name Two Role</label>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name_two_role}}" name="name_two_role">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Name One Signature</label>
                    <div class="form-line">
                        <input type="file" class="form-control" name="name_one_sign">
                    </div>
                    @if(!empty($edit->name_one_sign))
                        <p class="help-block"><a href="{{ url('files/'.$edit->name_one_sign) }}" target="_blank">Current file</a></p>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Name Two Signature</label>
                    <div class="form-line">
                        <input type="file" class="form-control" name="name_two_sign">
                    </div>
                    @if(!empty($edit->name_two_sign))
                        <p class="help-block"><a href="{{ url('files/'.$edit->name_two_sign) }}" target="_blank">Current file</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}">
</form>
