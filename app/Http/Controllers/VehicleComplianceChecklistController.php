<?php

namespace App\Http\Controllers;

use App\model\Leave;
use App\model\LeaveType;
use App\Helpers\Utility;
use App\model\VehicleComplianceChecklist;
use Auth;
use View;
use Validator;
use Illuminate\Http\Request;
use Log;

class VehicleComplianceChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mainData = VehicleComplianceChecklist::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle_compliance_checklist.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('vehicle_compliance_checklist.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),VehicleComplianceChecklist::$mainRules);
        if($validator->passes()){

            $countData = VehicleComplianceChecklist::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'name' => ucfirst($request->input('name')),
                    'frequency' => $request->input('frequency'),
                    'prompt_emails' => $request->input('prompt_emails'),
                    'last_audit_date' => $request->input('last_audit_date'),
                    'next_audit_date' => $request->input('next_audit_date'),
                    'details' => ucfirst($request->input('details')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                VehicleComplianceChecklist::create($dbDATA);

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
        $leave_type = VehicleComplianceChecklist::firstRow('id',$request->input('dataId'));
        return view::make('vehicle_compliance_checklist.edit_form')->with('edit',$leave_type);

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
        $validator = Validator::make($request->all(),VehicleComplianceChecklist::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'name' => ucfirst($request->input('name')),
                    'frequency' => $request->input('frequency'),
                    'prompt_emails' => $request->input('prompt_emails'),
                    'last_audit_date' => $request->input('last_audit_date'),
                    'next_audit_date' => $request->input('next_audit_date'),
                    'details' => ucfirst($request->input('details')),
            ];
            $rowData = VehicleComplianceChecklist::specialColumns('name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    VehicleComplianceChecklist::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                VehicleComplianceChecklist::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        VehicleComplianceChecklist::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
