<form name="editMainForm" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="container body">
        
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="name" value="{{$edit->name}}" placeholder="Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>code</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="code" value="{{$edit->code}}" placeholder="Code" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="department" >
                            <option value="{{$edit->dept}}">{{$edit->department->dept_name}}</option>
                            @foreach($dept as $de)
                                <option value="{{$de->id}}">{{$de->dept_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Store Manager</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->storeManager->firstname}} {{$edit->storeManager->lastname}}" autocomplete="off" id="select_user1" onkeyup="searchOptionList('select_user1','myUL12','{{url('default_select')}}','default_search','user1');" name="select_user" placeholder="Select User">
                        
                        <input type="hidden" class="user_class" name="store_manager" id="user1" />
                    </div>
                </div>
                <ul id="myUL12" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <b>Address/Location</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="address_location" placeholder="Address/Location">{{$edit->address}}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <input type="hidden" name="edit_id" value="{{$edit->id}}" >

    </div>

</form>