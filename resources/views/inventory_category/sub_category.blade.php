

<div class=" table-responsive" id="reload_data_zone">

    <a style="cursor: pointer;" onclick="newWindow('{{$inventoryCategoryId}}','addZone','<?php echo url('add_inventory_sub_category_form') ?>','<?php echo csrf_token(); ?>','addZoneModal')"><i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></a>
    <hr>

    <button type="button" onclick="deleteItemsFetchId('kid_checkbox_zone','manageZone','<?php echo url('inventory_sub_category'); ?>',
            '<?php echo url('delete_inventory_sub_category'); ?>','<?php echo csrf_token(); ?>','{{$inventoryCategoryId}}');" class="btn btn-danger">
        <i class="fa fa-trash-o"></i>Delete
    </button><hr>

<table class="table table-bordered table-hover table-striped" id="main_table_zone">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_zone');" id="parent_check_zone"
                   name="check_all" class="" />

        </th>
        <th>Category</th>
        <th>Name</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox_zone" />

            </td>

            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

            <td>{{$data->categoryDetail->name}}</td>
            <td>{{$data->name}}</td>
            <td>
                @if($data->created_by != '0')
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @endif
            </td>
            <td>
                @if($data->updated_by != '0')
                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                @endif
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

</div>

