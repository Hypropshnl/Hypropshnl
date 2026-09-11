
@if ($type == 'th')
    <th>
        <div class="row clearfix">
            <form onsubmit="false;" class="form form-horizontal form_new_{{$num}}" method="post" enctype="multipart/form-data">
                <div class="col-sm-8">
                    <div class="form-group">
                        <div class="">
                            <select class="" name="vendor" >
                                <option value="">Select Vendor</option>
                                @if (!empty($rfqBid))
                                    @foreach($rfqBid as $val)
                                        <option value="{{$val->name}}">{{$val->name}}({{$val->email}})</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <div class="">
                            <input type="checkbox" class="form-control" name="check">
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-sm-2">
                <div class="form-group">
                    <i onclick="addTableColumn('#scrollable-table thead #head_tr','#scrollable-table tbody #body_tr','#scrollable-table thead #btn_remove_{{$num}}','{{$rfqMain->id}}','<?php echo url('rfq_bid_report_add_column'); ?>',{{$num}})"
                                                style="color:green" id="btn_remove_{{$num}}" class="add-column-btn fa fa-plus-circle fa-2x pull-right"></i>
            
                </div>
            </div>

        </div>

    </th>
@endif

@if ($type == 'td')
        <td>
            <form onsubmit="false;" class="form form-horizontal form_new_{{$num}}" method="post" enctype="multipart/form-data">
            <table>
                <thead>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </thead>
                <tbody>
                    
                        @php $num2 = $num + 1000 @endphp
                        @foreach ($rfqDetails as $data)
                        @php $num2++ @endphp
                        <tr>
                            <td>
                                <input type="hidden" name="rfqId" value="{{$rfqMain->id}}" >
                                <input type="hidden" name="item_id[]" value="{{$data->inventory->id}}" >
                                <input type="hidden" name="item_desc[]" class="form-control" value="{{$data->rfq_desc}}">
                                
                                <input type="number" class="form-control" name="unit_price[]" id="price_{{$num2}}"
                                    onchange="simpleSumCalc('price_{{$num2}}', 'qty_{{$num2}}', 'amount_{{$num2}}', 'sub_total_{{$num}}', 'amount_sum_{{$num}}', 'discount_{{$num}}', 'discount_perct_{{$num}}', 'tax_{{$num}}', 'tax_perct_{{$num}}', 'grand_total_{{$num}}')"
                                    onkeyup="simpleSumCalc('price_{{$num2}}', 'qty_{{$num2}}', 'amount_{{$num2}}', 'sub_total_{{$num}}', 'amount_sum_{{$num}}', 'discount_{{$num}}', 'discount_perct_{{$num}}', 'tax_{{$num}}', 'tax_perct_{{$num}}', 'grand_total_{{$num}}')"
                                    autocomplete="off" required placeholder="Unit Price">
                                       
                                <input type="hidden" name="qty[]" value="{{$data->quantity}}" id="qty_{{$num2}}">
                            </td>
                            <td>
                                <input type="number" class="amount_sum_{{$num}} form-control" name="item_amount[]" id="amount_{{$num2}}" readonly autocomplete="off" required placeholder="Amount">
                                        
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>Sub Total</td>
                            <td>
                                <input type="number" class="form-control" id="sub_total_{{$num}}" name="sub_total" readonly required placeholder="Sub Total">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="number" class="form-control" id="discount_perct_{{$num}}" name="discount_perct"
                                onkeyup="simpleSumCalcGenPercentage('sub_total_{{$num}}','discount_{{$num}}','discount_perct_{{$num}}','tax_{{$num}}','tax_perct_{{$num}}','grand_total_{{$num}}')"
                                onchange="simpleSumCalcGenPercentage('sub_total_{{$num}}','discount_{{$num}}','discount_perct_{{$num}}','tax_{{$num}}','tax_perct_{{$num}}','grand_total_{{$num}}')"
                                required placeholder="Percentage(%) Discount">
                            </td>
                            <td>
                                <input type="number" class="form-control" id="discount_{{$num}}" name="discount" readonly required placeholder="Discount Amount">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="number" class="form-control" id="tax_perct_{{$num}}" name="tax_perct"
                                onkeyup="simpleSumCalcGenPercentage('sub_total_{{$num}}','discount_{{$num}}','discount_perct_{{$num}}','tax_{{$num}}','tax_perct_{{$num}}','grand_total_{{$num}}')"
                                onchange="simpleSumCalcGenPercentage('sub_total_{{$num}}','discount_{{$num}}','discount_perct_{{$num}}','tax_{{$num}}','tax_perct_{{$num}}','grand_total_{{$num}}')"
                                required placeholder="Percentage(%) Tax">
                            </td>
                            <td>
                                <input type="number" class="form-control" id="tax_{{$num}}" name="tax" readonly required placeholder="Tax Amount">
                            </td>
                        </tr>
                        <tr>
                            <td>Grand Total</td>
                            <td>
                                <input type="number" class="form-control" id="grand_total_{{$num}}" name="grand_total" readonly required placeholder="Amount">
                            </td>
                        </tr>
                        <tr>
                            <td>Nil</td>
                            <td>Nil</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="col-sm-12">
                                    <select  class="form-control vendor_multi_select" multiple id="" name="vendors[]" data-live-search="true">
                                        <option value="">Select Vendor(s)</option>
                                        @if (!empty($rfqBid))
                                            @foreach($rfqBid as $val)
                                                <option value="{{$val->email}}">{{$val->name}}({{$val->email}})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                        
                                </div>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                    
                        <tr>
                            <td>
                                    <div class="col-sm-12">
                                        <div class="form-line">
                                            <textarea rows="10" cols="50" type="text" class="form-control" name="comment" placeholder="Comment"></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{$rfqMain->id}}" name="rfq_id" />
                            </td>
                            <td>
                                @if($rfqMain->assigned_user == Auth::user()->id || $rfqMain->created_by == Auth::user()->id)
                                <button onsubmit="false" class="btn btn-info btn-sm" onclick="submitDefaultClassNoModal('form_new_{{$num}}','<?php echo url('rfq_bid_report_create'); ?>','','','<?php echo csrf_token(); ?>')"
                                >Save and Send</button>
                                @else
                                <button class="btn btn-default" disabled></button>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-default btn-sm" disabled >None</button>
                            </td>
                            <td>
                                <button class="btn btn-default btn-sm" disabled>None</button>
                            </td>
                            
                        </tr>

                </tbody>
            </table>
            </form>
        </td>
@endif

<script type="text/javascript">
    $('.vendor_multi_select').multiselect({
    buttonWidth: '400px', // Set width to 100% of its parent
    nonSelectedText: 'Select Vendor(s)'
    });

</script>