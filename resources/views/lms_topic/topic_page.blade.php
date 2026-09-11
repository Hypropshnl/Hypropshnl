

<!-- Bordered Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <a href="{{url('lms_course_item/'.$course->id)}}"><i class="material-icons">arrow_back</i> <span class="icon-name">{{$lesson->name}}</span> Lesson</a>
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
    
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                @foreach($category as $key => $var)
                
                @php   $active = ($edit->category_id == $key) ? 'active' : ''; @endphp
                    <li role="presentation" class="{{$active}}"><a href="#{{$key}}" data-toggle="tab">{{$var}}</a></li>
                @endforeach
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    @if($edit->category_id == 1)
                    <div role="tabpanel" class="tab-pane fade in active" id="{{$edit->category_id}}">
                        <b>TOPIC</b>
                        <form name="topicForm" id="editTopicForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <a href="{{ asset('files/'.$edit->photo) }}" data-sub-html="{{$edit->name}}">
                                            <img class="img-responsive thumbnail" src="{{ asset('files/'.$edit->photo) }}">
                                        </a>
                                        <div>
                                            <h4><a href="{{ asset('files/'.$edit->photo) }}">{{$edit->name}}</a></h4>
                                            
                                        </div>
                                    </div>

                                </div>
                                <hr>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <iframe width="100%" height="500" src="{{$edit->youtube}}" frameborder="0" allowfullscreen=""></iframe>
                                    </div>
                                </div><hr>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        {!!$edit->content!!}
                                    </div>
                                </div>
                                <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                <hr>
                                
                                <button onclick="submitDefaultNoFormModal('editTopicForm','<?php echo url('finish_lms_topic'); ?>','reload_data',
                                        ' ', '<?php echo csrf_token(); ?>')" type="button" class="btn btn-success waves-effect">
                                    Finish
                                </button>
                            </div>
                        </form>
                    
                    </div>
                    @endif

                    @if($edit->category_id == 2)
                    <div role="tabpanel" class="tab-pane fade in active" id="{{$edit->category_id}}">
                        <b>ASSIGNMENT</b>
                        <form name="assignmentForm" id="assignmentForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                Pass Mark : {{$edit->score_mark}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                               Dead Line : {{$edit->deadline}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                Words Limit : {{$edit->words_limit}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <a href="{{ asset('files/'.$edit->photo) }}" data-sub-html="{{$edit->name}}">
                                            <img class="img-responsive thumbnail" src="{{ asset('files/'.$edit->photo) }}">
                                        </a>
                                        <div>
                                            <h4><a href="{{ asset('files/'.$edit->photo) }}">{{$edit->name}}</a></h4>
                                            
                                        </div>
                                    </div>

                                </div>
                                <hr>
                                
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        {!!$edit->content!!}
                                    </div>
                                </div><hr>

                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <iframe width="100%" height="500" src="{{$edit->youtube}}" frameborder="0" allowfullscreen=""></iframe>
                                    </div>
                                </div><hr>


                                <input type="hidden" name="edit_id" value="{{$edit->id}}" >

                                <hr>
                                <button onclick="submitDefaultNoFormModal('assignmentForm','<?php echo url('finish_lms_topic'); ?>','reload_data',
                                        ' ', '<?php echo csrf_token(); ?>')" type="button" class="btn btn-success waves-effect">
                                    Finish
                                </button>
                            </div>
                        </form>
                        
                    </div>
                    @endif

                    @if($edit->category_id == 3)
                    <div role="tabpanel" class="tab-pane fade in active" id="{{$edit->category_id}}">
                        <b>LIVE CLASS</b>
                        <form name="liveClassForm" id="liveClassForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <a href="{{ asset('files/'.$edit->photo) }}" data-sub-html="{{$edit->name}}">
                                            <img class="img-responsive thumbnail" src="{{ asset('files/'.$edit->photo) }}">
                                        </a>
                                        <div>
                                            <h4><a href="{{ asset('files/'.$edit->photo) }}">{{$edit->name}}</a></h4>
                                            
                                        </div>
                                    </div>

                                </div>
                                <hr>
                                
                                
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                Title : {{$edit->name}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                Event Date : "{{$edit->event_date}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                Start Time : {{$edit->start_time}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                End Time : {{$edit->end_time}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                Oranizer : {{$edit->organizer}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        {!!$edit->content!!}
                                    </div>
                                </div><hr>

                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <iframe width="100%" height="500" src="{{$edit->youtube}}" frameborder="0" allowfullscreen=""></iframe>
                                    </div>
                                </div><hr>
                                <input type="hidden" name="edit_id" value="{{$edit->id}}" >

                                <hr>
                                <button onclick="submitDefaultNoFormModal('liveClassForm','<?php echo url('finish_lms_topic'); ?>','reload_data',
                                        ' ','<?php echo csrf_token(); ?>')" type="button" class="btn btn-success waves-effect">
                                    Finish
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    @if($edit->category_id == 4)
                    <div role="tabpanel" class="tab-pane fade in active" id="{{$edit->category_id}}">
                        <b>EXAM/TEST</b>
                        <form name="examTestForm" id="examTestForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            Title
                                            <div class="form-line">
                                                {{$edit->name}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            Click here to write test
                                            <div class="form-line">
                                                    
                                                <a href="{{ url('test_form/'.$edit->testSession->test_id.'/'.$edit->testSession->id.\App\Helpers\Utility::authLink('temp_user')) }}">
                                                    {{$edit->testSession->session_name}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div><hr>

                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        {!!$edit->content!!}
                                    </div>
                                </div><hr>
                                <input type="hidden" name="edit_id" value="{{$edit->id}}" >

                                <button onclick="submitDefaultNoFormModal('examTestForm','<?php echo url('finish_lms_topic'); ?>','reload_data',
                                        ' ','<?php echo csrf_token(); ?>')" type="button" class="btn btn-success waves-effect">
                                    Finish
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>

            </div>

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