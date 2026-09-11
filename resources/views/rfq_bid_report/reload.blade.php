

 <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Review Analysis</th>
                            <th>RFQ No.</th>
                            <th>Total Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Response Message(s)</th>
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
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>
                                            <a class="btn btn-info" href="{{url('rfq_vendor_bids/'.$data->id)}}">View</a>
                                        </td>
                                        <td>{{$data->rfqDetail->rfq_no}}</td>
                                        <td>{{Utility::numberFormat($data->amount)}}</td>
                                        <td>
                                            @include('includes/general_response_view')
                                        </td>
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