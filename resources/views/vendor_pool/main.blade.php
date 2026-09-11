@extends('layouts.app')

@section('content')

     <!-- Default Size -->
     <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">QR CODE</h4>
                    @include('includes/print_pdf',[$exportId = 'qr_code'])
                </div>
                <div class="modal-body" id="qr_code" >
                <?php $companyInfo = \App\Helpers\Utility::companyInfo(); ?>
                    @if(!empty($companyInfo))
                    <h3>{{$companyInfo->name}} Vendor Registration Form</h3>
                    @endif
                    @include('includes.qr_code_link',['dataId'=> '', 'type' => 'vendor_register_form'])
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">View Content</h4>
                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;" id="edit_content">

                </div>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Vendors
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-eye"></i>QR CODE</button>
                        </li>
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                            <li>
                                <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('vendor_pool'); ?>',
                                        '<?php echo url('vendor_pool_delete'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                    <i class="fa fa-trash-o"></i>Delete
                                </button>
                            </li>
                        @endif
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

                <div class="body ">
                    <div class="row">
                        <div class="col-sm-12 pull-right">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="search_vendor" class="form-control"
                                           onkeyup="searchItem('search_vendor','reload_data','<?php echo url('vendor_pool_search') ?>','{{url('vendor_pool')}}','<?php echo csrf_token(); ?>')"
                                           name="search_user" placeholder="Search Vendor" >
                                </div>
                            </div>
                        </div>
                    </div>
                <div class=" table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>
                            <th>View</th>
                            <th>Download MOA</th>
                            <th>Download Bank Reference</th>
                            <th>Download ISO</th>
                            <th>Download HSE Policy</th>
                            <th>Company Profile</th>
                            <th>Name</th>
                            <th>Contact Name</th>
                            <th>Phone No</th>
                            <th>Email</th>
                            <th>Annual Turnover</th>
                            <th>Approval Status</th>
                            <th>Approved By</th>
                            <th>Address</th>
                            <th>Response Message(s)</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)

                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('vendor_pool_view') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-eye fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            
                            <td>
                                @if(!empty($data->memo))
                                <a target="_blank" href="<?php echo URL::to('vendor_pool_download_attachment?file='); ?>{{$data->memo}}">
                                    <i class="fa fa-files-o fa-2x"></i>
                                </a>
                                <button id="file_1_{{$data->id}}" class="btn btn-outline-primary btn-view"
                                        data-file-url="{{ asset('files/'.$data->memo) }}" onclick="previewFile('<?php echo 'file_1_'.$data->id; ?>');">
                                    <i class="fa fa-eye me-2"></i>
                                </button>
                                @endif
                            </td>
                            <td>
                                @if(!empty($data->refrence_docs))
                                <a target="_blank" href="<?php echo URL::to('vendor_pool_download_attachment?file='); ?>{{$data->refrence_docs}}">
                                    <i class="fa fa-files-o fa-2x"></i>
                                </a>
                                <button id="file_2_{{$data->id}}" class="btn btn-outline-primary btn-view"
                                        data-file-url="{{ asset('files/'.$data->refrence_docs) }}" onclick="previewFile('<?php echo 'file_2_'.$data->id; ?>');">
                                    <i class="fa fa-eye me-2"></i>
                                </button>
                                @endif
                            </td>
                            <td>
                                @if(!empty($data->hse_policy_docs))
                                <a target="_blank" href="<?php echo URL::to('vendor_pool_download_attachment?file='); ?>{{$data->hse_policy_docs}}">
                                    <i class="fa fa-files-o fa-2x"></i>
                                </a>
                                <button id="file_3_{{$data->id}}" class="btn btn-outline-primary btn-view"
                                        data-file-url="{{ asset('files/'.$data->hse_policy_docs) }}" onclick="previewFile('<?php echo 'file_3_'.$data->id; ?>');">
                                    <i class="fa fa-eye me-2"></i>
                                </button>
                                @endif
                            </td>
                            <td>
                                @if(!empty($data->qa_docs))
                                <a target="_blank" href="<?php echo URL::to('vendor_pool_download_attachment?file='); ?>{{$data->qa_docs}}">
                                    <i class="fa fa-files-o fa-2x"></i>
                                </a>
                                <button id="file_4_{{$data->id}}" class="btn btn-outline-primary btn-view"
                                        data-file-url="{{ asset('files/'.$data->qa_docs) }}" onclick="previewFile('<?php echo 'file_4_'.$data->id; ?>');">
                                    <i class="fa fa-eye me-2"></i>
                                </button>
                                @endif
                            </td>
                            <td>
                                @if(!empty($data->company_profile))
                                <a target="_blank" href="<?php echo URL::to('vendor_pool_download_attachment?file='); ?>{{$data->company_profile}}">
                                    <i class="fa fa-files-o fa-2x"></i>
                                </a>
                                <button id="file_5_{{$data->id}}" class="btn btn-outline-primary btn-view"
                                        data-file-url="{{ asset('files/'.$data->company_profile) }}" onclick="previewFile('<?php echo 'file_5_'.$data->id; ?>');">
                                    <i class="fa fa-eye me-2"></i>
                                </button>
                                @endif
                            </td>
                            <td>
                                {{$data->company_name}}
                            </td>
                            <td>{{$data->contact_name}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->email}}</td>
                            <td>
                                {{$data->annual_turnover}}
                            </td>
                            <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
                                @if($data->approval_status === 1)
                                    Request Approved
                                @endif
                                @if($data->approval_status === 0)
                                    Processing Request
                                @endif
                                @if($data->approval_status === 2)
                                    Request Denied
                                @endif
                            </td>
                            <td>
                                @if($data->approved_users != '')
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                        <th>Name</th>
                                        <th>Reason</th>
                                        </thead>
                                        <tbody>
                                        @foreach($data->approved_by as $users)
                                            <tr>
                                                <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                                                <td>Approved</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            @if($data->deny_reason != '')
                                                <td>{{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}</td>
                                                <td>Denied: {{$data->deny_reason}}</td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                @endif
                                @if($data->deny_reason != '')
                                    Denied by {{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}
                                     Reason: {{$data->deny_reason}}
                                @endif
                            </td>
                            <td>{{$data->address}}</td>
                            <td>
                                @include('includes/general_response_view')
                            </td>
                            <td>{{$data->created_at}}</td>
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
        getData(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
        //location.hash = page;
    });

    function getData(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

    <script>
        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getSearchData(page);
        });

        $(document).on('click','.search .pagination a', function(event){
            event.preventDefault();

           /* $('li').removeClass('active');

            $(this).parent('li').addClass('active');

            var myurl = $(this).attr('href');*/

            var page=$(this).attr('href').split('page=')[1];
            getSearchData(page);
            //location.hash = page;
        });

        function getSearchData(page){
            var searchVar = $('#search_vendor').val();

            $.ajax({
                url: '<?php echo url('search_vendor'); ?>?page=' + page +'&searchVar='+ searchVar
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