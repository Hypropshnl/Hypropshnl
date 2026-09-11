
 @foreach(\App\Helpers\Utility::warehouseData() as $inv)
    <option value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
 @endforeach