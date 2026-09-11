<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="request_description" placeholder="Request Description">{{$edit->req_desc}}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        @if($edit->hr_accesible == \App\Helpers\Utility::LOAN_REQUEST || $edit->hr_accessible == \App\Helpers\Utility::SALARY_ADVANCE_REQUEST)
                            <select  class="form-control" name="request_category" >
                                <option value="{{$edit->req_cat}}" selected>{{$edit->requestCat->request_name}}</option>
                            </select>
                        @else
                            <select  class="form-control" name="request_category" >
                                <option value="{{$edit->req_cat}}" selected>{{$edit->requestCat->request_name}}</option>
                                @foreach($reqCat as $ap)
                                    <option value="{{$ap->id}}">{{$ap->request_name}}</option>
                                @endforeach
                            </select>
                           
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" onchange="checkProject('request_type_edit','project_id_edit');" id="request_type_edit" name="request_type" >
                            <option value="{{$edit->req_type}}" selected>{{$edit->requestType->request_type}}</option>
                            @foreach($reqType as $ap)
                                <option value="{{$ap->id}}">{{$ap->request_type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            
            @php $display = ($edit->req_type == \App\Helpers\Utility::PROJECT_REQUEST_TYPE) ? 'display:block' : 'display:none'; @endphp
            <div class="col-sm-4" id="project_id_edit" style="{{$display}}">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control"  id="" name="project" >
                            <option value="{{$edit->proj_id}}" selected>{{$edit->project->project_name}}</option>
                            @foreach($project as $ap)
                                <option value="{{$ap->project->id}}">{{$ap->project->project_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clear-fix">
            
            @if (!empty($edit->transaction_type) && $edit->transaction_type == 1)
                
                <div class="col-sm-4" id="">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$edit->mrData->mr_number}}" autocomplete="off" id="select_mr_edit" onkeyup="searchOptionList('select_mr_edit','myUL13','{{url('default_select')}}','search_my_mr_select','mr_edit');" name="select_user" placeholder="Select Material Request">

                            <input type="hidden" value="{{$edit->material_request_id}}" class="user_class" name="material_request" id="mr_edit" />
                        </div>
                    </div>
                    <ul id="myUL13" class="myUL"></ul>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" value="{{$edit->amount}}" class="form-control" name="amount" placeholder="Amount">
                        </div>
                    </div>
                </div>

            @else
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" value="International Transaction" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4" id="">
                    <div class="form-group">
                        <div class="form-line">
                            <select  class="form-control"  id="" name="currency" >
                                <option value="{{$edit->currency_id}}">{{$edit->currency->code}}({{$edit->currency->currency}})</option>
                                @foreach($currencies as $ap)
                                    <option value="{{$ap->id}}">{{$ap->code}}({{$ap->currency}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" value="{{$edit->foreign_amount}}" class="form-control" name="amount" placeholder="Amount">
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>