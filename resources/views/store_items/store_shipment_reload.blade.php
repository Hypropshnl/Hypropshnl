<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

        </th>

        <th>Store</th>
        <th>Inventory Item</th>
        <th>Sales Number</th>
        <th>Quantity Shipped</th>
        <th>Updated Inventory Quantity</th>
        <th>Status</th>
        <th>Created by</th>
        <th>Created at</th>
        <th>Updated by</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
    <tr>
        <td scope="row">
            @if(in_array(Auth::user()->id, Utility::TOP_USERS) || Auth::user()->id == $data->storeDetail->user_id)
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />
            @else
                Not Manager
            @endif

        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>{{$data->storeDetail->name}}({{$data->storeDetail->code}})</td>
        <td>{{$data->inventory->item_name}}({{$data->inventory->code}})</td>
        <td>{{$data->salesItem->sales_number}}</td>
        <td>{{$data->qty}}</td>
        <td>
                @if (!empty($data->qty_remain) || $data->qty_remain != 0)
            <a href="#" class="badge bg-green">{{$data->qty_remain}}</a>
            @else
            
            <a href="#" class="badge bg-blue">{{$data->inventory->qty}}</a>
            @endif
        </td>
        <td>
            @if (!empty($data->qty_remain) || $data->qty_remain != 0)
            <a href="#" class="badge bg-green">Placed</a>
            @else
            
            <a href="#" class="badge bg-red">Not Placed</a>
            @endif
        </td>
        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
        <td>{{$data->updated_at}}</td>


        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
    </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>