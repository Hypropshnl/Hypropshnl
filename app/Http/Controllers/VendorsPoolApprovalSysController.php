<?php

namespace App\Http\Controllers;

use App\Helpers\Approve;
use App\Helpers\Utility;
use App\model\VendorsPool;
use View;
use Validator;
use Auth;
use App\model\VendorsPoolApprovalSys;
use App\User;
use Illuminate\Http\Request;

class VendorsPoolApprovalSysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = VendorsPoolApprovalSys::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('vendor_pool_approval_sys.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('vendor_pool_approval_sys.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),VendorsPoolApprovalSys::$mainRules);
        if($validator->passes()){

            $stage= json_decode($request->input('stage'));
            $user = json_decode($request->input('user'));
            $compArray = [];
            $userArray = [];
            $stageArray = [];
            $displayArray = [];

            for($i=0;$i<count($user);$i++){
                if(!empty($user[$i]) && !empty($stage[$i])) {
                $hold = [];
                $userData = User::firstRow('id',$user[$i]);
                $username = $userData->firstname.' '.$userData->lastname;
                $stageArray[] = $stage[$i];
                $userArray[] = $user[$i];
                $compArray[$stage[$i]] = $user[$i];
                $hold[$stage[$i]] = $user[$i];
                $displayArray[$username] = $hold;
                }
            }
            $encodeCompArray = json_encode($compArray);
            $encodeStage = json_encode($stageArray);
            $encodeUser = json_encode($userArray);
            $encodeDisplay = json_encode($displayArray);

            $dbDATA = [
                'approval_name' => ucfirst($request->input('approval_name')),
                'levels' => $encodeStage,
                'users' => $encodeUser,
                'json_display' => $encodeDisplay,
                'created_by' => Auth::user()->id,
                'level_users' => $encodeCompArray,
                'status' => Utility::STATUS_ACTIVE
            ];

            $countData = VendorsPoolApprovalSys::countData('approval_name',$request->input('approval_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                VendorsPoolApprovalSys::create($dbDATA);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }
        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $ApprovalSys = VendorsPoolApprovalSys::firstRow('id',$request->input('dataId'));
        $approve = json_decode($ApprovalSys->json_display,TRUE);

        return view::make('vendor_pool_approval_sys.edit_form')->with('edit',$ApprovalSys)->with('approve',$approve);

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
        $validator = Validator::make($request->all(),VendorsPoolApprovalSys::$mainRules);
        if($validator->passes()) {

            $stage= json_decode($request->input('stage'));
            $user = json_decode($request->input('user'));
            $compArray = [];
            $userArray = [];
            $stageArray = [];
            $displayArray = [];

            for($i=0;$i<count($user);$i++){
                if(!empty($user[$i]) && !empty($stage[$i])) {
                $hold = [];
                $userData = User::firstRow('id',$user[$i]);
                $username = $userData->firstname.' '.$userData->lastname;
                $stageArray[] = $stage[$i];
                $userArray[] = $user[$i];
                $compArray[$stage[$i]] = $user[$i];
                $hold[$stage[$i]] = $user[$i];
                $displayArray[$username] = $hold;
                }
            }
            $encodeCompArray = json_encode($compArray);
            $encodeStage = json_encode($stageArray);
            $encodeUser = json_encode($userArray);
            $encodeDisplay = json_encode($displayArray);

            $dbDATA = [
                'approval_name' => ucfirst($request->input('approval_name')),
                'levels' => $encodeStage,
                'users' => $encodeUser,
                'json_display' => $encodeDisplay,
                'updated_by' => Auth::user()->id,
                'level_users' => $encodeCompArray
            ];

            $approvalId = $request->input('edit_id');

            //OVERWRITE ALL APPROVAL SYSTEM AWAITING APPROVAL ASSOCIATED WITH THIS APPROVAL IN VendorsPool TABLE
            $approvalData = VendorsPoolApprovalSys::firstRow('id', $approvalId);
            $processing = VendorsPool::specialColumns('approval_status', Utility::PROCESSING);
            if($processing->count() > 0 && $approvalData->status_active == Utility::STATUS_ACTIVE){ //IF DATA IS EXISTS AND APPROVAL IS ACTIVE
                $approvalUpdate = [
                    'approval_json' => $encodeDisplay,
                    'approval_level' => $encodeStage,
                    'approval_user' => $encodeUser,
                    'approved_users' => '',
                ];
                VendorsPool::massUpdate('approval_status',Utility::PROCESSING,$approvalUpdate);
              
            }
            
            $rowData = VendorsPoolApprovalSys::specialColumns('approval_name', $request->input('approval_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    VendorsPoolApprovalSys::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                } else {
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry already exist, please try another entry'
                    ]);

                }

            } else{
                VendorsPoolApprovalSys::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);
            }
        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function changeStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $checkActive = VendorsPoolApprovalSys::firstRow('active_status',Utility::STATUS_ACTIVE);

        $dbData = [
            'active_status' => $status
        ];
        if($status == Utility::STATUS_ACTIVE) {
            if (!empty($checkActive)) {
                VendorsPoolApprovalSys::defaultUpdate('id', $checkActive->id, ['active_status' => Utility::STATUS_DELETED]);
            }
            $changeStatus = VendorsPoolApprovalSys::defaultUpdate('id',$idArray[0],$dbData);
        }else{
            $changeStatus = VendorsPoolApprovalSys::massUpdate('id',$idArray,$dbData);
        }


        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $in_use = [];
        $unused = [];
        for($i=0;$i<count($all_id);$i++){
            $rowDataSalary = VendorsPool::specialColumns2('approval_id', $all_id[$i], 'approval_status', Utility::PROCESSING);
            if(count($rowDataSalary)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' approval system(s) has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = VendorsPoolApprovalSys::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($unused).' approval system(s) has been used in another module and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }

}