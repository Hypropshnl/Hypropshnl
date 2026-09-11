<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Contact Type*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="contact_type" placeholder="Contact Type" required>
                            @if($edit->company_type == \App\Helpers\Utility::CUSTOMER)
                            <option value="{{\App\Helpers\Utility::CUSTOMER}}" selected>Customer</option>
                            @else
                            <option value="{{\App\Helpers\Utility::VENDOR}}" selected>Vendor</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Currency*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="currency" placeholder="currency" required>
                            <option value="{{$edit->currency_id}}" selected>{{$edit->currency->currency}} ({{$edit->currency->code}})</option>
                            @foreach($currency as $curr)
                                <option value="{{$curr->id}}">{{$curr->code}} ({{$curr->symbol}}) ({{$curr->currency}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @if($edit->company_type == \App\Helpers\Utility::VENDOR)
            <div class="col-sm-4">
                <b>Services/Product Category (Multiple Select)</b><span style="color:red">*</span>
                <div class="dropdown-container">
                    <div class="dropdown-toggle-custom">Select job categories</div>
                    <div class="dropdown-menu-custom">
                        @foreach($inventoryCategory as $data)
                            <div class="accordion-item">
                                <div class="accordion-header">{{$data->category_name}}</div>
                                <ul class="accordion-content">
                                    @foreach($data->subcategoryMany as $sub)
                                    @php $checked = in_array($sub->id, $jobCategories) ? 'checked' : ''; @endphp
                                        <li class="sublist-item">
                                            <input type="checkbox" name="job_category[]" value="{{$sub->id}}" {{$checked}} />
                                            {{$sub->name}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name}}" name="name" placeholder="Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Address</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->address}}" name="address" placeholder="Address" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>City</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->city}}" name="city" placeholder="City" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Zip Code*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="zip_code" value="{{$edit->zip_code}}" placeholder="Zip Code" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Phone</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->phone}}" name="phone" placeholder="Phone" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Contact No</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="contact_no" value="{{$edit->contact_no}}" placeholder="Contact No" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Contact Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->contact_name}}" name="contact_name" placeholder="Contact Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Search Key</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->search_key}}" name="search_key" placeholder="Search Key" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Company Description</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->company_desc}}" name="company_desc" placeholder="Company Description" required>
                    </div>
                </div>
            </div>
        </div>

            <div class="row clearfix">
                <div class="col-sm-4">
                    <b>Website</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$edit->website}}" name="website" placeholder="website" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <b>Email 1</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$edit->email1}}" name="email1" placeholder="Email 1" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <b>Email 2</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$edit->email2}}" name="email2" placeholder="Email 2" required>
                        </div>
                    </div>
                </div>

            </div>


        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Company/RC. No.</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control " value="{{$edit->company_no}}" name="company_no" placeholder="company_no" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Payment Terms</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->payment_terms}}" name="pay_terms" placeholder="Payment Terms" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Tax Identification No</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->tax_id_no}}" name="tax_no" placeholder="Tax Identification No" >
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Bank Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->bank_name}}" name="bank_name"  placeholder="bank_name">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Account Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->account_name}}" name="account_name" placeholder="account name" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Account No</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->account_name}}" name="account_no" placeholder="Account No" >
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Logo</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" class="form-control" name="logo" >
                    </div>
                </div>
            </div>

        </div>

    </div>

    <input type="hidden" name="prev_photo" value="{{$edit->photo}}" >
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>

<script>
  function updateSelectedCount() {
    const selected = $("input[name='job_category[]']:checked").length;
    $(".dropdown-toggle-custom").text(
      selected > 0 ? `${selected} selected` : "Select job categories"
    );
  }

  $(document).ready(function () {
    const $dropdown = $(".dropdown-menu-custom");

    // Toggle dropdown like a select
    $(".dropdown-toggle-custom").on("click", function (e) {
      e.stopPropagation();
      $dropdown.slideToggle(150);
    });

    // Close on outside click
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".dropdown-container").length) {
        $dropdown.slideUp(150);
      }
    });

    // Accordion toggle
    $(".accordion-header").on("click", function () {
      $(this).next(".accordion-content").slideToggle(150).toggleClass("open-sub");
    });

    // Select sublist by clicking full item
    $(".sublist-item").on("click", function (e) {
      if (e.target.tagName !== "INPUT") {
        const $checkbox = $(this).find("input[type='checkbox']");
        $checkbox.prop("checked", !$checkbox.prop("checked"));
      }
      updateSelectedCount();
    });

   
    updateSelectedCount();
  });
</script>