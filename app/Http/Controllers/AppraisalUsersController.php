<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\AppraisalUsers;
use App\model\Department;
use App\model\UnitGoalSeries;
use Illuminate\Support\Facades\View;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AppraisalUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $goalSet = UnitGoalSeries::getAllData();
        $users = User::PaginateData('active_status',Utility::STATUS_ACTIVE);
        $mainData = AppraisalUsers::paginateAllData();
        $dept = Department::getAllData();
        if ($request->ajax()) {
            return Response::json(View::make('appraisal_users.reload',array('mainData' => $mainData,
            'users' => $users,'goalSet' => $goalSet,'dept' => $dept))->render());

        }else{
            return View::make('appraisal_users.main_view')->with('mainData',$mainData)->with('goalSet',$goalSet)
            ->with('users',$users)->with('dept',$dept);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(),AppraisalUsers::$mainRules);
        if($validator->fails()){

            $errors = $validator->errors();
            return response()->json([
                'message2' => 'fail',
                'message' => $errors
            ]);
        }

        $idArray = json_decode($request->input('selected_items'));
        $goalSet = $request->input('goal_set');
        $reviewer = $request->input('reviewer');
        for($i=0;$i<count($idArray);$i++){
            $user = AppraisalUsers::firstRow('user_id', $idArray[$i]);
            if(empty($user)){
                $user = User::firstRow('id', $idArray[$i]);
                $dbData = [
                    'unit_goal_series_id' => $goalSet,
                    'user_id' => $idArray[$i],
                    'dept_id' => $user->dept_id,
                    'status' => Utility::STATUS_ACTIVE,
                    'created_by' => Auth::user()->id
                ];
                if(!empty($reviewer)){ //only update the reviewer field in the appraisal users record if a reviewer is selected in the edit form, if no reviewer is selected in the edit form then do not update the reviewer field in the appraisal users record and keep the existing reviewer assigned to the user for the goal set
                    $dbData['reviewer_id'] = $reviewer;
                }
                AppraisalUsers::create($dbData);
            }else{
                $dbData = [
                    'unit_goal_series_id' => $goalSet,
                    'user_id' => $idArray[$i],
                    'dept_id' => $user->dept_id,
                    'updated_by' => Auth::user()->id
                ];
                if(!empty($reviewer)){ //only update the reviewer field in the appraisal users record if a reviewer is selected in the edit form, if no reviewer is selected in the edit form then do not update the reviewer field in the appraisal users record and keep the existing reviewer assigned to the user for the goal set
                    $dbData['reviewer_id'] = $reviewer;
                }

                AppraisalUsers::defaultUpdate('user_id',$idArray[$i],$dbData);
            }
            
        }

        return response()->json([
        'message' => count($idArray).' user(s) have been added to a time schedule',
        'message2' => 'saved'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        $dept = $request->input('department');
        $user = $request->input('user');
        $mainData = [];

        //PROCESS SEARCH REQUEST
            
            if($dept != '' && $user != ''){
                $mainData = User::massDataCondition('dept_id', $dept,'id', $user);
            }
            if($dept != '' && $user == ''){
                $mainData = User::massData('dept_id', $dept);
            }

            if($dept == '' && $user != ''){
                $mainData = User::specialColumns('id', $user);
            }

        return View::make('appraisal_users.search')->with('mainData',$mainData);

    }

   
    public function searchUser(Request $request)
    {

        $dept = $request->input('department');
        $user = $request->input('user');
        $mainData = [];
        //PROCESS SEARCH REQUEST
            
            if($dept != '' && $user != ''){
                $mainData = AppraisalUsers::massDataConditionPaginate('dept_id', $dept,'user_id', $user);
            }
            if($dept != '' && $user == ''){
                $mainData = AppraisalUsers::massDataPaginate('dept_id', $dept);
            }

            if($dept == '' && $user != ''){
                $mainData = AppraisalUsers::specialColumnsPage('user_id', $user);
            }

        return View::make('appraisal_users.reload')->with('mainData',$mainData);

    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\AppraisalUsers  $AppraisalUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));

        AppraisalUsers::whereIn('user_id', $all_id)->delete();

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }
}
