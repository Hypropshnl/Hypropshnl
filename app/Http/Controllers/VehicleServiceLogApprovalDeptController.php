<?php

namespace App\Http\Controllers;

use App\Helpers\Approve;
use App\model\ApprovalDept;
use App\Helpers\Utility;
use App\model\ApprovalSys;
use App\model\Department;
use App\model\VehicleServiceLogApprovalDept;
use App\model\VehicleServiceLogApprovalSys;
use Auth;
use View;
use Validator;
use Illuminate\Http\Request;

class VehicleServiceLogApprovalDeptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mainData = VehicleServiceLogApprovalDept::paginateAllData();
        $dept = Department::getAllData();
        $approval = VehicleServiceLogApprovalSys::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle_service_log_approval_dept.reload',array('mainData' => $mainData,'dept' => $dept
            ,'approval' => $approval))->render());

        }else{
            return view::make('vehicle_service_log_approval_dept.main_view')->with('mainData',$mainData)->with('dept',$dept)
                ->with('approval',$approval);
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
        $validator = Validator::make($request->all(),VehicleServiceLogApprovalDept::$mainRules);
        if($validator->passes()){

            $countData = VehicleServiceLogApprovalDept::countData('dept',$request->input('department'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'dept' => $request->input('department'),
                    'approval_id' => $request->input('approval_system'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                VehicleServiceLogApprovalDept::create($dbDATA);

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
        $approvalDept = VehicleServiceLogApprovalDept::firstRow('id',$request->input('dataId'));
        $dept = Department::getAllData();
        $approval = VehicleServiceLogApprovalSys::getAllData();
        return view::make('vehicle_service_log_approval_dept.edit_form')->with('edit',$approvalDept)->with('approval',$approval)->with('dept',$dept);

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
        $validator = Validator::make($request->all(),VehicleServiceLogApprovalDept::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'dept' => $request->input('department'),
                'approval_id' => $request->input('approval_system'),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $deptId = $request->input('department');
            $newApprovalId = $request->input('approval_system');
            $deptApprovalId = $request->input('edit_id');

            Approve::actionOnChangingVehicleServiceLogApprovalSysForDept('vehicle_service_log_approval_dept','vehicle_service_log','vehicle_service_log_approval_sys',$deptApprovalId,$newApprovalId,$deptId);

            $rowData = VehicleServiceLogApprovalDept::specialColumns('dept', $request->input('dept'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                        VehicleServiceLogApprovalDept::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

                VehicleServiceLogApprovalDept::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = VehicleServiceLogApprovalDept::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
