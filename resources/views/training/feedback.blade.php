@extends('layouts.app')

@section('content')

<!-- Bordered Table -->
<div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Training Feedback Form
                    </h2>
                    <ul class="header-dropdown m-r--5">                   
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'feedbackMainForm', $exportDocId = 'feedback_report'])
                            </ul>
                        </li>

                    </ul>
                </div>
                <div class="container body table-responsive" id="feedback_report">
                    
                    <form name="" id="feedbackMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <?php $j = 0; ?>
                        @if($edit->count() > 0)  
                            <div class="body">   
                                @foreach($edit as $data)
                                        
                                        <div class="row clearfix">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        {{$data->rating->name}}
                                                        <input type="hidden"  class="form-control" value="{{$data->training_rates_id}}" name="training_rates_name_{{$j}}">
                                                        <input type="hidden"  class="form-control" value="1" name="submit_type">
                                                        <input type="hidden"  class="form-control" value="{{$data->id}}" name="id_{{$j}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            @foreach($data->training_items as $item)
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                {{$item->name}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(!empty($item->levels))
                                                        <?php $levels = json_decode($item->levels);?>
                                                        @foreach($levels as $level)
                                                            <?php $checked = ($data->rate == $level) ? 'checked' : ''; ?>
                                                            <div class="col-sm-1">
                                                                <div class="">
                                                                    <div class="form-check form-check-inline">
                                                                        <input name="rate_{{$j}}" type="radio" {{$checked}} value="{{$level}}" id="{{$j}}_level_{{$level}}"><label for="{{$j}}_level_{{$level}}" >{{$level}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                
                                    @php $j++; @endphp
                                @endforeach

                                <hr>
                                    <div class="row clearfix">
                                            <div class="col-sm-6">
                                            <b>Most Useful</b>                      
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control" name="most_useful">{{$data->feedComment->most_useful}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">   
                                            <b>Least Useful</b>                   
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control" name="least_useful">{{$data->feedComment->least_useful}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row clearfix">
                                            <div class="col-sm-6">  
                                            <b>suggestion</b>                    
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control" name="suggestion">{{$data->feedComment->suggestion}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">       
                                            <b>Implementation</b>               
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control" name="implementation">{{$data->feedComment->implementation}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row clearfix">
                                            <div class="col-sm-12"> 
                                            <b>Summary</b>                     
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control" name="summary">{{$data->feedComment->summary}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row clearfix">
                                            <div class="col-sm-6">  
                                            <b>User Sign Off</b>                    
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" value="{{$data->feedComment->user_sign}}" name="user_sign">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">   
                                            <b>HR Sign Off</b>                   
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" value="{{$data->feedComment->hr_sign}}" name="hr_sign">
                                                    </div>
                                                </div>
                                            </div>
                                    </div><hr>
                                    <div class="row">
                                        <b>Created at ---{{$data->feedComment->created_at}}</b>
                                    </div>

                            </div>
                        @else
                                <?php $j = 0; ?>
                                <div class=" body">
                                    @foreach($mainData as $data)        
                                        <div class="row clearfix">
                                            <div class="col-sm-6">                    
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        {{$data->name}}
                                                        <input type="hidden"  class="form-control" value="{{$data->id}}" name="training_rates_name_{{$j}}">
                                                        <input type="hidden"  class="form-control" value="0" name="submit_type">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            @foreach($data->training_items as $item)
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                {{$item->name}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(!empty($item->levels))
                                                        <?php $levels = json_decode($item->levels); $k = 0; ?>
                                                        @foreach($levels as $level)
                                                        
                                                            <div class="col-sm-1">
                                                                <div class="">
                                                                    <div class="form-check form-check-inline">
                                                                        <input name="rate_{{$j}}" type="radio"  class="" value="{{$level}}" id="{{$j}}_level_{{$level}}"><label for="{{$j}}_level_{{$level}}" >{{$level}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @php $j++; @endphp
                                    @endforeach
                                    <hr>
                                    <div class="row clearfix">
                                            <div class="col-sm-6"> 
                                                <b>Most Useful</b>                   
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control" name="most_useful" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <b>Least Useful</b>                    
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control" name="least_useful" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row clearfix">
                                            <div class="col-sm-6"> 
                                                <b>suggestion</b>                   
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control" name="suggestion"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <b>Implementation</b>                    
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control" name="implementation"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row clearfix">
                                            <div class="col-sm-12"> 
                                                <b>Summary</b>                   
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class="form-control" name="summary"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row clearfix">
                                            <div class="col-sm-6">
                                                <b>User Sign Off</b>                    
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="user_sign">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <b>HR Sign Off</b>                    
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="hr_sign">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                </div>

                        @endif

                        <input type="hidden" name="training_id" value="{{$training->id}}" >
                        <input type="hidden" name="rate_count" value="{{$j}}" >
                    </form>

                    @if(in_array(Auth::user()->role, Utility::HR_MANAGEMENT) || Auth::user()->id == $training->user_id)
                    <div class="row pull-right">
                    <button type="button"  onclick="submitDefaultNoFormModal('feedbackMainForm','<?php echo url('training_feedback'); ?>','reload_data',
                            '<?php echo url('training'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-info waves-effect">
                        SAVE CHANGES
                    </button>
                    </div>
                    @endif

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->




@endsection