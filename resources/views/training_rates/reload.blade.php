<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Training Rate</th>
        <th>Rate Type</th>
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
            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

        </td>
        <td>
            @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_training_rates_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            @endif
        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>{{$data->name}}</td>
        <td>
            <table>
                <thead>
                    @foreach($data->training_items as $item)
                        <th>{{$item->name}}</th>
                    @endforeach
                </thead>
                <tbody>
                    <tr>
                        @foreach($data->training_items as $item)                                                
                            <td>
                                @if(!empty($item->levels))
                                <?php $levels = json_decode($item->levels, true); ?>
                                @foreach($levels as $level)
                                    {{$level}} ,
                                @endforeach
                                @endif
                            </td>     
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </td>
        <td>
            {{$data->user_c->firstname}} {{$data->user_c->lastname}}
        </td>
        <td>
            {{$data->user_u->firstname}} {{$data->user_u->lastname}}
        </td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

    </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>