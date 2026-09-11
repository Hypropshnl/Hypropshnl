<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Company Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="company_name" value="{{$edit->company_name}}" placeholder="Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Currency*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="currency" placeholder="currency" required>
                            <option value="{{$edit->currency}}">{{$edit->currencyData->code}} ({{$edit->currencyData->symbol}}) ({{$edit->currencyData->currency}})</option>
                            @foreach($currency as $curr)
                            <option value="{{$curr->id}}">{{$curr->code}} ({{$curr->symbol}}) ({{$curr->currency}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Address</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="address" value="{{$edit->address}}" placeholder="Address" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Country*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="country" placeholder="country" required>
                            <option value="">{{$edit->countryData->countryName}}</option>
                            @foreach($country as $curr)
                            <option value="{{$curr->id}}">{{$curr->countryName}} ({{$curr->countryCode}}) ({{$curr->continentName}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>City</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="city" value="{{$edit->city}}" placeholder="City" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Company/RC. No.</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="company_no" value="{{$edit->company_no}}" placeholder="company_no" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Website</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="website" value="{{$edit->website}}" placeholder="website" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Email</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="email" value="{{$edit->email}}" placeholder="Email" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Fax*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="fax" value="{{$edit->fax}}" placeholder="Fax" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Phone</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="phone" value="{{$edit->phone}}" placeholder="Phone" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Contact Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="contact_name" value="{{$edit->contact_name}}" placeholder="Contact Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Contact Email </b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="contact_email" value="{{$edit->contact_email}}" placeholder="Contact Email" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Contact Designation</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="contact_designation" value="{{$edit->contact_designation}}" placeholder="Contact Designation" required>
                    </div>
                </div>
            </div>
            
        </div>

        

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>VAT Registration No</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="vat_registration_no" value="{{$edit->vat_no}}" placeholder="VAT REGISTERATION NO" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Tax Identification No</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="tax_no" value="{{$edit->tax_no}}" placeholder="Tax Identification No" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Bank Branch</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="bank_branch" value="{{$edit->bank_branch}}" placeholder="Bank Branch" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Bank Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="bank_name" value="{{$edit->bank_name}}" placeholder="bank_name">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Account Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control " name="account_name" value="{{$edit->bank_account_name}}" placeholder="account name" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Account No</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="account_no" value="{{$edit->bank_account_no}}" placeholder="Account No" >
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <div class="row clearfix">
            <!-- <div class="col-sm-12">
                <b>Job Category (Please state the category of jobs done by your company) </b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="job_category" placeholder="Category of jobs done" required>{{$edit->job_category}}</textarea>
                    </div>
                </div>
            </div> -->

        </div>
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Bank Sort Code</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="bank_sort_code" value="{{$edit->bank_sort_code}}" placeholder="Bank Sort Code" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Annual Turnover</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="annual_turnover" value="{{$edit->annual_turnover}}" placeholder="Annual Turnover" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Services/Product Category</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control show-tick" name="job_category[]" data-selected-text-format="count" required>
                            @foreach($inventorySubcategories as $data)
                            <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Do you have a written Health, Safety and Environment policy?*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="hse_cert" placeholder="HSE Certificate" required>
                            <option value="{{$edit->hse_policy}}" selected>{{$edit->hse_policy}}</option>
                            <option value="Yes" >Yes</option>
                            <option value="No" >No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <b>Do you hold an ISO certification?*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="iso_cert" placeholder="ISO Certificate" required>
                            <option value="{{$edit->qa_cert}}" selected>{{$edit->qa_cert}}</option>
                            <option value="Yes" >Yes</option>
                            <option value="No" >No</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<script>
    // $(function() {
    //     $( ".datepicker1" ).datepicker({
    //         changeMonth: true,
    //         changeYear: true,
    //         dateFormat: "yy-mm-dd"
    //         /*yearRange: "-90:+00"*/

    //     });
    // });
</script>