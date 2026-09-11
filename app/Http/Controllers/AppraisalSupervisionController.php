<?php

namespace App\Http\Controllers;

use App\model\AppraisalSupervision;
use App\Helpers\Utility;
use App\model\Department;
use App\User;
use View;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class AppraisalSupervisionController extends Controller
{
    public function index(Request $request)
    {
        $mainData = AppraisalSupervision::paginateAllData();
        $dept = Department::getAllData();

        if ($request->ajax()) {
            return Response::json(view::make('appraisal_supervision.reload',array('mainData' => $mainData,'dept' => $dept))->render());

        }else{
            return view::make('appraisal_supervision.main_view')->with('mainData',$mainData)->with('dept',$dept);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),AppraisalSupervision::$mainRules);
        if($validator->passes()){

            $countData = AppraisalSupervision::countData('dept_id',$request->input('department'));
            $users = $request->input('reviewer');
            $score = $request->input('score');
            $arcData = [];
            foreach($users as $key => $user){
                $arcData[$user] = [
                    'reviewer_user_id' => $user,
                    'score' => $score[$key]
                ];
            }
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }
            $arcStatus = ($request->input('enable_arc') == 1) ? Utility::STATUS_ACTIVE : UTILITY::ZERO;
            $dbDATA = [
                'dept_id' => $request->input('department'),
                'user_id' => $request->input('supervisor'),
                'arc_data' => json_encode($arcData),
                'arc_users' => json_encode($users),
                'arc_reviews' => json_encode($score),
                'arc_status' => $arcStatus,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            AppraisalSupervision::create($dbDATA);

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);

            
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
        $appraisalSupervision = AppraisalSupervision::firstRow('id',$request->input('dataId'));
        $dept = Department::getAllData();
        $this->processItemData($appraisalSupervision);
        return view::make('appraisal_supervision.edit_form')->with('edit',$appraisalSupervision)->with('dept',$dept);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(),AppraisalSupervision::$mainRules);
        if($validator->passes()) {

            $users = $request->input('reviewer_edit');
            $score = $request->input('score_edit');
            $arcData = [];
            foreach($users as $key => $user){
                $arcData[$user] = [
                    'reviewer_user_id' => $user,
                    'score' => $score[$key]
                ];
            }
            $arcStatus = ($request->input('enable_arc') == 1) ? Utility::STATUS_ACTIVE : UTILITY::ZERO;
            $dbDATA = [
                'dept_id' => $request->input('department'),
                'user_id' => $request->input('supervisor'),
                'arc_data' => json_encode($arcData),
                'arc_users' => json_encode($users),
                'arc_reviews' => json_encode($score),
                'arc_status' => $arcStatus,
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = AppraisalSupervision::specialColumns('dept_id', $request->input('dept'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Department::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                AppraisalSupervision::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function deleteUser(Request $request){

        $editId = $request->input('dataId');
        $userId = $request->input('param');
        $oldData = AppraisalSupervision::firstRow('id',$editId);
        $oldUsers = json_decode($oldData->arc_users,true);
        $arcData = json_decode($oldData->arc_data,true);
        $score = [];


        //REMOVE USER FROM AN ARRAY
        if (($key = array_search($userId, $oldUsers)) != false) {
            unset($oldUsers[$key]);
            unset($arcData[$userId]);
        }
        foreach($oldUsers as $key => $user){
            $score[] = $arcData[$user]['score'];
        }

        $dbData = [
                'arc_data' => json_encode($arcData),
                'arc_users' => json_encode($oldUsers),
                'arc_reviews' => json_encode($score),
        ];
        AppraisalSupervision::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'User have been removed'
        ]);

    }

    public function processItemData($val){
        $users = json_decode($val->arc_users,true);

        if(!empty($users)){
            $fetchUsers = User::massData('id',$users);
            $val->arcUsers = $fetchUsers;
        }else{
            $val->arcUsers = '';
        }

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
        AppraisalSupervision::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
