
<!-- Bordered Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <a href="{{url('lms_course_list')}}"><i class="material-icons">arrow_back</i> <span class="icon-name">Courses</span> </a>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                        </ul>
                    </li>

                </ul>
            </div>

            <div class="body">
                

                <div class="row clearfix">
                    <div class="col-md-4">
                        <a href="{{route('lms_course_item', ['course_id' => $mainData->id])}}" data-sub-html="{{$mainData->name}} ({{$mainData->code}})">
                            <img class="img-responsive thumbnail" src="{{ asset('files/'.$mainData->photo) }}">
                        </a>
                        <div>
                            <h4><a href="{{route('lms_course_item', ['course_id' => $mainData->id])}}">{{$mainData->name}} ({{$mainData->code}})</a></h4>
                            <span>Category: {{$mainData->category->name}}</span>
                            <div class="progress">
                                @if($percentage <= 35 && $percentage > 20)
                                <div class="progress-bar progress-bar-success" style="width: 35%">
                                    <span class="sr-only">35% Complete </span>
                                    {{$percentage}}%
                                </div>
                                @elseif($percentage <= 20 && $percentage > 10)
                                <div class="progress-bar progress-bar-warning progress-bar-striped active" style="width: 20%">
                                    <span class="sr-only">20% Complete </span>
                                    {{$percentage}}%
                                </div>
                                @else
                                <div class="progress-bar progress-bar-danger" style="width: 10%">
                                    <span class="sr-only">10% Complete </span>
                                    {{$percentage}}%
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        
                        @foreach($lessons as $data)
                            <div class="panel-group" id="accordion_{{$data->id}}" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingOne_{{$data->id}}">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion_{{$data->id}}" href="#collapseOne_{{$data->id}}" aria-expanded="true" aria-controls="collapseOne_{{$data->id}}">
                                                {{$data->name}}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne_{{$data->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_{{$data->id}}">
                                        <div class="panel-body">
                                            
                                                <div class="clearfix m-b-20">
                                                    <div class="dd nestable-with-handle">
                                                        <ol class="dd-list">
                                                            @foreach($data->lessonMany as $topic)
                                                                @if(in_array($topic->id, $myTopics) || $loop->first)
                                                                <a href="{{route('lms_topic_item', ['course_id' => $data->course_id,'lesson_id' => $data->id, 'topic_id' => $topic->id])}}">
                                                                    <li class="dd-item dd3-item" data-id="topic_{{$topic->id}}">
                                                                        <div class="dd-handle dd3-handle"></div>
                                                                        <div style="cursor: pointer;" class="dd3-content">
                                                                        {{$topic->name}}
                                                                        </div>
                                                                    </li>
                                                                </a>
                                                                @else
                                                                    <li class="dd-item dd3-item" data-id="topic_{{$topic->id}}">
                                                                        <div class="dd-handle dd3-handle"></div>
                                                                        <div class="dd3-content">
                                                                        {{$topic->name}}
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ol>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <!-- END OF BODY -->

        </div>

    </div>
</div>

<!-- #END# Bordered Table -->

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

<script>
    /*$(function() {
        $( ".datepicker" ).datepicker({
        /!*changeMonth: true,
        changeYear: true*!/
        });
        });*/
</script>