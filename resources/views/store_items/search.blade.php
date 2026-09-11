<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

        </th>

        <th>Store</th>
        <th>Inventory Item</th>
        <th>Department</th>
        <th>Quantity</th>
        <th>Created by</th>
        <th>Created at</th>
        <th>Updated by</th>
        <th>Updated at</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>{{$data->store->name}} ()</td>
        <td>{{$data->inventory->item_name}}</td>
        <td>{{$data->department->dept_name}}</td>
        <td>{{$data->quantity}}</td>
        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
        <td>{{$data->updated_at}}</td>


        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
        @if(in_array(Auth::user()->role,Utility::TOP_USERS) || Auth::user()->dept_id == $data->dept_id)
        <td>
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_store_items_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
        @endif
    </tr>
    @endforeach
    </tbody>
</table>
