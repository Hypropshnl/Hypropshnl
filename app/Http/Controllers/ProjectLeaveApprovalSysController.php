<?php

namespace App\Http\Controllers;

use App\Helpers\Approve;
use App\Helpers\Utility;
use App\model\ProjectLeaveApprovalDept;
use App\User;
use Illuminate\Support\Facades\Auth;
use View;
use Validator;
use Illuminate\Http\Request;
use App\model\ProjectLeaveApprovalSys;

class ProjectLeaveApprovalSysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $mainData = ProjectLeaveApprovalSys::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('project_leave_approval_sys.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('project_leave_approval_sys.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),ProjectLeaveApprovalSys::$mainRules);
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

            $countData =ProjectLeaveApprovalSys::countData('approval_name',$request->input('approval_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

               ProjectLeaveApprovalSys::create($dbDATA);

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
        $ApprovalSys = ProjectLeaveApprovalSys::firstRow('id',$request->input('dataId'));
        $approve = json_decode($ApprovalSys->json_display,TRUE);

        return view::make('project_leave_approval_sys.edit_form')->with('edit',$ApprovalSys)->with('approve',$approve);

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
        $validator = Validator::make($request->all(),ProjectLeaveApprovalSys::$mainRules);
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

            //OVERWRITE ALL APPROVAL SYSTEM AWAITING APPROVAL ASSOCIATED WITH THIS APPROVAL IN REQUISITION TABLE
            Approve::actionOnModifyingProjectLeaveApprovalSys('project_leave_approval_sys','leave_log',$approvalId,$userArray,$stageArray,$encodeUser,$encodeStage,$compArray);

            $rowData = ProjectLeaveApprovalSys::specialColumns('approval_name', $request->input('approval_name'));
            if(!empty($rowData)){
                if ($rowData[0]->id == $request->input('edit_id')) {

                   ProjectLeaveApprovalSys::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
               ProjectLeaveApprovalSys::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            $rowDataSalary = ProjectLeaveApprovalDept::specialColumns('approval_id', $all_id[$i]);
            if(count($rowDataSalary)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' approval system(s) has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            ProjectLeaveApprovalSys::massUpdate('id',$in_use,$dbData);

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
