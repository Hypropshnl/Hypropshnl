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
                        <div class="col-sm-4">`
                            <div class="form-group">
                                Title
                                <div class="form-line">
                                    <input type="text" class="form-control" value="{{$edit->name}}" name="title" placeholder="Title">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                Icon Image
                                <div class="form-line">
                                    <input type="file" class="form-control" name="icon_image" placeholder="Icon Image">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control" name="embed_video" placeholder="Embed video (Youtube,Vimeo etc.)">{{$edit->youtube}}</textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{$edit->course_id}}" class="form-control" name="course">
                        <input type="hidden" value="{{$edit->lesson_id}}" class="form-control" name="lesson">
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" id="topic_details_edit" class="form-control " name="details_edit" placeholder="details_edit">{{$edit->content}}</textarea>
                                    <script>
                                        CKEDITOR.replace('topic_details_edit');
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="category" value="Topic">
                    <input type="hidden" name="prev_photo" value="{{$edit->photo}}" >
                    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                    <hr>
                    
                    <button onclick="submitMediaFormRequest('editModal','editTopicForm','<?php echo url('edit_lms_topic'); ?>','reload_data',
                            '<?php echo url('lms_topic/'.$edit->course_id.'/'.$edit->lesson_id); ?>','<?php echo csrf_token(); ?>','topic_details_edit')" type="button" class="btn btn-success waves-effect">
                        SAVE
                    </button>
                    
                </div>
            </form>
        
        </div>
        @endif

        @if($edit->category_id == 2)
        <div role="tabpanel" class="tab-pane fade in active" id="{{$edit->category_id}}">
            <b>ASSIGNMENT</b>
            <form name="assignmentFormEdit" id="assignmentFormEdit" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                Title
                                <div class="form-line">
                                    <input type="text" value="{{$edit->name}}" class="form-control" name="title" placeholder="Title">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                Icon Image
                                <div class="form-line">
                                    <input type="file" class="form-control" name="icon_image" placeholder="Icon Image">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control" name="embed_video" placeholder="Embed video (Youtube,Vimeo etc.)">{{$edit->youtube}}</textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{$edit->course_id}}" class="form-control" name="course">
                        <input type="hidden" value="{{$edit->lesson_id}}" class="form-control" name="lesson">
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" value="{{$edit->score_mark}}" class="form-control" name="mark" placeholder="Mark (Out of 100)">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" class="form-control" value="{{$edit->deadline}}" name="deadline" placeholder="Deadline">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" value="{{$edit->words_limit}}" name="word_limit" placeholder="Word Limit">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" id="assignment_details_edit" class="form-control " name="details_edit" placeholder="details_edit">{{$edit->content}}</textarea>
                                    <script>
                                        CKEDITOR.replace('assignment_details_edit');
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="category" value="Assignment">
                    <input type="hidden" name="prev_photo" value="{{$edit->photo}}" >
                    <input type="hidden" name="edit_id" value="{{$edit->id}}" >

                    <hr>
                    <button onclick="submitMediaFormRequest('editModal','assignmentFormEdit','<?php echo url('edit_lms_topic'); ?>','reload_data',
                            '<?php echo url('lms_topic/'.$edit->course_id.'/'.$edit->lesson_id); ?>','<?php echo csrf_token(); ?>','assignment_details_edit')" type="button" class="btn btn-success waves-effect">
                        SAVE
                    </button>
                </div>
            </form>
            
        </div>
        @endif

        @if($edit->category_id == 3)
        <div role="tabpanel" class="tab-pane fade in active" id="{{$edit->category_id}}">
            <b>LIVE CLASS</b>
            <form name="liveClassFormEdit" id="liveClassFormEdit" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                Title
                                <div class="form-line">
                                    <input type="text" value="{{$edit->name}}" class="form-control" name="title" placeholder="Title">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                Icon Image
                                <div class="form-line">
                                    <input type="file" class="form-control" name="icon_image" placeholder="Icon Image">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control" name="embed_video" placeholder="Embed video (Youtube,Vimeo etc.)"> {{$edit->youtube}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" value="{{$edit->organizer}}" name="organizer" placeholder="Organizer">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{$edit->course_id}}" class="form-control" name="course">
                        <input type="hidden" value="{{$edit->lesson_id}}" class="form-control" name="lesson">
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" value="{{$edit->event_date}}" class="form-control" name="date" placeholder="Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="time" class="form-control" value="{{$edit->start_time}}" name="start_time" placeholder="Start Time">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="time" value="{{$edit->end_time}}" class="form-control" name="end_time" placeholder="End Time">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" id="live_class_details_edit" class="form-control " name="details_edit" placeholder="details_edit">{{$edit->content}}</textarea>
                                    <script>
                                        CKEDITOR.replace('live_class_details_edit');
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="category" value="Live Session">
                    <input type="hidden" name="prev_photo" value="{{$edit->photo}}" >
                    <input type="hidden" name="edit_id" value="{{$edit->id}}" >

                    <hr>
                    <button onclick="submitMediaFormRequest('editModal','liveClassFormEdit','<?php echo url('edit_lms_topic'); ?>','reload_data',
                            '<?php echo url('lms_topic/'.$edit->course_id.'/'.$edit->lesson_id); ?>','<?php echo csrf_token(); ?>','live_class_details_edit')" type="button" class="btn btn-success waves-effect">
                        SAVE
                    </button>
                </div>
            </form>
        </div>
        @endif

        @if($edit->category_id == 4)
        <div role="tabpanel" class="tab-pane fade in active" id="{{$edit->category_id}}">
            <b>EXAM/TEST</b>
            <form name="examTestFormEdit" id="examTestFormEdit" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                Title
                                <div class="form-line">
                                    <input type="text" value="{{$edit->name}}" class="form-control" name="title" placeholder="Title">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            Pass Mark
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" class="form-control" value="{{$edit->score_mark}}" name="pass_mark" placeholder="Pass Mark (0 to 100)">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                Select Test Session
                                <div class="form-line">
                                    <select  class="form-control" name="test_session" >
                                        <option value="{{$edit->exam_id}}">{{$edit->testSession->session_name}}</option>
                                        @foreach($testSession as $ap)
                                            <option value="{{$ap->id}}">{{$ap->session_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{$edit->course_id}}" class="form-control" name="course">
                        <input type="hidden" value="{{$edit->lesson_id}}" class="form-control" name="lesson">
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" id="exam_test_details_edit" class="form-control " name="details_edit" placeholder="details_edit">{{$edit->content}}</textarea>
                                    <script>
                                        CKEDITOR.replace('exam_test_details_edit');
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="category" value="Exam/Test">
                    <input type="hidden" name="prev_photo" value="{{$edit->photo}}" >
                    <input type="hidden" name="edit_id" value="{{$edit->id}}" >

                    <hr>
                    <button onclick="submitMediaFormRequest('editModal','examTestFormEdit','<?php echo url('edit_lms_topic'); ?>','reload_data',
                            '<?php echo url('lms_topic/'.$edit->course_id.'/'.$edit->lesson_id); ?>','<?php echo csrf_token(); ?>','exam_test_details_edit')" type="button" class="btn btn-success waves-effect">
                        SAVE
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>

</div>