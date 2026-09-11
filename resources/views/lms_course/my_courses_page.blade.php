
<!-- Bordered Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    My Courses
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
               
                <div class=" table-responsive" id="reload_data" >
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                    name="check_all" class="" />

                            </th>

                            <th>Name</th>
                            <th>Progress</th>
                            <th>Total Topics</th>
                            <th>Completed Topics</th>
                            <th>Status</th>
                            <th>Certificate</th>
                            <th>Last Visit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                            <tr>
                                <td scope="row">
                                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>
                                    <a href="{{route('lms_course_item', ['course_id' => $data->course_id])}}">
                                        {{$data->courseDetail->name}}({{$data->courseDetail->code}})
                                    </a>
                                </td>
                                <td>`
                                    <div class="progress">
                                        @if($data->percentage <= 35 && $data->percentage > 20)
                                        <div class="progress-bar progress-bar-success" style="width: 35%">
                                            <span class="sr-only">35% Complete </span>
                                            {{$data->percentage}}%
                                        </div>
                                        @elseif($data->percentage <= 20 && $data->percentage > 10)
                                        <div class="progress-bar progress-bar-warning progress-bar-striped active" style="width: 20%">
                                            <span class="sr-only">20% Complete </span>
                                            {{$data->percentage}}%
                                        </div>
                                        @else
                                        <div class="progress-bar progress-bar-danger" style="width: 10%">
                                            <span class="sr-only">10% Complete </span>
                                            {{$data->percentage}}%
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td>{{$data->topicsCount}}</td>
                                <td>{{$data->myTopicCount}}</td>
                                <td>
                                    @if($data->end_status == Utility::STATUS_ACTIVE)
                                        Finished
                                    @else
                                        In Progress
                                    @endif
                                </td>
                                <td>
                                    @if($data->complete_status == Utility::STATUS_ACTIVE && $data->courseDetail->certificate == Utility::STATUS_ACTIVE)
                                        @if(!empty($data->certificate_doc))
                                        <a class="btn btn-info" target="_blank" href="{{url('lms_auto_certification/certificate/'.$data->uuid)}}">
                                            View
                                        </a>|
                                        @endif
                                        <a class="btn btn-primary" target="_blank" href="{{url('download_lms_auto_certificate/'.$data->uuid)}}">
                                            Download
                                        </a>
                                    @endif
                                </td>
                                <td>{{$data->updated_at}}</td>
                                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

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

<script>
    /*$(function() {
        $( ".datepicker" ).datepicker({
        /!*changeMonth: true,
        changeYear: true*!/
        });
        });*/
</script>