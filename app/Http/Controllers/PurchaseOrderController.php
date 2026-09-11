<?php

namespace App\Http\Controllers;

use App\Helpers\Approve;
use App\Helpers\Utility;
use App\Helpers\Notify;
use App\Helpers\Numbering;
use App\model\Currency;
use App\model\Department;
use App\model\Inventory;
use App\model\InventoryBom;
use App\model\POApprovalDept;
use App\model\POApprovalSys;
use App\model\PoExtension;
use App\model\ProjectPoApprovalDept;
use App\model\ProjectPoApprovalSys;
use App\model\ProjectTeam;
use App\model\PurchaseOrder;
use App\model\Stock;
use App\model\VendorCustomer;
use App\model\RFQ;
use App\model\RFQExtension;
use App\model\QuoteExtension;
use App\model\Quote;
use App\model\StoreLocations;
use App\model\UnitMeasure;
use App\User;
use View;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $mainData = PoExtension::specialColumnsOrPage22('created_by','assigned_user',Auth::user()->id);
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        Approve::filterData($mainData);
        $store = StoreLocations::getAllData();
        $dept = Department::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('purchase_order.reload',array('mainData' => $mainData, 'project' => $project, 'dept' => $dept))->render());

        }else{
            return view::make('purchase_order.main_view')->with('mainData',$mainData)->with('project',$project)
            ->with('store',$store)->with('dept',$dept);
        }

    }

    public function myRequests(Request $request)
    {
    
        $approveSys = POApprovalSys::getAllData();
        $projectApproveSys = ProjectPoApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $projectApproveAccess = Approve::approveAccess($projectApproveSys);
        $mainData = POExtension::specialColumnsCustomPage('complete_status',Utility::ZERO, Utility::P100);
        Approve::filterData($mainData);
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $currSymbol = session('currency')['symbol'];

        if ($request->ajax()) {
            return \Response::json(view::make('purchase_order.request_reload',array('mainData' => $mainData,
            'project' => $project, 'appAccess' => $approveAccess, 'curr_symbol' => $currSymbol))->render());

        }else{
            return view::make('purchase_order.request')->with('mainData',$mainData)
                ->with('project',$project)->with('appAccess',$approveAccess)->with('curr_symbol',$currSymbol)
                ->with('projectAppAccess',$projectApproveAccess);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),PurchaseOrder::$mainRules);

        if($validator->passes()){
            
                

            try{
                

                    //ITEM VARIABLES
                    $invClass = Utility::jsonUrlDecode($request->input('inv_class')); $itemDesc = Utility::jsonUrlDecode($request->input('item_desc'));
                    $warehouse = Utility::jsonUrlDecode($request->input('warehouse')); $quantity = Utility::jsonUrlDecode($request->input('quantity'));
                    $unitCost = Utility::jsonUrlDecode($request->input('unit_cost')); $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure'));
                    $quantityReserved = Utility::jsonUrlDecode($request->input('quantity_reserved')); $quantityReceived = Utility::jsonUrlDecode($request->input('quantity_received'));
                    $planned = Utility::jsonUrlDecode($request->input('planned')); $expected = Utility::jsonUrlDecode($request->input('expected'));
                    $promised = Utility::jsonUrlDecode($request->input('promised')); $bOrderNo = Utility::jsonUrlDecode($request->input('b_order_no'));
                    $bOrderLineNo = Utility::jsonUrlDecode($request->input('b_order_line_no')); $shipStatus = Utility::jsonUrlDecode($request->input('ship_status'));
                    $statusComment = Utility::jsonUrlDecode($request->input('status_comment')); $tax = Utility::jsonUrlDecode($request->input('tax'));
                    $taxPerct = Utility::jsonUrlDecode($request->input('tax_perct')); $taxAmount = Utility::jsonUrlDecode($request->input('tax_amount'));
                    $discountPerct = Utility::jsonUrlDecode($request->input('discount_perct')); $discountAmount = Utility::jsonUrlDecode($request->input('discount_amount'));
                    $subTotal = Utility::jsonUrlDecode($request->input('sub_total')); $store = Utility::jsonUrlDecode($request->input('store'));

                    //ACCOUNT VARIABLES
                    $accClass = Utility::jsonUrlDecode($request->input('acc_class')); $accDesc = Utility::jsonUrlDecode($request->input('acc_desc'));
                    $accRate = Utility::jsonUrlDecode($request->input('acct_rate')); $accTax = Utility::jsonUrlDecode($request->input('acc_tax'));
                    $accTaxPerct = Utility::jsonUrlDecode($request->input('acc_tax_perct')); $accTaxAmount = Utility::jsonUrlDecode($request->input('acc_tax_amount'));
                    $accDiscountPerct = Utility::jsonUrlDecode($request->input('acc_discount_perct')); $accDiscountAmount = Utility::jsonUrlDecode($request->input('acc_discount_amount'));
                    $accSubTotal = Utility::jsonUrlDecode($request->input('acc_sub_total'));

                    //GENERAL VARIABLES
                    $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor'); $dueDate = $request->input('due_date');
                    $poStatus = $request->input('po_status'); $vendorInvoiceNo = $request->input('vendor_invoice_no');
                    $user = $request->input('user'); $shipCountry = $request->input('ship_country'); $shipCity = $request->input('ship_city');
                    $shipContact = $request->input('ship_contact'); $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
                    $shipAddress = $request->input('ship_address'); $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
                    $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
                    $message = Utility::urlDecode($request->input('mail_message')); $oneTimeDiscount = $request->input('one_time_discount_amount'); $oneTimePerct = $request->input('one_time_perct');
                    $oneTimeTaxAmount = $request->input('one_time_tax_amount'); $taxType = $request->input('tax_type');
                    $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');
                    $rfqNo = $request->input('rfq_no'); $mailCopy = $request->input('mail_copy');
                    $purchaseOrderNo = ($request->input('po_number') !== null) ? $request->input('po_number') : Numbering::purchaseOrder('po_extention');
                    $dept = $request->input('department'); $approvalFiles = $request->input('approval_files');
                    $reqDept = (!empty($dept)) ? $dept : Auth::user()->dept_id; $project = $request->input('project');
                    
                    $vendor = VendorCustomer::firstRow('id',$prefVendor);
                    $curr = Currency::firstRow('id',$vendor->currency_id);
                    $files = $request->file('file');
                    $attachment = [];
                    $approvalAttachment = [];
                    $mailFiles = [];

                    //APPROVALS
                    $approveDept = POApprovalDept::firstRow('dept',$reqDept);
                    if(empty($approveDept)){
                        return response()->json([
                            'message' => 'warning',
                            'message2' => 'There is no approval system assigned to your department, contact admin for help'
                        ]);
                    }

                    $approveSys = POApprovalSys::firstRow('id',$approveDept->approval_id);

                    //CHECK IF REQUEST HAS A PROJECT AND USE A PROJECT APPROVAL SYSTEM
                    $approveProjectDept = ProjectPoApprovalDept::firstRow('project_id',$project);
                    if(!empty($approveProjectDept)){
                        $approveDept = $approveProjectDept;
                        $approveSys = ProjectPoApprovalSys::firstRow('id',$approveDept->approval_id);
                    }
                        

                    if(empty($approveDept)){
                        return response()->json([
                            'message' => 'warning',
                            'message2' => 'There is no approval system assigned to this project, contact admin for help'
                        ]);
                    }

                    $approvalArray = json_decode($approveSys->level_users,true);    //LIST OF APPROVAL USERS AND THERE LEVEL
                    $approvalLevel = json_decode($approveSys->levels,true); //ALL THE LEVELS DECODED
                    $approvalUsers = json_decode($approveSys->users,true);  //ALL THE USERS DECODED
                    $approveUsers = $approveSys->users; $approveLevels = $approveSys->levels;   //USERS AND LEVELS NOT DECODED
                    $holdUser = ''; //ID OF NEXT PERSON TO APPROVE
                    $appLevel = [];
                    $appUser = [];

                    Approve::processApproval($approvalArray,$approvalLevel,$approvalUsers,$approveUsers,$approveLevels,$appLevel,$appUser,$holdUser);

                    if($holdUser != '') {
                        $firstUser = User::firstRow('id', $holdUser);
                        $email = $firstUser->email;
                        $fullName = $firstUser->firstname . ' ' . $firstUser->lastname; //FULL NAME OF NEXT PERSON TO APPROVE REQUEST
                        $senderName = Auth::user()->firstname . ' ' . Auth::user()->lastname;
                        $subject = 'A New Purchase Order from ' . $senderName;
                        
                        $emailContent = new \stdClass();
                        $emailContent->user_id = Auth::user()->id;
                        $emailContent->type = 'next_approval';
                        $emailContent->name = $fullName;
                        $emailContent->sender_name = $senderName;
                        $emailContent->desc = $purchaseOrderNo;
                        $emailContent->amount = $grandTotal;
                        Notify::sendMail('requisition.send_request',$emailContent,$email,$fullName,$subject);
                    }
                
                    $reqStatus = ($holdUser == '') ? Utility::APPROVED : Utility::PROCESSING;

                    if($files != ''){
                        foreach($files as $file){
                            //return$file;
                            $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();
        
                            //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                            //array_push($cdn_images,$file_name);
                            $attachment[] =  $file_name;
                            $mailFiles[] = Utility::FILE_URL($file_name);
        
                            $file->move(
                                Utility::FILE_URL(), $file_name
                            );
        
                        }
                    }

                    if($approvalFiles != ''){
                        foreach($approvalFiles as $file){
                            //return$file;
                            $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();
        
                            //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                            //array_push($cdn_images,$file_name);
                            $approvalAttachment[] =  $file_name;
        
                            $file->move(
                                Utility::FILE_URL(), $file_name
                            );
        
                        }
                    }


                    $uid = Utility::generateUID('po_extention');

                    $dbDATA = [
                        'uid' => $uid,
                        'project_id' => $project,
                        'dept_id' => $reqDept,
                        'assigned_user' => $user,
                        'po_number' => $purchaseOrderNo,
                        'vendor_invoice_no' => $vendorInvoiceNo,
                        'rfq_no' => $rfqNo,
                        'mails' => $emails,
                        'mail_copy' => $mailCopy,
                        'sum_total' => $grandTotal,
                        'trans_total' => $grandTotalVendorCurr,
                        'discount_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
                        'discount_trans' => $oneTimeDiscount,
                        'discount_perct' => $oneTimePerct,
                        'discount_type' => $discountType,
                        'tax_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
                        'tax_trans' => $oneTimeTaxAmount,
                        'tax_perct' => $oneTimeTaxPerct,
                        'tax_type' => $taxType,
                        'message' => $message,
                        'attachment' => json_encode($attachment,true),
                        'approval_docs' => json_encode($approvalAttachment,true),
                        'default_curr' => Utility::currencyArrayItem('id'),
                        'trans_curr' => $curr->id,
                        'vendor' => $prefVendor,
                        'due_date' => Utility::standardDate($dueDate),
                        'post_date' => Utility::standardDate($postingDate),
                        'ship_to_city' => $shipCity,
                        'ship_address' => $shipAddress,
                        'ship_to_country' => $shipCountry,
                        'ship_to_contact' => $shipContact,
                        'ship_method' => $shipMethod,
                        'ship_agent' => $shipAgent,
                        'approval_json' => $approvalArray,
                        'approval_level' => $approveLevels,
                        'approval_user' => $approveUsers,
                        'approval_id' => $approveSys->id,
                        'approval_status' => $reqStatus,
                        'complete_status' => $reqStatus,
                        'purchase_status' => $poStatus,
                        'mail_status' => $mailOption,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    $accDbData = [
                        'uid' => $uid
                    ];
                    $poDbData = [
                        'uid' => $uid
                    ];

                    if(count($accClass) != count($accRate) && count($invClass) != count($subTotal)) {
                        return response()->json([
                            'message' => 'warning',
                            'message2' => 'Please ensure that all account selected has a rate'
                        ]);
                    }

                    $mainPo = PoExtension::create($dbDATA);
                    $accDbData['po_id'] = $mainPo->id;
                    $poDbData['po_id'] = $mainPo->id;

                    //LOOP THROUGH ACCOUNTS
                    if(count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)){
                        for($i=0;$i<count($accClass);$i++){
                            $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass,$i,0);
                            $accDbData['po_desc'] = Utility::checkEmptyArrayItem($accDesc,$i,'');
                            $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($accRate,$i,0);
                            $accDbData['unit_cost'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accRate,$i,0),$postingDate);
                            $accDbData['tax_id'] = Utility::checkEmptyArrayItem($accTax,$i,0);
                            $accDbData['tax_perct'] = Utility::checkEmptyArrayItem($accTaxPerct,$i,0);
                            $accDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($accTaxAmount,$i,0);
                            $accDbData['tax_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accTaxAmount,$i,0),$postingDate);
                            $accDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($accDiscountAmount,$i,0);
                            $accDbData['discount_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accDiscountAmount,$i,0),$postingDate);
                            $accDbData['discount_perct'] = Utility::checkEmptyArrayItem($accDiscountPerct,$i,0);
                            $accDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($accSubTotal,$i,0);
                            $accDbData['extended_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accSubTotal,$i,0),$postingDate);
                            $accDbData['status'] = Utility::STATUS_ACTIVE;
                            $accDbData['created_by'] = Auth::user()->id;

                            PurchaseOrder::create($accDbData);

                        }

                    }

                    //LOOP THROUGH ITEMS
                    if(count($invClass) == count($subTotal)){
                        for($i=0;$i<count($invClass);$i++){
                            $binStock = Inventory::firstRow('id',$invClass);
                            $poDbData['item_id'] = Utility::checkEmptyArrayItem($invClass,$i,0);
                            $poDbData['bin_stock'] = $binStock->inventory_type;
                            $poDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure,$i,0);
                            $poDbData['quantity'] = Utility::checkEmptyArrayItem($quantity,$i,0);
                            $poDbData['po_desc'] = Utility::checkEmptyArrayItem($itemDesc,$i,'');
                            $poDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost,$i,0);
                            $poDbData['unit_cost'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($unitCost,$i,0),$postingDate);
                            $poDbData['tax_id'] = Utility::checkEmptyArrayItem($tax,$i,0);
                            $poDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct,$i,0);
                            $poDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount,$i,0);
                            $poDbData['tax_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($taxAmount,$i,0),$postingDate);
                            $poDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount,$i,0);
                            $poDbData['discount_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($discountAmount,$i,0),$postingDate);
                            $poDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct,$i,0);
                            $poDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal,$i,0);
                            $poDbData['extended_amount'] = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($subTotal,$i,0),$postingDate);

                            $statComHist = [];
                            if(Utility::checkEmptyArrayItem($shipStatus,$i,0) != 0){
                                $statComHist[Utility::checkEmptyArrayItem($shipStatus,$i,0)] = Utility::checkEmptyArrayItem($statusComment,$i,'');

                            }

                            $poDbData['store_id'] = Utility::checkEmptyArrayItem($store,$i,'');
                            $poDbData['ship_to_whse'] = Utility::checkEmptyArrayItem($warehouse,$i,'');
                            $poDbData['reserved_quantity'] = Utility::checkEmptyArrayItem($quantityReserved,$i,'');
                            $poDbData['received_quantity'] = Utility::checkEmptyArrayItem($quantityReceived,$i,'');
                            $poDbData['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($planned,$i,''));
                            $poDbData['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($promised,$i,''));
                            $poDbData['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($expected,$i,''));
                            $poDbData['po_status'] = Utility::checkEmptyArrayItem($shipStatus,$i,'');
                            $poDbData['po_status_comment'] = Utility::checkEmptyArrayItem($statusComment,$i,'');
                            $poDbData['status_comment_history'] = json_encode($statComHist,true);
                            $poDbData['blanket_order_no'] = Utility::checkEmptyArrayItem($bOrderNo,$i,'');
                            $poDbData['blanket_order_line_no'] = Utility::checkEmptyArrayItem($bOrderLineNo,$i,'');
                            $poDbData['status'] = Utility::STATUS_ACTIVE;
                            $poDbData['created_by'] = Auth::user()->id;

                            PurchaseOrder::create($poDbData);

                        }

                    }

                    // if($mailOption == Utility::STATUS_ACTIVE){
                    //     $poId = $mainPo->id;
                    //     $getPo = PoExtension::firstRow('id',$poId);
                    //     $getPoData = PurchaseOrder::specialColumns('uid',$getPo->uid);
                    //     Utility::fetchBOMItems($getPoData);
                    //     $currencyData = Currency::firstRow('id',$getPo->trans_curr);

                    //     $mailContent = [];

                    //     $mailCopyContent = ($mailCopy != '') ? explode(',',$mailCopy) : [];
                    //     $mailContent['copy'] = $mailCopyContent;
                    //     $mailContent['fromEmail']= Auth::user()->email;
                    //     $mailContent['po']= $getPo;
                    //     $mailContent['poData'] = $getPoData;
                    //     $mailContent['attachment'] = $mailFiles;
                    //     $mailContent['currency'] = $currencyData->code;

                    //     //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                    //     if($emails != ''){
                    //         $mailToArray = explode(',',$emails);
                    //         if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                    //             foreach($mailToArray as $data) {
                    //                 Notify::poMail('mail_views.purchase_order', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
                    //             }
                    //         }
                    //     }

                    // }


                

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }catch(Exception $e){
                return response()->json([
                    'message2' => 'An error occurred, please try again',
                    'message' => 'Error message'
                ]);
            }

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }


    public function editForm(Request $request)
    {
        //
        $po = PoExtension::firstRow('id',$request->input('dataId'));
        $poData = PurchaseOrder::specialColumns('po_id',$po->id);
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $store = StoreLocations::getAllData();
        $dept = Department::getAllData();
        return view::make('purchase_order.edit_form')->with('edit',$po)->with('poData',$poData)->with('project',$project)
        ->with('store',$store)->with('dept',$dept);

    }

    public function editFormMini(Request $request)
    {
        //
        $po = PoExtension::firstRow('id',$request->input('dataId'));
        $poData = PurchaseOrder::specialColumns('po_id',$po->id);
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $store = StoreLocations::getAllData();
        $dept = Department::getAllData();
        return view::make('purchase_order.edit_form_mini')->with('edit',$po)->with('poData',$poData)->with('project',$project)
        ->with('store',$store)->with('dept',$dept);

    }

    public function printPreview(Request $request)
    {
        //
        $currency = Utility::defaultCurrency();
        $type = $request->input('type');
        $po = PoExtension::firstRow('id',$request->input('dataId'));
        $poData = PurchaseOrder::specialColumns('po_id',$po->id);
        Utility::fetchBOMItems($poData);  //ADD BOM ITEMS TO INVENTORY ITEM
        if($type == 'vendor' && !empty($po)){
            $data = Currency::firstRow('id',$po->trans_curr);
            $currency = $data->code;

            return view::make('purchase_order.print_preview_vendor')->with('po',$po)->with('poData',$poData)
                ->with('currency',$currency);
        }
        return view::make('purchase_order.print_preview_default')->with('po',$po)->with('poData',$poData)
            ->with('currency',$currency);

    }

    //FETCH QUOTE DATA FOR DISPLAY IN CONVERT TO FORM MODAL DISPLAY
    public function convertQuoteForm(Request $request)
    {
        //
        $po = QuoteExtension::firstRow('id',$request->input('dataId'));
        $QuoteData = Quote::specialColumns('Quote_id',$po->id);
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $store = StoreLocations::getAllData();
        $dept = Department::getAllData();
        return view::make('purchase_order.convert_quote_form')->with('edit',$po)->with('quoteData',$QuoteData)
        ->with('project',$project)->with('store',$store)->with('dept',$dept);

    }

    //FETCH RFQ DATA FOR DISPLAY IN CONVERT TO FORM MODAL DISPLAY
    public function convertRfqForm(Request $request)
    {
        //
        $rfq = RFQExtension::firstRow('id',$request->input('dataId'));
        $rfqData = RFQ::specialColumns('rfq_id',$rfq->id);
        $unitMeasure = UnitMeasure::paginateAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $store = StoreLocations::getAllData();
        $dept = Department::getAllData();
        return view::make('purchase_order.convert_rfq_form')->with('edit',$rfq)->with('rfqData',$rfqData)
            ->with('unitMeasure',$unitMeasure)->with('project',$project)->with('store',$store)->with('dept',$dept);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $validator = Validator::make($request->all(),PurchaseOrder::$mainRules);
        if($validator->passes()){

            $countData = POExtension::countData('po_number',$request->input('po_number'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry(PO number) already exist, please try another entry'
                ]);

            }
            try{
                
                //ITEM VARIABLES
                $invClass = Utility::jsonUrlDecode($request->input('inv_class_edit')); $itemDesc = Utility::jsonUrlDecode($request->input('item_desc_edit'));
                $warehouse = Utility::jsonUrlDecode($request->input('warehouse_edit')); $quantity = Utility::jsonUrlDecode($request->input('quantity_edit'));
                $unitCost = Utility::jsonUrlDecode($request->input('unit_cost_edit')); $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure_edit'));
                $quantityReserved = Utility::jsonUrlDecode($request->input('quantity_reserved_edit')); $quantityReceived = Utility::jsonUrlDecode($request->input('quantity_received_edit'));
                $planned = Utility::jsonUrlDecode($request->input('planned_edit')); $expected = Utility::jsonUrlDecode($request->input('expected_edit'));
                $promised = Utility::jsonUrlDecode($request->input('promised_edit')); $bOrderNo = Utility::jsonUrlDecode($request->input('b_order_no_edit'));
                $bOrderLineNo = Utility::jsonUrlDecode($request->input('b_order_line_no_edit')); $shipStatus = Utility::jsonUrlDecode($request->input('ship_status_edit'));
                $statusComment = Utility::jsonUrlDecode($request->input('status_comment_edit')); $tax = Utility::jsonUrlDecode($request->input('tax_edit'));
                $taxPerct = Utility::jsonUrlDecode($request->input('tax_perct_edit')); $taxAmount = Utility::jsonUrlDecode($request->input('tax_amount_edit'));
                $discountPerct = Utility::jsonUrlDecode($request->input('discount_perct_edit')); $discountAmount = Utility::jsonUrlDecode($request->input('discount_amount_edit'));
                $subTotal = Utility::jsonUrlDecode($request->input('sub_total_edit')); $store = Utility::jsonUrlDecode($request->input('store_edit'));

                //ACCOUNT VARIABLES
                $accClass = Utility::jsonUrlDecode($request->input('acc_class_edit')); $accDesc = Utility::jsonUrlDecode($request->input('acc_desc_edit'));
                $accRate = Utility::jsonUrlDecode($request->input('acc_rate_edit')); $accTax = Utility::jsonUrlDecode($request->input('acc_tax_edit'));
                $accTaxPerct = Utility::jsonUrlDecode($request->input('acc_tax_perct_edit')); $accTaxAmount = Utility::jsonUrlDecode($request->input('acc_tax_amount_edit'));
                $accDiscountPerct = Utility::jsonUrlDecode($request->input('acc_discount_perct_edit')); $accDiscountAmount = Utility::jsonUrlDecode($request->input('acc_discount_amount_edit'));
                $accSubTotal = Utility::jsonUrlDecode($request->input('acc_sub_total_edit'));

                //GENERAL VARIABLES
                $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor'); $dueDate = $request->input('due_date');
                $poStatus = $request->input('po_status'); $vendorInvoiceNo = $request->input('vendor_invoice_no'); $purchaseOrderNo = $request->input('po_number');
                $user = $request->input('user'); $shipCountry = $request->input('ship_country'); $shipCity = $request->input('ship_city');
                $shipContact = $request->input('ship_contact'); $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
                $shipAddress = $request->input('ship_address'); $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
                $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
                $message = Utility::urlDecode($request->input('mail_message')); $oneTimeDiscount = $request->input('one_time_discount_amount_edit'); $oneTimeDiscountPerct = $request->input('one_time_discount_perct_edit');
                $oneTimeTaxAmount = $request->input('one_time_tax_amount_edit'); $taxType = $request->input('tax_type');
                $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct_edit');
                $rfqNo = $request->input('rfq_no'); $mailCopy = $request->input('mail_copy');

                $vendor = VendorCustomer::firstRow('id',$prefVendor);
                $curr = Currency::firstRow('id',$vendor->currency_id);
                $files = $request->file('file');
                $mailFiles = [];

                $editId = $request->input('edit_id');
                $editData = PoExtension::firstRow('id',$editId);
                $uid = $editData->uid;
                $attachment = ($editData->attachment != '') ? json_decode($editData->attachment,true) : [];
                $approvalAttachment = ($editData->approval_docs != '') ? json_decode($editData->approval_docs,true) : [];
                $dept = $request->input('department'); $approvalFiles = $request->input('approval_files');
                $reqDept = (!empty($dept)) ? $dept : Auth::user()->dept_id; $project = $request->input('project');
            
                //APPROVALS
                $approveDept = POApprovalDept::firstRow('dept',$reqDept);
                $previousData = POExtension::firstRow('id',$request->input('edit_id'));
                $approvalSys = POApprovalSys::firstRow('id',$approveDept->approval_id);
                
                if(empty($approveDept)){
                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'There is no approval system assigned to your department, contact admin for help'
                    ]);
                }

                if(!empty($project)){
                    $approvalData = ProjectPoApprovalDept::firstRow('project_id',$project);
                    if(!empty($approvalData)){
                        $approvalSys = ProjectPoApprovalSys::firstRow('id',$approvalData->approval_id);
                    }
                    
                }
               
                if($previousData->complete_status == Utility::STATUS_ACTIVE){
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Request has been approved and can\'t be edited'
                    ]);
                }
                if ($previousData->deny_user != 0) {

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Request has been denied and can\'t be edited'
                    ]);

                }
    
                if($editData->attachment != ''){
                    foreach($attachment as $attach){
                        $mainFiles[] = Utility::FILE_URL($attach);
                    }
                }

                if($files != ''){
                    foreach($files as $file){
                        //return$file;
                        $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                        //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                        //array_push($cdn_images,$file_name);
                        $attachment[] =  $file_name;
                        $mailFiles[] = Utility::FILE_URL($file_name);
                        $file->move(
                            Utility::FILE_URL(), $file_name
                        );

                    }
                }

                if($approvalFiles != ''){
                    foreach($approvalFiles as $file){
                        //return$file;
                        $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();
    
                        //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                        //array_push($cdn_images,$file_name);
                        $approvalAttachment[] =  $file_name;
    
                        $file->move(
                            Utility::FILE_URL(), $file_name
                        );
    
                    }
                }

                $dbDATA = [
                    'assigned_user' => $user,
                    'po_number' => $purchaseOrderNo,
                    'project_id' => $project,
                    'vendor_invoice_no' => $vendorInvoiceNo,
                    'mails' => $emails,
                    'mail_copy' => $mailCopy,
                    'rfq_no' => $rfqNo,
                    'sum_total' => $grandTotal,
                    'trans_total' => $grandTotalVendorCurr,
                    'discount_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
                    'discount_trans' => $oneTimeDiscount,
                    'discount_perct' => $oneTimeDiscountPerct,
                    'discount_type' => $discountType,
                    'tax_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
                    'tax_trans' => $oneTimeTaxAmount,
                    'tax_perct' => $oneTimeTaxPerct,
                    'tax_type' => $taxType,
                    'message' => $message,
                    'attachment' => json_encode($attachment,true),
                    'approval_docs' => json_encode($approvalAttachment,true),
                    'default_curr' => Utility::currencyArrayItem('id'),
                    'trans_curr' => $curr->id,
                    'vendor' => $prefVendor,
                    'due_date' => Utility::standardDate($dueDate),
                    'post_date' => Utility::standardDate($postingDate),
                    'ship_to_city' => $shipCity,
                    'ship_address' => $shipAddress,
                    'ship_to_country' => $shipCountry,
                    'ship_to_contact' => $shipContact,
                    'ship_method' => $shipMethod,
                    'ship_agent' => $shipAgent,
                    'purchase_status' => $poStatus,
                    'mail_status' => $mailOption,
                    'updated_by' => Auth::user()->id,
                ];

                if($previousData->approved_users != '') {
                    $approvalArray = json_decode($approvalSys->level_users,true);
                    $approvalLevel = json_decode($approvalSys->levels,true);
                    $approvalUsers = json_decode($approvalSys->users,true);
                    $approveUsers = $approvalSys->users; $approveLevels = $approvalSys->levels;
                    $appLevel = [];
                    $appUser = [];
                    $holdUser = '';
    
                    Approve::processApproval($approvalArray,$approvalLevel,$approvalUsers,$approveUsers,$approveLevels,$appLevel,$appUser,$holdUser);
                    $reqStatus = ($holdUser == '') ? Utility::APPROVED : Utility::PROCESSING;
    
                    $dbDATA = [
                        'assigned_user' => $user,
                        'po_number' => $purchaseOrderNo,
                        'project_id' => $project,
                        'vendor_invoice_no' => $vendorInvoiceNo,
                        'mails' => $emails,
                        'mail_copy' => $mailCopy,
                        'rfq_no' => $rfqNo,
                        'sum_total' => $grandTotal,
                        'trans_total' => $grandTotalVendorCurr,
                        'discount_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
                        'discount_trans' => $oneTimeDiscount,
                        'discount_perct' => $oneTimeDiscountPerct,
                        'discount_type' => $discountType,
                        'tax_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
                        'tax_trans' => $oneTimeTaxAmount,
                        'tax_perct' => $oneTimeTaxPerct,
                        'tax_type' => $taxType,
                        'message' => $message,
                        'attachment' => json_encode($attachment,true),
                        'approval_docs' => json_encode($approvalAttachment,true),
                        'default_curr' => Utility::currencyArrayItem('id'),
                        'trans_curr' => $curr->id,
                        'vendor' => $prefVendor,
                        'due_date' => Utility::standardDate($dueDate),
                        'post_date' => Utility::standardDate($postingDate),
                        'ship_to_city' => $shipCity,
                        'ship_address' => $shipAddress,
                        'ship_to_country' => $shipCountry,
                        'ship_to_contact' => $shipContact,
                        'ship_method' => $shipMethod,
                        'ship_agent' => $shipAgent,
                        'approval_json' => $approvalArray,
                        'approval_level' => $approveLevels,
                        'approval_user' => $approveUsers,
                        'approval_id' => $approvalSys->id,
                        'approval_status' => $reqStatus,
                        'complete_status' => $reqStatus,
                        'purchase_status' => $poStatus,
                        'mail_status' => $mailOption,
                        'updated_by' => Auth::user()->id,
                    ];

                    if($holdUser != '') {
                        $reqUser = $previousData->request_user;
                        $user = User::firstRow('id', $reqUser);
                        $firstUser = User::firstRow('id', $holdUser);
                        $email = $firstUser->email;
                        $fullName = $previousData->user_c->firstname . ' ' . $previousData->user_c->lastname;
                        $senderName = $user->firstname . ' ' . $user->lastname;
                        $subject = 'A New Purchase Order from ' . $senderName;
                       
                        $emailContent = new \stdClass();
                        $emailContent->user_id = $previousData->request_user;
                        $emailContent->type = 'next_approval';
                        $emailContent->name = $fullName;
                        $emailContent->sender_name = $senderName;
                        $emailContent->desc = $previousData->po_number;
                        $emailContent->amount = $previousData->sum_total;


                        Notify::sendMail('requisition.send_request', $emailContent, $email, $fullName, $subject);
                    }

                }

                $mainPo = PoExtension::defaultUpdate('id', $editId, $dbDATA);
                $countExtAcc = $request->input('count_ext_acc');
                $countExtPo = $request->input('count_ext_po');

                if($countExtPo > 0){

                    for ($i = 1; $i <= $countExtPo; $i++) {
                        $poDbDataEdit = [];

                        if (!empty($request->input('inv_class' . $i))) {
                            $binStock = Inventory::firstRow('id', $request->input('inv_class' . $i));
                            $poDbDataEdit['item_id'] = $request->input('inv_class' . $i);
                            $poDbDataEdit['bin_stock'] = $binStock->inventory_type;
                            $poDbDataEdit['unit_measurement'] = $request->input('unit_measure' . $i);
                            $poDbDataEdit['quantity'] = $request->input('quantity' . $i);
                            $poDbDataEdit['po_desc'] = $request->input('item_desc' . $i);
                            $poDbDataEdit['unit_cost_trans'] = $request->input('unit_cost' . $i);
                            $poDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('unit_cost' . $i), 0), $postingDate);
                            $poDbDataEdit['tax_id'] = Utility::checkEmptyItem($request->input('tax' . $i), 0);
                            $poDbDataEdit['tax_perct'] = Utility::checkEmptyItem($request->input('tax_perct' . $i), 0);
                            $poDbDataEdit['tax_amount_trans'] = Utility::checkEmptyItem($request->input('tax_amount' . $i), 0);
                            $poDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount' . $i), 0), $postingDate);
                            $poDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount' . $i), 0);
                            $poDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount' . $i), 0), $postingDate);
                            $poDbDataEdit['discount_perct'] = Utility::checkEmptyItem($request->input('discount_perct' . $i), 0);
                            $poDbDataEdit['extended_amount_trans'] = Utility::checkEmptyItem($request->input('sub_total' . $i), 0);
                            $poDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total' . $i), 0), $postingDate);

                            $statComHist = [];
                            if (Utility::checkEmptyItem($request->input('ship_status' . $i), 0) != 0) {
                                $statComHist[Utility::checkEmptyItem($request->input('ship_status' . $i), 0)] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');

                            }

                            $poDbDataEdit['store_id'] = Utility::checkEmptyItem($request->input('store' . $i), '0');
                            $poDbDataEdit['ship_to_whse'] = Utility::checkEmptyItem($request->input('warehouse' . $i), '0');
                            $poDbDataEdit['reserved_quantity'] = Utility::checkEmptyItem($request->input('quantity_reserved' . $i), '');
                            $poDbDataEdit['received_quantity'] = Utility::checkEmptyItem($request->input('quantity_received' . $i), '');
                            $poDbDataEdit['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('planned' . $i), '0000-00-00'));
                            $poDbDataEdit['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('promised' . $i), '0000-00-00'));
                            $poDbDataEdit['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('expected' . $i), '0000-00-00'));
                            $poDbDataEdit['po_status'] = Utility::checkEmptyItem($request->input('ship_status' . $i), '');
                            $poDbDataEdit['po_status_comment'] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');
                            $poDbDataEdit['status_comment_history'] = json_encode($statComHist, true);
                            $poDbDataEdit['blanket_order_no'] = Utility::checkEmptyItem($request->input('blanket_order_no' . $i), '');
                            $poDbDataEdit['blanket_order_line_no'] = Utility::checkEmptyItem($request->input('blanket_order_line_no' . $i), '');
                            $poDbDataEdit['updated_by'] = Auth::user()->id;

                            PurchaseOrder::defaultUpdate('id', $request->input('poId' . $i), $poDbDataEdit);
                        }

                    }

                }

                if($countExtAcc > 0){

                    for ($i = 1; $i <= $countExtAcc; $i++) {

                        if (!empty($request->input('acc_class' . $i))) {
                            $accDbDataEdit['account_id'] = $request->input('acc_class' . $i);
                            $accDbDataEdit['po_desc'] = $request->input('item_desc_acc' . $i);
                            $accDbDataEdit['unit_cost_trans'] = $request->input('unit_cost_acc' . $i);
                            $accDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), $request->input('unit_cost_acc' . $i), $postingDate);
                            $accDbDataEdit['tax_id'] = $request->input('tax_acc' . $i);
                            $accDbDataEdit['tax_perct'] = $request->input('tax_perct_acc' . $i);
                            $accDbDataEdit['tax_amount_trans'] = $request->input('tax_amount_acc' . $i);
                            $accDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount_acc' . $i), 0), $postingDate);
                            $accDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0);
                            $accDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0), $postingDate);
                            $accDbDataEdit['discount_perct'] = $request->input('discount_perct_acc' . $i);
                            $accDbDataEdit['extended_amount_trans'] = $request->input('sub_total_acc' . $i);
                            $accDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total_acc' . $i), 0), $postingDate);
                            $accDbDataEdit['updated_by'] = Auth::user()->id;

                            PurchaseOrder::defaultUpdate('id', $request->input('accId' . $i), $accDbDataEdit);
                        }

                    }

                }
                   //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                        $accDbData = [];
                        $poDbData = [];

                        $accDbData['po_id'] = $editId;
                        $accDbData['uid'] = $uid;

                    //LOOP THROUGH ACCOUNTS
                    if(!empty($accClass)) {
                        if (count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)) {
                            for ($i = 0; $i < count($accClass); $i++) {
                                $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass, $i, 0);
                                $accDbData['po_desc'] = Utility::checkEmptyArrayItem($accDesc, $i, '');
                                $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($accRate, $i, 0);
                                $accDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accRate, $i, 0), $postingDate);
                                $accDbData['tax_id'] = Utility::checkEmptyArrayItem($accTax, $i, 0);
                                $accDbData['tax_perct'] = Utility::checkEmptyArrayItem($accTaxPerct, $i, 0);
                                $accDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($accTaxAmount, $i, 0);
                                $accDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accTaxAmount, $i, 0), $postingDate);
                                $accDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($accDiscountAmount, $i, 0);
                                $accDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accDiscountAmount, $i, 0), $postingDate);
                                $accDbData['discount_perct'] = Utility::checkEmptyArrayItem($accDiscountPerct, $i, 0);
                                $accDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($accSubTotal, $i, 0);
                                $accDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accSubTotal, $i, 0), $postingDate);
                                $accDbData['status'] = Utility::STATUS_ACTIVE;
                                $accDbData['created_by'] = Auth::user()->id;

                                PurchaseOrder::create($accDbData);

                            }

                        }

                    }

                    //LOOP THROUGH ITEMS
                    $poDbData['po_id'] = $editId;
                    $poDbData['uid'] = $uid;

                    if(!empty($invClass)) {
                        if (count($invClass) == count($subTotal)) {
                            for ($i = 0; $i < count($invClass); $i++) {
                                $binStock = Inventory::firstRow('id', $invClass);
                                $poDbData['item_id'] = Utility::checkEmptyArrayItem($invClass, $i, 0);
                                $poDbData['bin_stock'] = $binStock->inventory_type;
                                $poDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure, $i, 0);
                                $poDbData['quantity'] = Utility::checkEmptyArrayItem($quantity, $i, 0);
                                $poDbData['po_desc'] = Utility::checkEmptyArrayItem($itemDesc, $i, '');
                                $poDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost, $i, 0);
                                $poDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($unitCost, $i, 0), $postingDate);
                                $poDbData['tax_id'] = Utility::checkEmptyArrayItem($tax, $i, 0);
                                $poDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct, $i, 0);
                                $poDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount, $i, 0);
                                $poDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($taxAmount, $i, 0), $postingDate);
                                $poDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount, $i, 0);
                                $poDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($discountAmount, $i, 0), $postingDate);
                                $poDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct, $i, 0);
                                $poDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal, $i, 0);
                                $poDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($subTotal, $i, 0), $postingDate);

                                $statComHist = [];
                                if (Utility::checkEmptyArrayItem($shipStatus, $i, 0) != 0) {
                                    $statComHist[Utility::checkEmptyArrayItem($shipStatus, $i, 0)] = Utility::checkEmptyArrayItem($statusComment, $i, '');

                                }

                                $poDbData['store_id'] = Utility::checkEmptyArrayItem($store, $i, '0');
                                $poDbData['ship_to_whse'] = Utility::checkEmptyArrayItem($warehouse, $i, '0');
                                $poDbData['reserved_quantity'] = Utility::checkEmptyArrayItem($quantityReserved, $i, '');
                                $poDbData['received_quantity'] = Utility::checkEmptyArrayItem($quantityReceived, $i, '');
                                $poDbData['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($planned, $i, ''));
                                $poDbData['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($promised, $i, ''));
                                $poDbData['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($expected, $i, ''));
                                $poDbData['po_status'] = Utility::checkEmptyArrayItem($shipStatus, $i, '');
                                $poDbData['po_status_comment'] = Utility::checkEmptyArrayItem($statusComment, $i, '');
                                $poDbData['status_comment_history'] = json_encode($statComHist, true);
                                $poDbData['blanket_order_no'] = Utility::checkEmptyArrayItem($bOrderNo, $i, '');
                                $poDbData['blanket_order_line_no'] = Utility::checkEmptyArrayItem($bOrderLineNo, $i, '');
                                $poDbData['status'] = Utility::STATUS_ACTIVE;
                                $poDbData['created_by'] = Auth::user()->id;

                                PurchaseOrder::create($poDbData);

                            }



                        }

                    }

                

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                }catch(Exception $e){
                    return response()->json([
                        'message2' => 'An error occurred, please try again',
                        'message' => 'Error message'
                    ]);
                }
    

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function editMini(Request $request)
    {
        //
        $validator = Validator::make($request->all(),PurchaseOrder::$editRulesMini);
        if($validator->passes()){

            try{
                
                //GENERAL VARIABLES
                $poStatus = $request->input('po_status');  $editId = $request->input('edit_id');
                $mailOption = $request->input('mail_option'); $emails = $request->input('emails');
                $message = Utility::urlDecode($request->input('mail_message')); $mailCopy = $request->input('mail_copy');

                $getPo = POExtension::firstRow('id', $editId);
                $getPoData = PurchaseOrder::specialColumns('po_id',$getPo->id);

                $dbDATA = [
                    'mails' => $emails,
                    'mail_copy' => $mailCopy,
                    'message' => $message,
                    'purchase_status' => $poStatus,
                    'mail_status' => $mailOption,
                    'updated_by' => Auth::user()->id,
                ];

                PoExtension::defaultUpdate('id', $editId, $dbDATA);

                //SEND MAIL TO VENDORS
                Utility::fetchBOMItems($getPoData);
                $currencyData = Currency::firstRow('id',$getPo->trans_curr);
                $mailFiles = json_decode($getPo->attachment);
                
                $mailContent['copy'] = $mailCopy;
                $mailContent['fromEmail']= Auth::user()->email;
                $mailContent['po']= $getPo;
                $mailContent['poData'] = $getPoData;
                $mailContent['attachment'] = $mailFiles;
                $mailContent['currency'] = $currencyData->code;
                
                //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                if($emails != '' && $getPo->mail_status == Utility::STATUS_ACTIVE){
                    $mailToArray = explode(',',$emails);
                    if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                        foreach($mailToArray as $data) {
                            Notify::poMail('mail_views.purchase_order', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
                        }
                        //SEND COPY TO SELECTED VENDOR EMAIL
                        Notify::poMail('mail_views.purchase_order', $mailContent, $getPo->vendorCon->email1, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
                    }
                }
                    

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

                }catch(Exception $e){
                    return response()->json([
                        'message2' => 'An error occurred, please try again',
                        'message' => 'Error message'
                    ]);
                }
    

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function approval(Request $request)
    {
        //

        $dbData = [];

        $in_use = [];
        $unused = [];
        $idArray = json_decode($request->input('all_data'));


        for($i=0;$i<count($idArray);$i++){
            $rowDataRequest = POExtension::firstRow('id', $idArray[$i]);
            if($rowDataRequest->complete_status == 1 || $rowDataRequest->deny_reason !=''){
                $unused[$i] = $idArray[$i];
            }else{
                $in_use[$i] = $idArray[$i];
            }
        }

        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' has been approved/denied and cannot be changed' : '';
        if(count($in_use) > 0){

            if($request->input('status') == 1){
                foreach($in_use as $reqId){
                    $getPo = POExtension::firstRow('id', $reqId);
                    $getPoData = PurchaseOrder::specialColumns('po_id',$getPo->id);
                    $emails = $getPo->mails;
                    $mailCopy = $getPo->mail_copy;
                    $mailFiles = json_decode($getPo->attachment);
                    $approvalUsers = json_decode($getPo->approval_user,true);
                    $approvalLevels = json_decode($getPo->approval_level,true);
                    $approvalJson = json_decode($getPo->approval_json,true);
                    $nextUser = '';
                    $appStatus = '';
                    $compStatus = '';
                    Approve::approvalCheck($getPo->approval_status,$approvalUsers,$approvalLevels,$approvalJson,$appStatus,$compStatus,$nextUser);
                    $approvedUsers = ($getPo->approved_users == '') ? [] : json_decode($getPo->approved_users,true);
                    $approvedUsers[] = Auth::user()->id;
                    $appUsersJson = json_encode($approvedUsers);
                    $dbData = [
                        'approval_status' => $appStatus,
                        'approval_user' => json_encode($approvalUsers),
                        'approved_users' => $appUsersJson,
                        'approval_level' => json_encode($approvalLevels),
                        'approval_json' => json_encode($approvalJson),
                        'complete_status' => $compStatus,
                    ];

                    POExtension::defaultUpdate('id',$reqId,$dbData);

                    $mailContentApproved = new \stdClass();
                    $mailContentApproved->type = 'request_approved';
                    $mailContentApproved->desc = $getPo->po_nunmber;
                    $mailContentApproved->amount = $getPo->sum_total;
                    $mailContentApproved->sender_name = $getPo->user_c->firstname . ' ' . $getPo->user_c->lastname;

                    if(count($approvalLevels) > 0) {
                        $firstUser = User::firstRow('id', $nextUser);
                        $email = $firstUser->email;
                        $fullName = $firstUser->firstname . ' ' . $firstUser->lastname;
                        $senderName = $getPo->user_c->firstname . ' ' . $getPo->user_c->lastname;
                        $subject = 'A New Purchase Order from ' . $senderName;
                      
                        $emailContent = new \stdClass();
                        $emailContent->type = 'next_approval';
                        $emailContent->name = $fullName;
                        $emailContent->user_id = $getPo->created_by;
                        $emailContent->sender_name = $senderName;
                        $emailContent->desc = $getPo->po_number;
                        $emailContent->amount = $getPo->sum_total;
                       
                        Notify::sendMail('requisition.send_request', $emailContent, $email, $fullName, $subject);
                        

                    }

                    //WHEN EVERYONE HAS APPROVED AND COMPLETE STATUS IS 1
                    if($compStatus == 1){
                        Notify::sendMail('requisition.send_request', $mailContentApproved, $getPo->user_c->email, $getPo->user_c->firstname, 'Request Approval');
                        
                        //SEND MAIL TO VENDORS
                        Utility::fetchBOMItems($getPoData);
                        $currencyData = Currency::firstRow('id',$getPo->trans_curr);
                        
                        $mailContent['copy'] = $mailCopy;
                        $mailContent['fromEmail']= Auth::user()->email;
                        $mailContent['po']= $getPo;
                        $mailContent['poData'] = $getPoData;
                        $mailContent['attachment'] = $mailFiles;
                        $mailContent['currency'] = $currencyData->code;
                        
                        //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                        if($emails != '' && $getPo->mail_status == Utility::STATUS_ACTIVE){
                            $mailToArray = explode(',',$emails);
                            if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                                foreach($mailToArray as $data) {
                                    Notify::poMail('mail_views.purchase_order', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
                                }
                                //SEND COPY TO SELECTED VENDOR EMAIL
                                Notify::poMail('mail_views.purchase_order', $mailContent, $getPo->vendorCon->email1, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
                            }
                        }
    
                        
                        if($getPo->request_user != $getPo->created_by) {  //IF REQUEST WAS MADE FOR ANOTHER USER NOTIFY WHO MADE THE REQUEST
                            Notify::sendMail('requisition.send_request', $mailContentApproved, $getPo->user_c->email, $getPo->user_c->firstname, 'Purchase Orders Approval');
                        }

                    }   //END OF WHEN STATUS IS COMPLETE

                }   //END OF LOOP FOR APPROVING PROCESS


            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' request(s) has been approved '.$message
            ]);

        }else{  //DENY USER CODES BEGINS HERE

                $denyReason = $request->input('input_text');

                foreach($in_use as $reqId) {
                    $getPo = POExtension::firstRow('id', $reqId);
                    $dbData = [
                        'deny_user' => Auth::user()->id,
                        'deny_reason' => $denyReason,
                        'approval_status' => Utility::DENIED,
                        'complete_status' => Utility::COMPLETED,
                    ];
                  
                    $mailContentDenied = new \stdClass();
                    $mailContentDenied->type = 'request_denied';
                    $mailContentDenied->desc = $getPo->po_number;
                    $mailContentDenied->sender_name = $getPo->user_c->firstname . ' ' . $getPo->user_c->lastname;
                    $mailContentDenied->amount = $getPo->sum_total;

                    $update = POExtension::defaultUpdate('id',$reqId,$dbData);

                    if($update) {
                        Notify::sendMail('requisition.send_request', $mailContentDenied, $getPo->user_c->email, $getPo->user_c->firstname, 'Request Denied');
                        if (!empty($getPo->assigned_user)) { //IF REQUEST WAS MADE FOR ANOTHER USER NOTIFY WHO MADE THE REQUEST
                            Notify::sendMail('requisition.send_request', $mailContentDenied, $getPo->assigned->email, $getPo->assigned->firstname, 'Request Denied');
                        }
                    }
                }
                 return  response()->json([
                    'message2' => 'deleted',
                    'message' => 'The '.count($in_use).' requests has been denied'
                ]);

        }   //END OF DENY CODES

        }else{
            return  response()->json([
                'message2' => 'warning',
                'message' => 'The '.count($unused).' requests has been approved/denied and status cannot be changed'
            ]);

        }



       //END FOR NORMAL USER DELETE

    }

    //CONVERT RFQ TO PURCHASE ORDER
    public function convertRfq(Request $request)
    {
        //
        $validator = Validator::make($request->all(),PurchaseOrder::$mainRules);
        if($validator->passes()){
            $countData = POExtension::countData('po_number',$request->input('po_number'));
                if($countData > 0){

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry(PO number) already exist, please try another entry'
                    ]);

                }

            try{
                
                    //ITEM VARIABLES
                    $invClass = Utility::jsonUrlDecode($request->input('inv_class_edit')); $itemDesc = Utility::jsonUrlDecode($request->input('item_desc_edit'));
                    $warehouse = Utility::jsonUrlDecode($request->input('warehouse_edit')); $quantity = Utility::jsonUrlDecode($request->input('quantity_edit'));
                    $unitCost = Utility::jsonUrlDecode($request->input('unit_cost_edit')); $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure_edit'));
                    $quantityReserved = Utility::jsonUrlDecode($request->input('quantity_reserved_edit')); $quantityReceived = Utility::jsonUrlDecode($request->input('quantity_received_edit'));
                    $planned = Utility::jsonUrlDecode($request->input('planned_edit')); $expected = Utility::jsonUrlDecode($request->input('expected_edit'));
                    $promised = Utility::jsonUrlDecode($request->input('promised_edit')); $bOrderNo = Utility::jsonUrlDecode($request->input('b_order_no_edit'));
                    $bOrderLineNo = Utility::jsonUrlDecode($request->input('b_order_line_no_edit')); $shipStatus = Utility::jsonUrlDecode($request->input('ship_status_edit'));
                    $statusComment = Utility::jsonUrlDecode($request->input('status_comment_edit')); $tax = Utility::jsonUrlDecode($request->input('tax_edit'));
                    $taxPerct = Utility::jsonUrlDecode($request->input('tax_perct_edit')); $taxAmount = Utility::jsonUrlDecode($request->input('tax_amount_edit'));
                    $discountPerct = Utility::jsonUrlDecode($request->input('discount_perct_edit')); $discountAmount = Utility::jsonUrlDecode($request->input('discount_amount_edit'));
                    $subTotal = Utility::jsonUrlDecode($request->input('sub_total_edit')); $store = Utility::jsonUrlDecode($request->input('store_edit'));

                    //ACCOUNT VARIABLES
                    $accClass = Utility::jsonUrlDecode($request->input('acc_class_edit')); $accDesc = Utility::jsonUrlDecode($request->input('acc_desc_edit'));
                    $accRate = Utility::jsonUrlDecode($request->input('acc_rate_edit')); $accTax = Utility::jsonUrlDecode($request->input('acc_tax_edit'));
                    $accTaxPerct = Utility::jsonUrlDecode($request->input('acc_tax_perct_edit')); $accTaxAmount = Utility::jsonUrlDecode($request->input('acc_tax_amount_edit'));
                    $accDiscountPerct = Utility::jsonUrlDecode($request->input('acc_discount_perct_edit')); $accDiscountAmount = Utility::jsonUrlDecode($request->input('acc_discount_amount_edit'));
                    $accSubTotal = Utility::jsonUrlDecode($request->input('acc_sub_total_edit'));

                    //GENERAL VARIABLES
                    $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor'); $dueDate = $request->input('due_date');
                    $poStatus = $request->input('po_status'); $vendorInvoiceNo = $request->input('vendor_invoice_no');
                    $purchaseOrderNo = ($request->input('po_number') !== null) ? $request->input('po_number') : Numbering::purchaseOrder('po_extention');
                    $user = $request->input('user'); $shipCountry = $request->input('ship_country'); $shipCity = $request->input('ship_city');
                    $shipContact = $request->input('ship_contact'); $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
                    $shipAddress = $request->input('ship_address'); $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
                    $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
                    $message = Utility::urlDecode($request->input('mail_message')); $oneTimeDiscount = $request->input('one_time_discount_amount_edit'); $oneTimeDiscountPerct = $request->input('one_time_discount_perct_edit');
                    $oneTimeTaxAmount = $request->input('one_time_tax_amount_edit'); $taxType = $request->input('tax_type');
                    $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct_edit');
                    $rfqNo = $request->input('rfq_no'); $mailCopy = $request->input('mail_copy');
                    $dept = $request->input('department'); $approvalFiles = $request->input('approval_files');
                    $reqDept = (!empty($dept)) ? $dept : Auth::user()->dept_id; $project = $request->input('project');

                        //APPROVALS
                        $approveDept = POApprovalDept::firstRow('dept',$reqDept);
                        if(empty($approveDept)){
                            return response()->json([
                                'message' => 'warning',
                                'message2' => 'There is no approval system assigned to your department, contact admin for help'
                            ]);
                        }

                        $approveSys = POApprovalSys::firstRow('id',$approveDept->approval_id);
                        //CHECK IF REQUEST HAS A PROJECT AND USE A PROJECT APPROVAL SYSTEM
                        $approveProjectDept = ProjectPoApprovalDept::firstRow('project_id',$project);
                        if(!empty($approveProjectDept)){
                            $approveDept = $approveProjectDept;
                            $approveSys = ProjectPoApprovalSys::firstRow('id',$approveDept->approval_id);
                        }
                        

                        if(empty($approveDept)){
                            return response()->json([
                                'message' => 'warning',
                                'message2' => 'There is no approval system assigned to this project, contact admin for help'
                            ]);
                        }


                        $approvalArray = json_decode($approveSys->level_users,true);    //LIST OF APPROVAL USERS AND THERE LEVEL
                        $approvalLevel = json_decode($approveSys->levels,true); //ALL THE LEVELS DECODED
                        $approvalUsers = json_decode($approveSys->users,true);  //ALL THE USERS DECODED
                        $approveUsers = $approveSys->users; $approveLevels = $approveSys->levels;   //USERS AND LEVELS NOT DECODED
                        $holdUser = ''; //ID OF NEXT PERSON TO APPROVE
                        $appLevel = [];
                        $appUser = [];

                        Approve::processApproval($approvalArray,$approvalLevel,$approvalUsers,$approveUsers,$approveLevels,$appLevel,$appUser,$holdUser);

                        if($holdUser != '') {
                            $firstUser = User::firstRow('id', $holdUser);
                            $email = $firstUser->email;
                            $fullName = $firstUser->firstname . ' ' . $firstUser->lastname; //FULL NAME OF NEXT PERSON TO APPROVE REQUEST
                            $senderName = Auth::user()->firstname . ' ' . Auth::user()->lastname;
                            $subject = 'A New Purchase Order from ' . $senderName;
                            
                            $emailContent = new \stdClass();
                            $emailContent->user_id = Auth::user()->id;
                            $emailContent->type = 'next_approval';
                            $emailContent->name = $fullName;
                            $emailContent->sender_name = $senderName;
                            $emailContent->desc = $purchaseOrderNo;
                            $emailContent->amount = $grandTotal;
                            Notify::sendMail('requisition.send_request',$emailContent,$email,$fullName,$subject);
                        }
                    
                        $reqStatus = ($holdUser == '') ? Utility::APPROVED : Utility::PROCESSING;

                    if (count($accClass) != count($accRate) && count($invClass) != count($unitCost)) {

                        return response()->json([
                            'message' => 'good',
                            'message2' => 'Please ensure to enter rate or/and quantity for each item/account'
                        ]);

                    }

                    $vendor = VendorCustomer::firstRow('id',$prefVendor);
                    $curr = Currency::firstRow('id',$vendor->currency_id);
                    $files = $request->file('file');
                    $mailFiles = [];

                    $editId = $request->input('edit_id');
                    $editData = RFQExtension::firstRow('id',$editId);
                    $uid = Utility::generateUID('po_extention');
                    $attachment = ($editData->attachment != '') ? json_decode($editData->attachment,true) : [];
                    $approvalAttachment = ($editData->approval_docs != '') ? json_decode($editData->approval_docs,true) : [];

                    if($editData->attachment != ''){
                        foreach($attachment as $attach){
                            $mainFiles[] = Utility::FILE_URL($attach);
                        }
                    }

                    if($files != ''){
                        foreach($files as $file){
                            //return$file;
                            $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                            //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                            //array_push($cdn_images,$file_name);
                            $attachment[] =  $file_name;
                            $mailFiles[] = Utility::FILE_URL($file_name);
                            $file->move(
                                Utility::FILE_URL(), $file_name
                            );

                        }
                    }

                    if($approvalFiles != ''){
                        foreach($approvalFiles as $file){
                            //return$file;
                            $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();
        
                            //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                            //array_push($cdn_images,$file_name);
                            $approvalAttachment[] =  $file_name;
        
                            $file->move(
                                Utility::FILE_URL(), $file_name
                            );
        
                        }
                    }

                    $dbDATA = [
                        'uid' => $uid,
                        'assigned_user' => $user,
                        'po_number' => $purchaseOrderNo,
                        'project_id' => $project,
                        'dept_id' => $reqDept,
                        'vendor_invoice_no' => $vendorInvoiceNo,
                        'mails' => $emails,
                        'mail_copy' => $mailCopy,
                        'rfq_no' => $rfqNo,
                        'sum_total' => $grandTotal,
                        'trans_total' => $grandTotalVendorCurr,
                        'discount_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
                        'discount_trans' => $oneTimeDiscount,
                        'discount_perct' => $oneTimeDiscountPerct,
                        'discount_type' => $discountType,
                        'tax_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
                        'tax_trans' => $oneTimeTaxAmount,
                        'tax_perct' => $oneTimeTaxPerct,
                        'tax_type' => $taxType,
                        'message' => $message,
                        'attachment' => json_encode($attachment,true),
                        'approval_docs' => json_encode($approvalAttachment,true),
                        'default_curr' => Utility::currencyArrayItem('id'),
                        'trans_curr' => $curr->id,
                        'vendor' => $prefVendor,
                        'due_date' => Utility::standardDate($dueDate),
                        'post_date' => Utility::standardDate($postingDate),
                        'ship_to_city' => $shipCity,
                        'ship_address' => $shipAddress,
                        'ship_to_country' => $shipCountry,
                        'ship_to_contact' => $shipContact,
                        'ship_method' => $shipMethod,
                        'ship_agent' => $shipAgent,
                        'approval_json' => $approvalArray,
                        'approval_level' => $approveLevels,
                        'approval_user' => $approveUsers,
                        'approval_id' => $approveSys->id,
                        'approval_status' => $reqStatus,
                        'complete_status' => $reqStatus,
                        'purchase_status' => $poStatus,
                        'mail_status' => $mailOption,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE,
                    ];

                    $mainPo = PoExtension::create($dbDATA);
                    $countExtAcc = $request->input('count_ext_acc');
                    $countExtPo = $request->input('count_ext_po');

                    $accDbDataEdit['po_id'] = $mainPo->id;
                    $poDbDataEdit['po_id'] = $mainPo->id;

                    if($countExtPo > 0){

                        for ($i = 1; $i <= $countExtPo; $i++) {

                            if (!empty($request->input('inv_class' . $i))) {
                                $binStock = Inventory::firstRow('id', $request->input('inv_class' . $i));
                                $poDbDataEdit['uid'] = $uid;
                                $poDbDataEdit['item_id'] = $request->input('inv_class' . $i);
                                $poDbDataEdit['bin_stock'] = $binStock->inventory_type;
                                $poDbDataEdit['unit_measurement'] = $request->input('unit_measure' . $i);
                                $poDbDataEdit['quantity'] = $request->input('quantity' . $i);
                                $poDbDataEdit['po_desc'] = $request->input('item_desc' . $i);
                                $poDbDataEdit['unit_cost_trans'] = $request->input('unit_cost' . $i);
                                $poDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('unit_cost' . $i), 0), $postingDate);
                                $poDbDataEdit['tax_id'] = Utility::checkEmptyItem($request->input('tax' . $i), 0);
                                $poDbDataEdit['tax_perct'] = Utility::checkEmptyItem($request->input('tax_perct' . $i), 0);
                                $poDbDataEdit['tax_amount_trans'] = Utility::checkEmptyItem($request->input('tax_amount' . $i), 0);
                                $poDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount' . $i), 0), $postingDate);
                                $poDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount' . $i), 0);
                                $poDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount' . $i), 0), $postingDate);
                                $poDbDataEdit['discount_perct'] = Utility::checkEmptyItem($request->input('discount_perct' . $i), 0);
                                $poDbDataEdit['extended_amount_trans'] = Utility::checkEmptyItem($request->input('sub_total' . $i), 0);
                                $poDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total' . $i), 0), $postingDate);
                                $poDbDataEdit['uid'] = $uid;
                                $statComHist = [];
                                if (Utility::checkEmptyItem($request->input('ship_status' . $i), 0) != 0) {
                                    $statComHist[Utility::checkEmptyItem($request->input('ship_status' . $i), 0)] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');

                                }

                                $poDbDataEdit['store_id'] = Utility::checkEmptyItem($request->input('store' . $i), '0');
                                $poDbDataEdit['ship_to_whse'] = Utility::checkEmptyItem($request->input('warehouse' . $i), '0');
                                $poDbDataEdit['reserved_quantity'] = Utility::checkEmptyItem($request->input('quantity_reserved' . $i), '');
                                $poDbDataEdit['received_quantity'] = Utility::checkEmptyItem($request->input('quantity_received' . $i), '');
                                $poDbDataEdit['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('planned' . $i), '0000-00-00'));
                                $poDbDataEdit['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('promised' . $i), '0000-00-00'));
                                $poDbDataEdit['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('expected' . $i), '0000-00-00'));
                                $poDbDataEdit['po_status'] = Utility::checkEmptyItem($request->input('ship_status' . $i), '');
                                $poDbDataEdit['po_status_comment'] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');
                                $poDbDataEdit['status_comment_history'] = json_encode($statComHist, true);
                                $poDbDataEdit['blanket_order_no'] = Utility::checkEmptyItem($request->input('blanket_order_no' . $i), '');
                                $poDbDataEdit['blanket_order_line_no'] = Utility::checkEmptyItem($request->input('blanket_order_line_no' . $i), '');
                                $poDbDataEdit['created_by'] = Auth::user()->id;
                                $poDbDataEdit['status'] = Utility::STATUS_ACTIVE;

                                PurchaseOrder::create($poDbDataEdit);
                            }

                        }

                    }

                    if($countExtAcc > 0){

                        for ($i = 1; $i <= $countExtAcc; $i++) {

                            if (!empty($request->input('acc_class' . $i))) {
                                $accDbDataEdit['uid'] = $uid;
                                $accDbDataEdit['account_id'] = $request->input('acc_class' . $i);
                                $accDbDataEdit['po_desc'] = $request->input('item_desc_acc' . $i);
                                $accDbDataEdit['unit_cost_trans'] = $request->input('unit_cost_acc' . $i);
                                $accDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), $request->input('unit_cost_acc' . $i), $postingDate);
                                $accDbDataEdit['tax_id'] = $request->input('tax_acc' . $i);
                                $accDbDataEdit['tax_perct'] = $request->input('tax_perct_acc' . $i);
                                $accDbDataEdit['tax_amount_trans'] = $request->input('tax_amount_acc' . $i);
                                $accDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount_acc' . $i), 0), $postingDate);
                                $accDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0);
                                $accDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0), $postingDate);
                                $accDbDataEdit['discount_perct'] = $request->input('discount_perct_acc' . $i);
                                $accDbDataEdit['extended_amount_trans'] = $request->input('sub_total_acc' . $i);
                                $accDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total_acc' . $i), 0), $postingDate);
                                $accDbDataEdit['created_by'] = Auth::user()->id;
                                $accDbDataEdit['status'] = Utility::STATUS_ACTIVE;

                                PurchaseOrder::create($accDbDataEdit);
                            }

                        }

                    }
                    //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                    $accDbData = [];
                    $poDbData = [];

                    $accDbData['po_id'] = $mainPo->id;
                    $accDbData['uid'] = $uid;


                    //LOOP THROUGH ACCOUNTS
                    if(!empty($accClass)) {
                        if (count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)) {
                            for ($i = 0; $i < count($accClass); $i++) {
                                $accDbData['uid'] = $uid;
                                $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass, $i, 0);
                                $accDbData['po_desc'] = Utility::checkEmptyArrayItem($accDesc, $i, '');
                                $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($accRate, $i, 0);
                                $accDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accRate, $i, 0), $postingDate);
                                $accDbData['tax_id'] = Utility::checkEmptyArrayItem($accTax, $i, 0);
                                $accDbData['tax_perct'] = Utility::checkEmptyArrayItem($accTaxPerct, $i, 0);
                                $accDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($accTaxAmount, $i, 0);
                                $accDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accTaxAmount, $i, 0), $postingDate);
                                $accDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($accDiscountAmount, $i, 0);
                                $accDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accDiscountAmount, $i, 0), $postingDate);
                                $accDbData['discount_perct'] = Utility::checkEmptyArrayItem($accDiscountPerct, $i, 0);
                                $accDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($accSubTotal, $i, 0);
                                $accDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accSubTotal, $i, 0), $postingDate);
                                $accDbData['status'] = Utility::STATUS_ACTIVE;
                                $accDbData['created_by'] = Auth::user()->id;

                                PurchaseOrder::create($accDbData);

                            }

                        }

                    }

                    //LOOP THROUGH ITEMS
                    $poDbData['po_id'] = $mainPo->id;
                    $poDbData['uid'] = $uid;

                    if(!empty($invClass)) {
                        if (count($invClass) == count($subTotal)) {
                            for ($i = 0; $i < count($invClass); $i++) {
                                $binStock = Inventory::firstRow('id', $invClass);
                                $poDbData['uid'] = $uid;
                                $poDbData['item_id'] = Utility::checkEmptyArrayItem($invClass, $i, 0);
                                $poDbData['bin_stock'] = $binStock->inventory_type;
                                $poDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure, $i, 0);
                                $poDbData['quantity'] = Utility::checkEmptyArrayItem($quantity, $i, 0);
                                $poDbData['po_desc'] = Utility::checkEmptyArrayItem($itemDesc, $i, '');
                                $poDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost, $i, 0);
                                $poDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($unitCost, $i, 0), $postingDate);
                                $poDbData['tax_id'] = Utility::checkEmptyArrayItem($tax, $i, 0);
                                $poDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct, $i, 0);
                                $poDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount, $i, 0);
                                $poDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($taxAmount, $i, 0), $postingDate);
                                $poDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount, $i, 0);
                                $poDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($discountAmount, $i, 0), $postingDate);
                                $poDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct, $i, 0);
                                $poDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal, $i, 0);
                                $poDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($subTotal, $i, 0), $postingDate);

                                $statComHist = [];
                                if (Utility::checkEmptyArrayItem($shipStatus, $i, 0) != 0) {
                                    $statComHist[Utility::checkEmptyArrayItem($shipStatus, $i, 0)] = Utility::checkEmptyArrayItem($statusComment, $i, '');

                                }

                                $poDbData['store_id'] = Utility::checkEmptyArrayItem($store, $i, '0');
                                $poDbData['ship_to_whse'] = Utility::checkEmptyArrayItem($warehouse, $i, '0');
                                $poDbData['reserved_quantity'] = Utility::checkEmptyArrayItem($quantityReserved, $i, '');
                                $poDbData['received_quantity'] = Utility::checkEmptyArrayItem($quantityReceived, $i, '');
                                $poDbData['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($planned, $i, ''));
                                $poDbData['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($promised, $i, ''));
                                $poDbData['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($expected, $i, ''));
                                $poDbData['po_status'] = Utility::checkEmptyArrayItem($shipStatus, $i, '');
                                $poDbData['po_status_comment'] = Utility::checkEmptyArrayItem($statusComment, $i, '');
                                $poDbData['status_comment_history'] = json_encode($statComHist, true);
                                $poDbData['blanket_order_no'] = Utility::checkEmptyArrayItem($bOrderNo, $i, '');
                                $poDbData['blanket_order_line_no'] = Utility::checkEmptyArrayItem($bOrderLineNo, $i, '');
                                $poDbData['status'] = Utility::STATUS_ACTIVE;
                                $poDbData['created_by'] = Auth::user()->id;

                                PurchaseOrder::create($poDbData);

                            }



                        }

                    }

               
                
                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }catch(Exception $e){
                return response()->json([
                    'message2' => 'An error occurred, please try again',
                    'message' => 'Error message'
                ]);
            }

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    //CONVERT QUOTE TO PURCHASE ORDER
    public function convertQuote(Request $request)
    {
        //
        $validator = Validator::make($request->all(),PurchaseOrder::$mainRules);
        if($validator->passes()){
            $countData = POExtension::countData('po_number',$request->input('po_number'));
                if($countData > 0){

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry(PO number) already exist, please try another entry'
                    ]);

                }


            try{
                    
                        //ITEM VARIABLES
                        $invClass = Utility::jsonUrlDecode($request->input('inv_class_edit')); $itemDesc = Utility::jsonUrlDecode($request->input('item_desc_edit'));
                        $warehouse = Utility::jsonUrlDecode($request->input('warehouse_edit')); $quantity = Utility::jsonUrlDecode($request->input('quantity_edit'));
                        $unitCost = Utility::jsonUrlDecode($request->input('unit_cost_edit')); $unitMeasure = Utility::jsonUrlDecode($request->input('unit_measure_edit'));
                        $quantityReserved = Utility::jsonUrlDecode($request->input('quantity_reserved_edit')); $quantityReceived = Utility::jsonUrlDecode($request->input('quantity_received_edit'));
                        $planned = Utility::jsonUrlDecode($request->input('planned_edit')); $expected = Utility::jsonUrlDecode($request->input('expected_edit'));
                        $promised = Utility::jsonUrlDecode($request->input('promised_edit')); $bOrderNo = Utility::jsonUrlDecode($request->input('b_order_no_edit'));
                        $bOrderLineNo = Utility::jsonUrlDecode($request->input('b_order_line_no_edit')); $shipStatus = Utility::jsonUrlDecode($request->input('ship_status_edit'));
                        $statusComment = Utility::jsonUrlDecode($request->input('status_comment_edit')); $tax = Utility::jsonUrlDecode($request->input('tax_edit'));
                        $taxPerct = Utility::jsonUrlDecode($request->input('tax_perct_edit')); $taxAmount = Utility::jsonUrlDecode($request->input('tax_amount_edit'));
                        $discountPerct = Utility::jsonUrlDecode($request->input('discount_perct_edit')); $discountAmount = Utility::jsonUrlDecode($request->input('discount_amount_edit'));
                        $subTotal = Utility::jsonUrlDecode($request->input('sub_total_edit')); $store = Utility::jsonUrlDecode($request->input('store_edit'));

                        //ACCOUNT VARIABLES
                        $accClass = Utility::jsonUrlDecode($request->input('acc_class_edit')); $accDesc = Utility::jsonUrlDecode($request->input('acc_desc_edit'));
                        $accRate = Utility::jsonUrlDecode($request->input('acc_rate_edit')); $accTax = Utility::jsonUrlDecode($request->input('acc_tax_edit'));
                        $accTaxPerct = Utility::jsonUrlDecode($request->input('acc_tax_perct_edit')); $accTaxAmount = Utility::jsonUrlDecode($request->input('acc_tax_amount_edit'));
                        $accDiscountPerct = Utility::jsonUrlDecode($request->input('acc_discount_perct_edit')); $accDiscountAmount = Utility::jsonUrlDecode($request->input('acc_discount_amount_edit'));
                        $accSubTotal = Utility::jsonUrlDecode($request->input('acc_sub_total_edit'));

                        //GENERAL VARIABLES
                        $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor'); $dueDate = $request->input('due_date');
                        $poStatus = $request->input('po_status'); $vendorInvoiceNo = $request->input('vendor_invoice_no'); 
                        $purchaseOrderNo = ($request->input('po_number') !== null) ? $request->input('po_number') : Numbering::purchaseOrder('po_extention');
                        $user = $request->input('user'); $shipCountry = $request->input('ship_country'); $shipCity = $request->input('ship_city');
                        $shipContact = $request->input('ship_contact'); $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
                        $shipAddress = $request->input('ship_address'); $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
                        $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
                        $message = Utility::urlDecode($request->input('mail_message')); $oneTimeDiscount = $request->input('one_time_discount_amount_edit'); $oneTimeDiscountPerct = $request->input('one_time_discount_perct_edit');
                        $oneTimeTaxAmount = $request->input('one_time_tax_amount_edit'); $taxType = $request->input('tax_type');
                        $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct_edit');
                        $rfqNo = $request->input('rfq_no'); $mailCopy = $request->input('mail_copy');
                        $dept = $request->input('department'); $approvalFiles = $request->input('approval_files');
                        $reqDept = (!empty($dept)) ? $dept : Auth::user()->dept_id; $project = $request->input('project');

                        //APPROVALS
                        $approveDept = POApprovalDept::firstRow('dept',$reqDept);
                        if(empty($approveDept)){
                            return response()->json([
                                'message' => 'warning',
                                'message2' => 'There is no approval system assigned to your department, contact admin for help'
                            ]);
                        }

                        $approveSys = POApprovalSys::firstRow('id',$approveDept->approval_id);

                        //CHECK IF REQUEST HAS A PROJECT AND USE A PROJECT APPROVAL SYSTEM
                        $approveProjectDept = ProjectPoApprovalDept::firstRow('project_id',$project);
                        if(!empty($approveProjectDept)){
                            $approveDept = $approveProjectDept;
                            $approveSys = ProjectPoApprovalSys::firstRow('id',$approveDept->approval_id);
                        }
                        

                        if(empty($approveDept)){
                            return response()->json([
                                'message' => 'warning',
                                'message2' => 'There is no approval system assigned to this project, contact admin for help'
                            ]);
                        }

                        $approvalArray = json_decode($approveSys->level_users,true);    //LIST OF APPROVAL USERS AND THERE LEVEL
                        $approvalLevel = json_decode($approveSys->levels,true); //ALL THE LEVELS DECODED
                        $approvalUsers = json_decode($approveSys->users,true);  //ALL THE USERS DECODED
                        $approveUsers = $approveSys->users; $approveLevels = $approveSys->levels;   //USERS AND LEVELS NOT DECODED
                        $holdUser = ''; //ID OF NEXT PERSON TO APPROVE
                        $appLevel = [];
                        $appUser = [];

                        Approve::processApproval($approvalArray,$approvalLevel,$approvalUsers,$approveUsers,$approveLevels,$appLevel,$appUser,$holdUser);

                        if($holdUser != '') {
                            $firstUser = User::firstRow('id', $holdUser);
                            $email = $firstUser->email;
                            $fullName = $firstUser->firstname . ' ' . $firstUser->lastname; //FULL NAME OF NEXT PERSON TO APPROVE REQUEST
                            $senderName = Auth::user()->firstname . ' ' . Auth::user()->lastname;
                            $subject = 'A New Purchase Order from ' . $senderName;
                            
                            $emailContent = new \stdClass();
                            $emailContent->user_id = Auth::user()->id;
                            $emailContent->type = 'next_approval';
                            $emailContent->name = $fullName;
                            $emailContent->sender_name = $senderName;
                            $emailContent->desc = $purchaseOrderNo;
                            $emailContent->amount = $grandTotal;
                            Notify::sendMail('requisition.send_request',$emailContent,$email,$fullName,$subject);
                        }
                    
                        $reqStatus = ($holdUser == '') ? Utility::APPROVED : Utility::PROCESSING;

                        if (count($accClass) != count($accRate) && count($invClass) != count($subTotal)) {

                            return response()->json([
                                'message' => 'good',
                                'message2' => 'Please ensure to enter rate or/and quantity for each item/account'
                            ]);

                        }

                        $vendor = VendorCustomer::firstRow('id',$prefVendor);
                        $curr = Currency::firstRow('id',$vendor->currency_id);
                        $files = $request->file('file');
                        $mailFiles = [];

                        $editId = $request->input('edit_id');
                        $editData = QuoteExtension::firstRow('id',$editId);
                        $uid = Utility::generateUID('po_extention');
                        $attachment = ($editData->attachment != '') ? json_decode($editData->attachment,true) : [];
                        $approvalAttachment = ($editData->approval_docs != '') ? json_decode($editData->approval_docs,true) : [];

                        if($editData->attachment != ''){
                            foreach($attachment as $attach){
                                $mainFiles[] = Utility::FILE_URL($attach);
                            }
                        }

                        if($files != ''){
                            foreach($files as $file){
                                //return$file;
                                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                                //array_push($cdn_images,$file_name);
                                $attachment[] =  $file_name;
                                $mailFiles[] = Utility::FILE_URL($file_name);
                                $file->move(
                                    Utility::FILE_URL(), $file_name
                                );

                            }
                        }
                        
                        if($approvalFiles != ''){
                            foreach($approvalFiles as $file){
                                //return$file;
                                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();
            
                                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                                //array_push($cdn_images,$file_name);
                                $approvalAttachment[] =  $file_name;
            
                                $file->move(
                                    Utility::FILE_URL(), $file_name
                                );
            
                            }
                        }

                        $dbDATA = [
                            'uid' => $uid,
                            'assigned_user' => $user,
                            'po_number' => $purchaseOrderNo,
                            'project_id' => $project,
                            'dept_id' => $reqDept,
                            'vendor_invoice_no' => $vendorInvoiceNo,
                            'mails' => $emails,
                            'mail_copy' => $mailCopy,
                            'rfq_no' => $rfqNo,
                            'sum_total' => $grandTotal,
                            'trans_total' => $grandTotalVendorCurr,
                            'discount_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
                            'discount_trans' => $oneTimeDiscount,
                            'discount_perct' => $oneTimeDiscountPerct,
                            'discount_type' => $discountType,
                            'tax_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
                            'tax_trans' => $oneTimeTaxAmount,
                            'tax_perct' => $oneTimeTaxPerct,
                            'tax_type' => $taxType,
                            'message' => $message,
                            'attachment' => json_encode($attachment,true),
                            'approval_docs' => json_encode($approvalAttachment,true),
                            'default_curr' => Utility::currencyArrayItem('id'),
                            'trans_curr' => $curr->id,
                            'vendor' => $prefVendor,
                            'due_date' => Utility::standardDate($dueDate),
                            'post_date' => Utility::standardDate($postingDate),
                            'ship_to_city' => $shipCity,
                            'ship_address' => $shipAddress,
                            'ship_to_country' => $shipCountry,
                            'ship_to_contact' => $shipContact,
                            'ship_method' => $shipMethod,
                            'ship_agent' => $shipAgent,
                            'approval_json' => $approvalArray,
                            'approval_level' => $approveLevels,
                            'approval_user' => $approveUsers,
                            'approval_id' => $approveSys->id,
                            'approval_status' => $reqStatus,
                            'complete_status' => $reqStatus,
                            'purchase_status' => $poStatus,
                            'mail_status' => $mailOption,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        $mainPo = PoExtension::create($dbDATA);
                        $countExtAcc = $request->input('count_ext_acc');
                        $countExtPo = $request->input('count_ext_po');

                        $accDbDataEdit['po_id'] = $mainPo->id;
                        $poDbDataEdit['po_id'] = $mainPo->id;

                        if($countExtPo > 0){

                            for ($i = 1; $i <= $countExtPo; $i++) {
                                if (!empty($request->input('inv_class' . $i))) {
                                    $binStock = Inventory::firstRow('id', $request->input('inv_class' . $i));
                                    $poDbDataEdit['uid'] = $uid;
                                    $poDbDataEdit['item_id'] = $request->input('inv_class' . $i);
                                    $poDbDataEdit['bin_stock'] = $binStock->inventory_type;
                                    $poDbDataEdit['unit_measurement'] = $request->input('unit_measure' . $i);
                                    $poDbDataEdit['quantity'] = $request->input('quantity' . $i);
                                    $poDbDataEdit['po_desc'] = $request->input('item_desc' . $i);
                                    $poDbDataEdit['unit_cost_trans'] = $request->input('unit_cost' . $i);
                                    $poDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('unit_cost' . $i), 0), $postingDate);
                                    $poDbDataEdit['tax_id'] = Utility::checkEmptyItem($request->input('tax' . $i), 0);
                                    $poDbDataEdit['tax_perct'] = Utility::checkEmptyItem($request->input('tax_perct' . $i), 0);
                                    $poDbDataEdit['tax_amount_trans'] = Utility::checkEmptyItem($request->input('tax_amount' . $i), 0);
                                    $poDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount' . $i), 0), $postingDate);
                                    $poDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount' . $i), 0);
                                    $poDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount' . $i), 0), $postingDate);
                                    $poDbDataEdit['discount_perct'] = Utility::checkEmptyItem($request->input('discount_perct' . $i), 0);
                                    $poDbDataEdit['extended_amount_trans'] = Utility::checkEmptyItem($request->input('sub_total' . $i), 0);
                                    $poDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total' . $i), 0), $postingDate);
                                    $poDbDataEdit['uid'] = $uid;
                                    $statComHist = [];
                                    if (Utility::checkEmptyItem($request->input('ship_status' . $i), 0) != 0) {
                                        $statComHist[Utility::checkEmptyItem($request->input('ship_status' . $i), 0)] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');

                                    }

                                    $poDbDataEdit['store_id'] = Utility::checkEmptyItem($request->input('store' . $i), '0');
                                    $poDbDataEdit['ship_to_whse'] = Utility::checkEmptyItem($request->input('warehouse' . $i), '0');
                                    $poDbDataEdit['reserved_quantity'] = Utility::checkEmptyItem($request->input('quantity_reserved' . $i), '');
                                    $poDbDataEdit['received_quantity'] = Utility::checkEmptyItem($request->input('quantity_received' . $i), '');
                                    $poDbDataEdit['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('planned' . $i), '0000-00-00'));
                                    $poDbDataEdit['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('promised' . $i), '0000-00-00'));
                                    $poDbDataEdit['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyItem($request->input('expected' . $i), '0000-00-00'));
                                    $poDbDataEdit['po_status'] = Utility::checkEmptyItem($request->input('ship_status' . $i), '');
                                    $poDbDataEdit['po_status_comment'] = Utility::checkEmptyItem($request->input('status_comment' . $i), '');
                                    $poDbDataEdit['status_comment_history'] = json_encode($statComHist, true);
                                    $poDbDataEdit['blanket_order_no'] = Utility::checkEmptyItem($request->input('blanket_order_no' . $i), '');
                                    $poDbDataEdit['blanket_order_line_no'] = Utility::checkEmptyItem($request->input('blanket_order_line_no' . $i), '');
                                    $poDbDataEdit['created_by'] = Auth::user()->id;
                                    $poDbDataEdit['status'] = Utility::STATUS_ACTIVE;

                                    PurchaseOrder::create($poDbDataEdit);
                                }

                            }

                        }

                        if($countExtAcc > 0){

                            for ($i = 1; $i <= $countExtAcc; $i++) {

                                if (!empty($request->input('acc_class' . $i))) {
                                    $accDbDataEdit['uid'] = $uid;
                                    $accDbDataEdit['account_id'] = $request->input('acc_class' . $i);
                                    $accDbDataEdit['po_desc'] = $request->input('item_desc_acc' . $i);
                                    $accDbDataEdit['unit_cost_trans'] = $request->input('unit_cost_acc' . $i);
                                    $accDbDataEdit['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), $request->input('unit_cost_acc' . $i), $postingDate);
                                    $accDbDataEdit['tax_id'] = $request->input('tax_acc' . $i);
                                    $accDbDataEdit['tax_perct'] = $request->input('tax_perct_acc' . $i);
                                    $accDbDataEdit['tax_amount_trans'] = $request->input('tax_amount_acc' . $i);
                                    $accDbDataEdit['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('tax_amount_acc' . $i), 0), $postingDate);
                                    $accDbDataEdit['discount_amount_trans'] = Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0);
                                    $accDbDataEdit['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('discount_amount_acc' . $i), 0), $postingDate);
                                    $accDbDataEdit['discount_perct'] = $request->input('discount_perct_acc' . $i);
                                    $accDbDataEdit['extended_amount_trans'] = $request->input('sub_total_acc' . $i);
                                    $accDbDataEdit['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyItem($request->input('sub_total_acc' . $i), 0), $postingDate);
                                    $accDbDataEdit['created_by'] = Auth::user()->id;
                                    $accDbDataEdit['status'] = Utility::STATUS_ACTIVE;

                                    PurchaseOrder::create($accDbDataEdit);
                                }

                            }

                        }
                        //END OF FOR LOOP FOR ENTERING EXISTING COLUMN DATA

                        $accDbData = [];
                        $poDbData = [];

                        $accDbData['po_id'] = $mainPo->id;
                        $accDbData['uid'] = $uid;

                        //LOOP THROUGH ACCOUNTS
                        if(!empty($accClass)) {
                            if (count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)) {
                                for ($i = 0; $i < count($accClass); $i++) {
                                    $accDbData['uid'] = $uid;
                                    $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass, $i, 0);
                                    $accDbData['po_desc'] = Utility::checkEmptyArrayItem($accDesc, $i, '');
                                    $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($accRate, $i, 0);
                                    $accDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accRate, $i, 0), $postingDate);
                                    $accDbData['tax_id'] = Utility::checkEmptyArrayItem($accTax, $i, 0);
                                    $accDbData['tax_perct'] = Utility::checkEmptyArrayItem($accTaxPerct, $i, 0);
                                    $accDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($accTaxAmount, $i, 0);
                                    $accDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accTaxAmount, $i, 0), $postingDate);
                                    $accDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($accDiscountAmount, $i, 0);
                                    $accDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accDiscountAmount, $i, 0), $postingDate);
                                    $accDbData['discount_perct'] = Utility::checkEmptyArrayItem($accDiscountPerct, $i, 0);
                                    $accDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($accSubTotal, $i, 0);
                                    $accDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($accSubTotal, $i, 0), $postingDate);
                                    $accDbData['status'] = Utility::STATUS_ACTIVE;
                                    $accDbData['created_by'] = Auth::user()->id;

                                    PurchaseOrder::create($accDbData);

                                }

                            }

                        }

                        //LOOP THROUGH ITEMS
                        $poDbData['po_id'] = $mainPo->id;
                        $poDbData['uid'] = $uid;
                    
                        if(!empty($invClass)) {
                            if (count($invClass) == count($subTotal)) {
                                for ($i = 0; $i < count($invClass); $i++) {
                                    $binStock = Inventory::firstRow('id', $invClass);
                                    $poDbData['uid'] = $uid;
                                    $poDbData['item_id'] = Utility::checkEmptyArrayItem($invClass, $i, 0);
                                    $poDbData['bin_stock'] = $binStock->inventory_type;
                                    $poDbData['unit_measurement'] = Utility::checkEmptyArrayItem($unitMeasure, $i, 0);
                                    $poDbData['quantity'] = Utility::checkEmptyArrayItem($quantity, $i, 0);
                                    $poDbData['po_desc'] = Utility::checkEmptyArrayItem($itemDesc, $i, '');
                                    $poDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost, $i, 0);
                                    $poDbData['unit_cost'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($unitCost, $i, 0), $postingDate);
                                    $poDbData['tax_id'] = Utility::checkEmptyArrayItem($tax, $i, 0);
                                    $poDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct, $i, 0);
                                    $poDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount, $i, 0);
                                    $poDbData['tax_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($taxAmount, $i, 0), $postingDate);
                                    $poDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount, $i, 0);
                                    $poDbData['discount_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($discountAmount, $i, 0), $postingDate);
                                    $poDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct, $i, 0);
                                    $poDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal, $i, 0);
                                    $poDbData['extended_amount'] = Utility::convertAmountToDate($curr->code, Utility::currencyArrayItem('code'), Utility::checkEmptyArrayItem($subTotal, $i, 0), $postingDate);

                                    $statComHist = [];
                                    if (Utility::checkEmptyArrayItem($shipStatus, $i, 0) != 0) {
                                        $statComHist[Utility::checkEmptyArrayItem($shipStatus, $i, 0)] = Utility::checkEmptyArrayItem($statusComment, $i, '');

                                    }

                                    $poDbData['store_id'] = Utility::checkEmptyArrayItem($store, $i, '0');
                                    $poDbData['ship_to_whse'] = Utility::checkEmptyArrayItem($warehouse, $i, '0');
                                    $poDbData['reserved_quantity'] = Utility::checkEmptyArrayItem($quantityReserved, $i, '');
                                    $poDbData['received_quantity'] = Utility::checkEmptyArrayItem($quantityReceived, $i, '');
                                    $poDbData['planned_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($planned, $i, ''));
                                    $poDbData['promised_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($promised, $i, ''));
                                    $poDbData['expected_receipt_date'] = Utility::standardDate(Utility::checkEmptyArrayItem($expected, $i, ''));
                                    $poDbData['po_status'] = Utility::checkEmptyArrayItem($shipStatus, $i, '');
                                    $poDbData['po_status_comment'] = Utility::checkEmptyArrayItem($statusComment, $i, '');
                                    $poDbData['status_comment_history'] = json_encode($statComHist, true);
                                    $poDbData['blanket_order_no'] = Utility::checkEmptyArrayItem($bOrderNo, $i, '');
                                    $poDbData['blanket_order_line_no'] = Utility::checkEmptyArrayItem($bOrderLineNo, $i, '');
                                    $poDbData['status'] = Utility::STATUS_ACTIVE;
                                    $poDbData['created_by'] = Auth::user()->id;

                                    PurchaseOrder::create($poDbData);

                                }

                            }

                        }

               

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

        }catch(Exception $e){
            Log::info($e);
            return response()->json([
                'message2' => 'An error occurred, please try again',
                'message' => 'Error message'
            ]);
        }

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function permDelete(Request $request)
    {
        //
        $id = $request->input('dataId');

        PurchaseOrder::defaultUpdate('id',$id,['status' => Utility::ZERO]);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

    //DATA NOT REQUIRED TO BE DELETED FROM DATABASE
    public function permDeleteConvert(Request $request)
    {
        //
        $id = $request->input('dataId');

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

    public function attachmentForm(Request $request)
    {
        //
        $request = PoExtension::firstRow('id',$request->input('dataId'));
        return view::make('purchase_order.attach_form')->with('edit',$request);
    }

    public function removeAttachment(Request $request){
        $file_name = $request->input('attachment');
        
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = PoExtension::firstRow('id',$editId);

        $dbData = [
            'attachment' => Utility::removeJsonItem($oldData->attachment,$file_name)
        ];
        $save = PoExtension::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'File have been removed'
        ]);

    }

    public function removeApprovalDocs(Request $request){
        $file_name = $request->input('attachment');
        
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = PoExtension::firstRow('id',$editId);

        $dbData = [
            'approval_docs' => Utility::removeJsonItem($oldData->approval_docs,$file_name)
        ];
        PoExtension::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'File have been removed'
        ]);

    }

    public function downloadAttachment(){
        $file = $_GET['file'];
        $download = Utility::FILE_URL($file);
        return response()->download($download);
        //return $file;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function searchPo(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = PoExtension::searchPo($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/
        //print_r($search); exit();
        $user_ids = array_unique($obtain_array);
        $mainData =  PoExtension::massDataPaginate('uid', $user_ids);
        //print_r($obtain_array); die();
        if (count($user_ids) > 0) {

            return view::make('purchase_order.search_po')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }


    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));

        foreach($idArray as $data){
            $dataChild = PurchaseOrder::specialColumns('po_id',$data);
            if(!empty($dataChild)){
                foreach($dataChild as $child){
                    $delete = PurchaseOrder::defaultUpdate('id',$child->id,['status' => Utility::ZERO]);
                }
            }
            $delete = PoExtension::defaultUpdate('id',$data,['status' => Utility::ZERO]);
        }


        return response()->json([
            'message' => 'deleted',
            'message2' => 'Data deleted successfully'
        ]);

    }


}
