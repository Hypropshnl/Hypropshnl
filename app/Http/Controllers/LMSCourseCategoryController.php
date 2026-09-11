<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\LMSCourse;
use App\model\LMSCourseCategory;
use App\model\TestUserAns;
use Auth;
use View;
use Validator;
use Illuminate\Http\Request;

class LMSCourseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mainData = LMSCourseCategory::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('lms_course_category.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('lms_course_category.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),LMSCourseCategory::$mainRules);
        if($validator->passes()){

            $countData = LMSCourseCategory::countData('name',$request->input('category_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'name' => ucfirst($request->input('category_name')),
                    'status' => Utility::STATUS_ACTIVE
                ];
                LMSCourseCategory::create($dbDATA);

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
        $dept = LMSCourseCategory::firstRow('id',$request->input('dataId'));
        return view::make('lms_course_category.edit_form')->with('edit',$dept);

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
        $validator = Validator::make($request->all(),LMSCourseCategory::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'name' => ucfirst($request->input('category_name')),
            ];
            $rowData = LMSCourseCategory::specialColumns('name', $request->input('category_name'));

            if(!empty($rowData)){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    LMSCourseCategory::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                LMSCourseCategory::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
            $rowDataCourse = LMSCourse::specialColumns('category_id', $all_id[$i]);
            if(count($rowDataCourse)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' category(ies) has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = LMSCourseCategory::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($unused).' category(ies) has been used in another module and cannot be deleted',
                'message' => 'warning'
            ]);

        }
    }

}
