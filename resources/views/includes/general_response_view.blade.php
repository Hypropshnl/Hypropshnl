
<button class="toggle-btn btn btn-sm btn-primary" onclick="toggleItem('msg{{$data->id}}',this)">
    Show
</button>
<div id="msg{{$data->id}}" style="display:none;">
                                
    <table class="table table-bordered table-responsive">
        <thead>
        <th>Name</th>
        <th>Response Message(s)</th>
        </thead>
        <tbody>
        @if(!empty($data->response_message))
            @php $responseArray = json_decode($data->response_message,true); @endphp
            @foreach($responseArray as $response)
                <tr>
                    <td>{{$response[0][0]}}</td>
                    <td>
                        <table>
                            <thead>
                                <th>Response message</th>
                            </thead>
                            <tbody>
                                @foreach($response[1] as $message)
                                <tr>
                                    <td>{{$message}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endforeach
        @endif
        
        </tbody>
    </table>
</div>
                              