
<div class="body">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#topic" data-toggle="tab">Topic</a></li>
        <li role="presentation"><a href="#assignment" data-toggle="tab">Assignment</a></li>
        <li role="presentation"><a href="#live_class" data-toggle="tab">Live Class</a></li>
        <li role="presentation"><a href="#exam_test" data-toggle="tab">Exam/Test</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="topic">
            <b>TOPIC</b>
            <form name="topicForm" id="createTopicForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-4">`
                            <div class="form-group">
                                Title
                                <div class="form-line">
                                    <input type="text" class="form-control" name="title" placeholder="Title">
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

                        <div class="col-sm-4">
                            <div class="form-group">
                                Attachment
                                <div class="form-line">
                                    <input type="file" multiple="multiple" class="form-control" name="attachment[]" placeholder="Attachment">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control" name="embed_video" placeholder="Embed video (Youtube,Vimeo etc.)"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{$course->id}}" class="form-control" name="course">
                        <input type="hidden" value="{{$lesson->id}}" class="form-control" name="lesson">
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" id="topic_details" class="form-control " name="details" placeholder="Details">Enter details</textarea>
                                    <script>
                                        CKEDITOR.replace('topic_details');
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="category" value="Topic">
                    <hr>
                    
                    <button onclick="submitMediaFormRequest('createModal','createTopicForm','<?php echo url('create_lms_topic'); ?>','reload_data',
                            '<?php echo url('lms_topic/'.$course->id.'/'.$lesson->id); ?>','<?php echo csrf_token(); ?>','topic_details')" type="button" class="btn btn-success waves-effect">
                        SAVE
                    </button>
                    
                </div>
            </form>
        
        </div>
        <div role="tabpanel" class="tab-pane fade" id="assignment">
            <b>ASSIGNMENT</b>
            <form name="assignmentForm" id="assignmentForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                Title
                                <div class="form-line">
                                    <input type="text" class="form-control" name="title" placeholder="Title">
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

                        <div class="col-sm-4">
                            <div class="form-group">
                                Attachment
                                <div class="form-line">
                                    <input type="file" multiple="multiple" class="form-control" name="attachment[]" placeholder="Attachment">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control" name="embed_video" placeholder="Embed video (Youtube,Vimeo etc.)"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{$course->id}}" class="form-control" name="course">
                        <input type="hidden" value="{{$lesson->id}}" class="form-control" name="lesson">
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" class="form-control" name="mark" placeholder="Mark (Out of 100)">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" class="form-control" name="deadline" placeholder="Deadline">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="word_limit" placeholder="Word Limit">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" id="assignment_details" class="form-control " name="details" placeholder="Details">Enter details</textarea>
                                    <script>
                                        CKEDITOR.replace('assignment_details');
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="category" value="Assignment">

                    <hr>
                    <button onclick="submitMediaFormRequest('createModal','assignmentForm','<?php echo url('create_lms_topic'); ?>','reload_data',
                            '<?php echo url('lms_topic/'.$course->id.'/'.$lesson->id); ?>','<?php echo csrf_token(); ?>','assignment_details')" type="button" class="btn btn-success waves-effect">
                        SAVE
                    </button>
                </div>
            </form>
            
        </div>
        <div role="tabpanel" class="tab-pane fade" id="live_class">
            <b>LIVE CLASS</b>
            <form name="liveClassForm" id="liveClassForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                Title
                                <div class="form-line">
                                    <input type="text" class="form-control" name="title" placeholder="Title">
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

                        <div class="col-sm-4">
                            <div class="form-group">
                                Attachment
                                <div class="form-line">
                                    <input type="file" multiple="multiple" class="form-control" name="attachment[]" placeholder="Attachment">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control" name="embed_video" placeholder="Embed video (Youtube,Vimeo etc.)"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="organizer" placeholder="Organizer">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{$course->id}}" class="form-control" name="course">
                        <input type="hidden" value="{{$lesson->id}}" class="form-control" name="lesson">
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" class="form-control" name="date" placeholder="Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="time" class="form-control" name="start_time" placeholder="Start Time">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="time" class="form-control" name="end_time" placeholder="End Time">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" id="live_class_details" class="form-control " name="details" placeholder="Details">Enter details</textarea>
                                    <script>
                                        CKEDITOR.replace('live_class_details');
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="category" value="Live Session">

                    <hr>
                    <button onclick="submitMediaFormRequest('createModal','liveClassForm','<?php echo url('create_lms_topic'); ?>','reload_data',
                            '<?php echo url('lms_topic/'.$course->id.'/'.$lesson->id); ?>','<?php echo csrf_token(); ?>','live_class_details')" type="button" class="btn btn-success waves-effect">
                        SAVE
                    </button>
                </div>
            </form>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="exam_test">
            <b>EXAM/TEST</b>
            <form name="examTestForm" id="examTestForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-5">
                            <div class="form-group">
                                Title
                                <div class="form-line">
                                    <input type="text" class="form-control" name="title" placeholder="Title">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            Pass Mark
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" class="form-control" name="pass_mark" placeholder="Pass Mark (0 to 100)">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                Select Test Session
                                <div class="form-line">
                                    <select  class="form-control" name="test_session" >
                                        <option value="">Test Session(s)</option>
                                        @foreach($testSession as $ap)
                                            <option value="{{$ap->id}}">{{$ap->session_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{$course->id}}" class="form-control" name="course">
                        <input type="hidden" value="{{$lesson->id}}" class="form-control" name="lesson">
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" id="exam_test_details" class="form-control " name="details" placeholder="Details">Enter details</textarea>
                                    <script>
                                        CKEDITOR.replace('exam_test_details');
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="category" value="Exam/Test">

                    <hr>
                    <button onclick="submitMediaFormRequest('createModal','examTestForm','<?php echo url('create_lms_topic'); ?>','reload_data',
                            '<?php echo url('lms_topic/'.$course->id.'/'.$lesson->id); ?>','<?php echo csrf_token(); ?>','exam_test_details')" type="button" class="btn btn-success waves-effect">
                        SAVE
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>