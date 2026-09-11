

<!-- Bordered Table -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    COURSES
                    <small>Choose a course and enroll</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            @include('includes/export',[$exportId = 'aniimated-thumbnials', $exportDocId = 'aniimated-thumbnials'])
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">

                <div class="row">
                    <div class="col-sm-8 ">

                        <div class="form-group">

                            <div class="form-line">

                                <input type="text" id="search_course" class="form-control"

                                onkeyup="searchItem('search_course','aniimated-thumbnials','<?php echo url('search_lms_course_list') ?>','{{url('lms_course_list')}}','<?php echo csrf_token(); ?>')"

                                name="search_course" placeholder="Search Courses" >

                            </div>
                        </div>
                    </div>
                </div>

                    <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                        @foreach($mainData as $data)
                        @php $departments = json_decode($data->department_id) @endphp
                        @if(in_array(Auth::user()->dept_id,$departments))
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <a href="{{route('lms_course_item', ['course_id' => $data->id])}}" data-sub-html="{{$data->name}} ({{$data->code}})">
                                <img class="img-responsive thumbnail" src="{{ asset('files/'.$data->photo) }}">
                            </a>
                            <div>
                                <h4><a href="{{route('lms_course_item', ['course_id' => $data->id])}}">{{$data->name}} ({{$data->code}})</a></h4>
                                <span>Category: {{$data->category->name}}</span>
                                
                            </div>
                            <div>
                                @if($courseArr > 0 && in_array($data->id, $courseArr))
                                    <span class="pull-left btn btn-success">In Progress</span>
                                @else
                                    <span class="pull-left btn "><a href="{{route('lms_course_item_enroll', ['course_id' => $data->id])}}">Enroll</a></span>
                                    
                                @endif
                                <span class="pull-left btn "><a href="{{route('lms_course_item', ['course_id' => $data->id])}}">Overview</a></span>
                            </div>
                        </div>
                        @endif
                        @endforeach

                        <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                        </div>
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