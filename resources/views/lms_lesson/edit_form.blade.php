<form name="editMainForm" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Title*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="title" value="{{$edit->name}}" placeholder="Title" required>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="edit_id" value="{{$edit->id}}" >

    </div>

</form>