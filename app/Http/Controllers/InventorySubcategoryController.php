<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\InventoryCategory;
use App\model\InventorySubcategory;
use Auth;
use View;
use Validator;
use Illuminate\Http\Request;

class InventorySubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mainData = InventorySubcategory::specialColumns('category_id',$request->input('dataId'));
        $InventoryCategoryId = $request->input('dataId');

        if ($request->ajax()) {
            return \Response::json(view::make('inventory_category.sub_category',array('mainData' => $mainData,
                'inventoryCategoryId' => $InventoryCategoryId))->render());

        }else{
            return view::make('inventory_category.sub_category')->with('mainData',$mainData)->with('inventoryCategoryId',$InventoryCategoryId);
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
        $validator = Validator::make($request->all(),InventorySubcategory::$mainRules);
        if($validator->passes()){
            $inputValues = json_decode($request->input('input_class'));

            for($i=0;$i<count($inputValues);$i++){
                $dbDATA = [
                    'category_id' => $request->input('edit_id'),
                    'name' => $inputValues[$i],
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];


                InventorySubcategory::create($dbDATA);

            }

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
    public function addForm(Request $request)
    {
        //
        $warehouse = InventoryCategory::firstRow('id',$request->input('dataId'));
        return view::make('inventory_category.add_form')->with('edit',$warehouse);

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
        InventorySubcategory::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);


    }

}

