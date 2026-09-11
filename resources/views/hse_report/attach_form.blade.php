<p>
    {!!$edit->details!!}
</p>

<form name="" id="attachForm" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">                               

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="report_type" >
                            @if($edit->report_type != 0)
                            <option value="{{$edit->report_type}}">{{\App\Helpers\Utility::hseReportType($edit->report_type)}}</option>
                            @else
                            <option value="0">Report Type</option>
                            @endif
                            @foreach(\App\Helpers\Utility::HSE_REPORT_TYPE as $key => $var)
                                <option value="{{$key}}">{{$var}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="source_type" >
                            <option value="{{$edit->source_id}}">{{$edit->source->source_name}}</option>
                            @foreach($sourceType as $ap)
                                <option value="{{$ap->id}}">{{$ap->source_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="response_status" >
                            <option value="{{$edit->response_status}}">Report Status</option>
                            @foreach(\App\Helpers\Utility::TICKET_STATUS as $key => $var)
                                <option value="{{$key}}">{{$var}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">

            <div class="">
                <div class="form-group">
                    <h5>Causes</h5>
                    <div class="form-line">
                        <textarea type="text" id="causes" class="form-control " name="causes">{{$edit->response}}</textarea>
                        <script>
                            CKEDITOR.replace('causes');
                        </script>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="form-group">
                <h5>Proposed Remedial Action</h5>
                    <div class="form-line">
                        <textarea type="text"  class="form-control " name="remedial_action">{{$edit->remedial_actions}}</textarea>                                           
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row">
            <h2>Reviewed By</h2>
        </div>
        <div class="row clearfix">                            
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="reviewed_by" value="{{$edit->reviewed_by}}" placeholder="Reviewed By">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control datepicker"  name="review_date" value="{{$edit->reviewed_at}}" placeholder="Review Date">
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <h2>Approved By</h2>
        </div>
        @php $disabled = (!empty($edit->reviewed_by)) ? '' : 'disabled'; @endphp
        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" {{$disabled}} name="approved_by" value="{{$edit->approved_by}}" placeholder="Approved By">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <input type="date" class="form-control datepicker" {{$disabled}} name="approve_date" value="{{$edit->approved_at}}" placeholder="Approve Date">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>


