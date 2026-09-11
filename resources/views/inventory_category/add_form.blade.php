<form name="addZoneMainForm" id="addZoneMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <h3>{{$edit->category_name}}</h3><hr>
        <div class="row clearfix">
            <div class="col-sm-12">
                <b>Subcategory</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="inventory_sub_category form-control" name="name" placeholder="Category Name">
                    </div>
                </div>
            </div>
        </div>

            <div class="col-sm-4" id="hide_button_inventory_sub_category">
                <div class="form-group">
                    <div onclick="addMore('add_more_inventory_sub_category','hide_button_inventory_sub_category','1','<?php echo URL::to('add_more'); ?>','inventory_sub_category','hide_button_inventory_sub_category');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>
        <div id="add_more_inventory_sub_category"></div>

    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >

    </div>

</form><br>

<button type="button"  onclick="saveMethod('addZoneModal','addZoneMainForm','<?php echo url('create_inventory_sub_category'); ?>','manageZone',
        '<?php echo url('inventory_sub_category'); ?>','<?php echo csrf_token(); ?>','inventory_sub_category','{{$edit->id}}')"
        class="btn btn-info waves-effect pull-right">
    SAVE
</button>