<?php

namespace App\Http\Controllers;

use App\Helpers\Numbering;
use App\Helpers\Utility;
use App\model\Department;
use App\model\StoreLocations;
use Illuminate\Support\Facades\Auth;
use View;
use Validator;
use Illuminate\Http\Request;

class StoreLocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $mainData = StoreLocations::paginateAllData();
        $dept = Department::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('store_locations.reload',array('mainData' => $mainData,'dept' => $dept))->render());

        }else{
            return view::make('store_locations.main_view')->with('mainData',$mainData)->with('dept',$dept);
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
        $validator = Validator::make($request->all(),StoreLocations::$mainRules);
        if($validator->passes()){

            $countData = StoreLocations::specialColumns2('name', $request->input('name'), 'dept_id', $request->input('department'));
            if(!empty($countData)){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry '
                ]);

            }else{
                $storeCode = ($request->input('code') !== null) ? $request->input('code') : Numbering::storeLocation('store_locations');
                $dbDATA = [
                    'name' => $request->input('name'),
                    'user_id' => $request->input('store_manager'),
                    'dept_id' => $request->input('department'),
                    'code' => $storeCode,
                    'address' => ucfirst($request->input('address_location')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                StoreLocations::create($dbDATA);

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
       
        $store = StoreLocations::firstRow('id',$request->input('dataId'));
        $dept = Department::getAllData();
        return view::make('store_locations.edit_form')->with('edit',$store)->with('dept',$dept);

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
        $validator = Validator::make($request->all(),StoreLocations::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'name' => $request->input('name'),
                'user_id' => $request->input('store_manager'),
                'dept_id' => $request->input('department'),
                'address' => ucfirst($request->input('address_location')),
                'updated_by' => Auth::user()->id
            ];
            $rowData = StoreLocations::firstRow2('name', $request->input('name'), 'dept_id', $request->input('department'));
            if(!empty($rowData)){
                if ($rowData->id == $request->input('edit_id')) {

                    StoreLocations::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                StoreLocations::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $delete = StoreLocations::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
