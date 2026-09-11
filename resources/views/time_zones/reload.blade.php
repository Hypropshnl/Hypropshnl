<div class="container">
    <div class="body">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="info-box hover-zoom-effect">
                <div class="icon bg-light-blue">
                    <i class="material-icons">location_city</i>
                </div>
                <div class="content">
                    <div class="text">Time Zone</div>
                    <div class="number">{{$timeZoneName}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="info-box hover-zoom-effect">
                <div class="icon bg-light-blue">
                    <i class="material-icons">access_time</i>
                </div>
                <div class="content">
                    <div class="text">DateTime</div>
                    <div class="number">{{$dateTime}}</div>
                </div>
            </div>
        </div>
    </div>

</div>

<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_timezone_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

            <td>
                @if($data->active_status == \App\Helpers\Utility::STATUS_ACTIVE)
                    <span class="alert-success" style="color:white">{{$data->name}}</span>
                @else
                    {{$data->name}}
                @endif
            </td>

            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>
