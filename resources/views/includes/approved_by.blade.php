
                                
<table class="table table-bordered table-responsive">
    @if($data->approved_users != '' || $data->deny_reason != '')
    <thead>
    <th>Name</th>
    <th>Reason</th>
    </thead>
    @endif
    <tbody>
    @if($data->approved_users != '')
        @foreach($data->approved_by as $users)
            <tr>
                <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                <td>Approved</td>
            </tr>
        @endforeach
    @else
        @if($data->approval_status === 1)
            <tr><td>Management</td></tr>
        @endif
    @endif
    
    @if($data->deny_reason != '')
        <tr>
            <td>{{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}</td>
            <td>Denied: {{$data->deny_reason}}</td>
        </tr>
    @endif
    
    </tbody>
</table>
                              