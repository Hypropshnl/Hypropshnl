
<form name="import_excel" id="convertMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        @php 
                        $requestDesc = '';
                         foreach($purchaseOrder->po as $data){
                                $requestDesc .= $data->po_desc.', ';
                         }
                        @endphp
                        <textarea rows="5" type="text" class="form-control" name="request_description" placeholder="Request Description">Purchase Order({{$purchaseOrder->po_number}}), Fund Requisition for {{$requestDesc}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="request_category" >
                            <option value="">Request Category</option>
                            @foreach($reqCat as $ap)
                                <option value="{{$ap->id}}">{{$ap->request_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" onchange="checkProject('request_type2','project_id2');" id="request_type2" name="request_type" >
                            <option value="">Request Type</option>
                            @foreach($reqType as $ap)
                                <option value="{{$ap->id}}">{{$ap->request_type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" id="project_id2" style="display:none;">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" readonly id="" name="project" >
                            <option value="">Select Project</option>
                            @foreach($project as $ap)
                                <option value="{{$ap->project->id}}">{{$ap->project->project_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
        @php $amount = ($purchaseOrder->currency->code == session('currency')['code']) ? $purchaseOrder->sum_total : $purchaseOrder->trans_total; @endphp
        @php $transType = ($purchaseOrder->currency->code == session('currency')['code']) ? $transactionTypes['1'] : $transactionTypes['2']; @endphp
        @php $currId = ($purchaseOrder->currency->code == session('currency')['code']) ? $purchaseOrder->default_curr : $purchaseOrder->trans_curr; @endphp
        @php $curr = ($purchaseOrder->currency->code == session('currency')['code']) ? $purchaseOrder->currency->code : Utility::defaultCurrency(); @endphp
        <div class="row clear-fix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control"  name="transaction_type" >
                            <option value="1" selected>{{$transType}}</option>
                        </select>
                    </div>
                </div>
            </div>

            @if($purchaseOrder->currency->code !== session('currency')['code'])
            <div class="col-sm-4" id="currency_id" >
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control"  id="" name="currency" >
                            <option selected value="{{$currId}}">{{$curr}}</option>
                        </select>
                    </div>
                </div>
            </div>
            @endif
            <input type="hidden" class="" value="{{$purchaseOrder->mr_id}}" name="material_request"  />
            <input type="hidden" class="" value="{{$purchaseOrder->id}}" name="purchase_order"  />
        
        </div>

        <div class="row clear-fix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" readonly value="{{$amount}}" class="form-control" name="amount" placeholder="Amount">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" multiple="multiple" class="form-control" name="attachment[]" placeholder="Attachment">
                    </div>
                </div>
            </div>
            <input type="hidden"  name="user" />


        </div>

    </div>


</form>