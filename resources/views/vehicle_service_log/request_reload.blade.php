<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                    name="check_all" class="" />

            </th>
            <th>Attachment</th>
            <th>Vehicle</th>
            <th>Service Type</th>
            <th>Total Bill {{\App\Helpers\Utility::defaultCurrency()}}</th>
            <th>Driver</th>
            <th>Workshop</th>
            <th>Mileage In({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
            <th>Mileage Out({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
            <th>Location</th>
            <th>Service Date</th>
            <th>Comment</th>
            <th>Invoice Reference</th>
            <th>Approval Status</th>
            <th>Approved by</th>
            <th>Created by</th>
            <th>Updated by</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        @if($data->complete_status == 0)
            @if($data->approval_view == 1 && $data->deny_reason == '')
                @if($data->next_user == Auth::user()->id)
                    <tr>
                        <td scope="row">
                            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                        </td>
                        <td>
                            <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_vehicle_service_log_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                        </td>
                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                    
                        <td>{{$data->vehicle_make}} {{$data->vehicle_model}} ({{$data->vehicleDetail->license_plate}})</td>
                        <td>{{$data->service->name}}</td>
                        <td>{{Utility::numberFormat($data->total_price)}}</td>
                        <td>{{$data->driver->firstname}} &nbsp; {{$data->driver->lastname}}</td>
                        <td>{{$data->workshopDetail->name}}</td>
                        <td>{{Utility::numberFormat($data->mileage_in)}}</td>
                        <td>{{Utility::numberFormat($data->mileage_out)}}</td>
                        <td>{{$data->location}}</td>
                        <td>{{$data->service_date}}</td>
                        <td>{{$data->comment}}</td>
                        <td>{{$data->invoice_reference}}</td>

                        <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
                            @if($data->approval_status === 1)
                                Request Approved
                            @endif
                            @if($data->approval_status === 0)
                                Processing Request
                            @endif
                            @if($data->approval_status === 2)
                                Request Denied
                            @endif
                        </td>
                        <td>
                            @include('includes/approved_by')
                        </td>

                        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                        <td>{{$data->created_at}}</td>
                        <td>{{$data->updated_at}}</td>
                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                        <input type="hidden" id="vendorDisplay" value="{{$data->vendor}}">

                    </tr>
                @endif
            @endif
        @endif
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>