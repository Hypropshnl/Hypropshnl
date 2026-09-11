<form name="" id="editMiniForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    Assign User
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->userDetail->firstname}} {{$edit->userDetail->lastname}}" autocomplete="off" id="select_user2" onkeyup="searchOptionList('select_user2','myUL2','{{url('default_select')}}','default_search','user2');" name="select_user" placeholder="Department Head">

                        <input type="hidden" value="{{$edit->assigned_user}}" class="user_class" name="assigned_user" id="user2" />
                    </div>
                </div>
                <ul id="myUL2" class="myUL"></ul>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>
