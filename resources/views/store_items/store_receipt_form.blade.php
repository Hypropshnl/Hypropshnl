<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        @foreach($mainData as $edit)
            <div class="row clearfix">
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-line">
                            Store -> {{$edit->storeDetail->name}}({{$edit->storeDetail->code}})
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-line">
                            Inventory Item -> {{$edit->inventory->item_name}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-line">
                            Received Quantity -> {{$edit->qty}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-line">
                            <select  class="form-control" name="department[]" >
                                <option value="" selected>Select Department</option>
                                @foreach($dept as $de)
                                <option value="{{$de->id}}">{{$de->dept_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" class="form-control" name="place_quantity[]" placeholder="Place Received Quantity">
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="edit_id[]" value="{{$edit->id}}" >
            <input type="hidden" name="item_id[]" value="{{$edit->item_id}}" >
            <input type="hidden" name="store_id[]" value="{{$edit->store_id}}" >
            <input type="hidden" name="received_qty[]" value="{{$edit->qty}}" >
            <hr>
        @endforeach
    </div>
</form>