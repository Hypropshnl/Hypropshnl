<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\LMSCourse;
use App\model\LMSLesson;
use Auth;
use View;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LMSLessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $courseId)
    {
        $mainData = LMSLesson::specialColumnsPage('course_id', $courseId);
        
        $course = LMSCourse::firstRow('id', $courseId);

        if ($request->ajax()) {
            return \Response::json(view::make('lms_lesson.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('lms_lesson.main_view')->with('mainData',$mainData)->with('course',$course);
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
        $validator = Validator::make($request->all(),LMSLesson::$mainRules);
        if($validator->passes()){

            $countData = LMSLesson::countData('name',$request->input('title'));
            
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'course_id' => $request->input('course'),
                    'name' => $request->input('title'),
                    'created_by' => Auth::user()->id,
                    'active_status' => Utility::STATUS_ACTIVE,
                    'status' => Utility::STATUS_ACTIVE
                ];
                
                LMSLesson::create($dbDATA);

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
        $leave_type = LMSLesson::firstRow('id',$request->input('dataId'));
        return view::make('lms_lesson.edit_form')->with('edit',$leave_type);

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
        $validator = Validator::make($request->all(),LMSLesson::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'name' => ucfirst($request->input('title')),
            ];
           
            $rowData = LMSLesson::firstRow('name', $request->input('name'));
            if(!empty($rowData)){
                if ($rowData->id == $request->input('edit_id')) {

                    LMSLesson::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                LMSLesson::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

        $dbData = [
            'active_status' => $status
        ];
       
        LMSLesson::massUpdate('id',$idArray,$dbData);

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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = LMSLesson::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
