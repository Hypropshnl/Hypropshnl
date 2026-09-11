@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Choose Employee(s) to Appraise for {{$goalSet->goal_name}}
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
                <div class="body row">
                    <div class="col-md-6">
                        <div class="card header">
                            <h2>Assigned User(s)</h2>
                        </div>
                        <div class="body row">
                            <div class=" table-responsive" id="reload_data" >

                                <table class="table table-bordered table-hover table-striped" id="main_table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox_assigned');" id="parent_check_assigned"

                                                    name="check_all_assigned" class="" />
                                            </th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Appraisal</th>
                                            <th>Profile</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($mainData as $data)
                                    <tr>
                                        <td scope="row">

                                            <input value="{{$data->user_id}}" type="checkbox" id="{{$data->id}}_assigned" class="kid_checkbox_assigned" />

                                        </td>

                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

                                        <td>
                                            <a href="{{route('profile', ['uid' => $data->userData->uid])}}">
                                                <span class="">{{$data->userData->title}}&nbsp;{{$data->userData->firstname}}&nbsp;{{$data->userData->othername}}&nbsp;{{$data->userData->lastname}}</span>
                                            </a>
                                        </td>
                                        <td>
                                            {{$data->department->dept_name}}
                                        </td>
                                        <td>
                                            <a target="_blank" href="{{route('okr_employee_appraisal_user_goal',
                                            ['userId' => $data->user_id,'deptId' => $data->userData->dept_id,'goalSetId' => $data->unit_goal_series_id])}}">Appraise Employee
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('profile', ['uid' => $data->userData->uid])}}" target="_blank"><span class="">View Profile</span></a>
                                        </td>
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                                    </tr>
                                    @endforeach

                                    </tbody>

                                </table>

                            </div>
                        </div>
                        

                    </div>

                    <div class="col-md-6">
                        <div class="card header">
                            <h2>Search Employee(s) by Department</h2>
                        </div>
                        <div class="body row">
                            <form name="import_excel" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                      
                                <div class="col-sm-4" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" multiple id="department" name="department[]" data-selected-text-format="count">
                                                <option value="">Department(Multiple)</option>
                                                @foreach($dept as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReport('searchMainForm','<?php echo url('search_assigned_okr_employees'); ?>','reload_data_search',
                                                '','<?php echo csrf_token(); ?>')">Search Users</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class=" table-responsive" id="reload_data_search" >

                            
                            </div>
                        </div>
                        

                    </div>
                    
                </div>
                

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->


<script>
    var li_class = document.getElementsByClassName("myUL");
    $(window).click(function() {
        for (var i = 0; i < li_class.length; i++){
            li_class[i].style.display = 'none';
        }

    });
</script>

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

@endsection