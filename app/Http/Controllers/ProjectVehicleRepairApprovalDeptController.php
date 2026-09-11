<?php

namespace App\Http\Controllers;

use App\Helpers\Approve;
use App\model\ProjectVehicleRepairApprovalDept;
use App\Helpers\Utility;
use App\model\ProjectVehicleRepairApprovalSys;
use App\model\Project;
use Illuminate\Support\Facades\Auth;
use View;
use Validator;
use Illuminate\Http\Request;

class ProjectVehicleRepairApprovalDeptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
        $mainData = ProjectVehicleRepairApprovalDept::paginateAllData();
        $dept = Project::getAllData();
        $approval = ProjectVehicleRepairApprovalSys::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('project_vehicle_repair_approval_dept.reload',array('mainData' => $mainData,'dept' => $dept
            ,'approval' => $approval))->render());

        }else{
            return view::make('project_vehicle_repair_approval_dept.main_view')->with('mainData',$mainData)->with('dept',$dept)
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
        $validator = Validator::make($request->all(),ProjectVehicleRepairApprovalDept::$mainRules);
        if($validator->passes()){

            $countData = ProjectVehicleRepairApprovalDept::countData('project_id',$request->input('project'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'project_id' => $request->input('project'),
                    'approval_id' => $request->input('approval_system'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
               ProjectVehicleRepairApprovalDept::create($dbDATA);

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
        $approvalDept = ProjectVehicleRepairApprovalDept::firstRow('id',$request->input('dataId'));
        $dept = Project::getAllData();
        $approval = ProjectVehicleRepairApprovalSys::getAllData();
        return view::make('project_vehicle_repair_approval_dept.edit_form')->with('edit',$approvalDept)->with('approval',$approval)->with('project_id',$dept);

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
        $validator = Validator::make($request->all(),ProjectVehicleRepairApprovalDept::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'project_id' => $request->input('project'),
                'approval_id' => $request->input('approval_system'),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $projectId = $request->input('project');
            $newApprovalId = $request->input('approval_system');
            $deptApprovalId = $request->input('edit_id');

            Approve::actionOnChangingProjectVehicleServiceLogApprovalSysForDept('project_vehicle_repair_approval_dept','vehicle_repair','project_vehicle_repair_approval_system',$deptApprovalId,$newApprovalId,$projectId);

            $rowData = ProjectVehicleRepairApprovalDept::specialColumns('project_id', $request->input('project'));
            if(!empty($rowData)){
                if ($rowData[0]->id == $request->input('edit_id')) {

                       ProjectVehicleRepairApprovalDept::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

               ProjectVehicleRepairApprovalDept::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        ProjectVehicleRepairApprovalDept::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
