<form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-sm-4">
        <label>Month/Date</label>
        <div class="form-group">
            <div class="form-line">
                <input type="date" class="form-control datepicker" name="date" placeholder="Month/Date" >
            </div>
        </div>
    </div>
    <div class="col-sm-3 " id="" style="">
       <div class="form-group">
            <button type="button" onclick="submitDefaultNoFormModal('createMainForm','<?php echo url('process_external_payroll_v2'); ?>',
                '','','<?php echo csrf_token(); ?>','details')" class="btn btn-success">
                <i class="fa fa-check-square-o"></i>Process Salary
            </button>
        </div>
    </div>
</div>

<table class="table table-bordered table-hover table-striped " id="main_table1">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Name</th>
        <th>Salary</th>
        <th>Rate {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Total Days</th>
        <th>Days of Engagement</th>
        <th>Extended Hours Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Gross Payment {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Basic {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Pension {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Payee {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Net {{\App\Helpers\Utility::defaultCurrency()}}</th>
    </tr>
    </thead>
    <tbody>
        
            @foreach($mainData as $data)
                @if(!empty($data->salary->rate))
                    <tr>
                        <td scope="row">
                            <input value="{{$data->id}}" name="checkbox[]" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                        </td>
                        <td>
                            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_user_form') ?>','<?php echo csrf_token(); ?>')">{{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}</a>
                        </td>
                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->               
                        <td>
                            {{$data->salary->salary_name}}
                        </td>
                        <td>
                            {{Utility::numberFormat($data->salary->rate)}}
                            <input type="hidden" name="rate[]" id="rate_{{$data->uid}}" value="{{$data->salary->rate}}">
                        </td>
                        <td>{{$data->salary->days_hours}}</td>
                        <td>                    
                            <div class="form-line">
                                <input type="number"  name="days_engage[]" 
                                onchange="payroll_v2('{{$data->uid}}', 'rate', 'days_engage', 'ex_hours', 'gross', 'basic', 'pension', 'paye', 'net_pay')"
                                onkeyup="payroll_v2('{{$data->uid}}', 'rate', 'days_engage', 'ex_hours', 'gross', 'basic', 'pension', 'paye', 'net_pay')"
                                id="days_engage_{{$data->uid}}" placeholder="Days of engagement">
                            </div>
                        </td>

                        <td>
                            <input type="number" name="extended_hours_amount[]" 
                            onchange="payroll_v2('{{$data->uid}}', 'rate', 'days_engage', 'ex_hours', 'gross', 'basic', 'pension', 'paye', 'net_pay')"
                            onkeyup="payroll_v2('{{$data->uid}}', 'rate', 'days_engage', 'ex_hours', 'gross', 'basic', 'pension', 'paye', 'net_pay')"
                            id="ex_hours_{{$data->uid}}" />
                        </td>
                        <td>
                            <input type="number" name="gross[]" id="gross_{{$data->uid}}" value="{{$data->salary->gross_pay}}" readonly />
                            <input type="hidden" name="gross_hidden[]" id="gross_hidden_{{$data->uid}}">
                        </td>
                        <td>
                            <input type="number" name="basic[]" id="basic_{{$data->uid}}" readonly />
                            <input type="hidden" name="basic_hidden[]" id="basic_hidden_{{$data->uid}}">
                        </td>
                        <td>
                            <input type="number" name="pension[]" id="pension_{{$data->uid}}" readonly />
                            <input type="hidden" name="pension_hidden[]" id="pension_hidden_{{$data->uid}}">
                        </td>
                        <td>
                            <input type="number" name="paye[]" id="paye_{{$data->uid}}" readonly />
                            <input type="hidden" name="paye_hidden[]" id="paye_hidden_{{$data->uid}}">
                        </td>
                        <td>
                            <input type="number" name="net_pay[]" id="net_pay_{{$data->uid}}" value="{{$data->salary->net_pay}}" readonly />
                            <input type="hidden" name="net_pay_hidden[]" id="net_pay_hidden_{{$data->uid}}">
                        </td>
                        <input type="hidden" name="salary_id[]" id="" value="{{$data->salary->id}}">
                        <input type="hidden" name="user_id[]" id="" value="{{$data->id}}">
                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                    </tr>
                @endif
            @endforeach
        
    </tbody>
</table>
</form>

{{-- <script>
    $('.tbl_order').on('scroll', function () {
        $(".tbl_order > *").width($(".tbl_order").width() + $(".tbl_order").scrollLeft());
    });
</script> --}}
