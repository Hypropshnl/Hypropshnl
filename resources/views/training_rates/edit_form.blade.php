<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text"  class="form-control" value="{{$edit->name}}" name="training_rates_name" placeholder="Training Rate Name">
                    </div>
                </div>
            </div>
        </div>
        <?php $j = 0; ?>
        @foreach($edit->training_items as $item)
            <div class="row clear-fix">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text"  class="form-control" value="{{$item->name}}" name="rate_name_{{$j}}" placeholder="Rate Name">
                            <input type="hidden"  class="form-control" value="{{$item->id}}" name="rate_id_{{$j}}">
                        </div>
                    </div>
                </div>
                @if(!empty($item->levels))
                    <?php $levels = json_decode($item->levels); $k = 0; ?>
                    @foreach($levels as $level)
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="form-line">
                                    <select  class="form-control" name="{{$j}}rate_{{$k++}}" >
                                        <option value="{{$level}}">{{$level}}</option>
                                        @for($i = 0; $i < 11; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @php $j++; @endphp
        @endforeach

    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
     $( ".datepicker2" ).datepicker({
     /*changeMonth: true,
     changeYear: true*/
     });
     });
</script>