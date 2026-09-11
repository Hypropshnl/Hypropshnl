<?php

namespace App\Http\Controllers;

use App\model\VehicleSpareParts;
use App\Helpers\Utility;
use Illuminate\Support\Facades\Auth;
use View;
use Validator;
use Illuminate\Http\Request;

class VehicleSparePartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mainData = VehicleSpareParts::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle_spare_parts.reload',array('mainData' => $mainData,
                ))->render());

        }else{
            return view::make('vehicle_spare_parts.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),VehicleSpareParts::$mainRules);
        if($validator->passes()){

            

            $dbDATA = [
                'vehicle_id' => $request->input('vehicle'),
                'part_no' => $request->input('part_no'),
                'name' => $request->input('name'),
                'quantity' => $request->input('quantity'),
                'location' => $request->input('location'),
                'active_status' => Utility::STATUS_ACTIVE,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            VehicleSpareParts::create($dbDATA);

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
        $request = VehicleSpareParts::firstRow('id',$request->input('dataId'));
        return view::make('vehicle_spare_parts.edit_form')->with('edit',$request);

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
        $validator = Validator::make($request->all(),VehicleSpareParts::$mainRules);
        if($validator->passes()) {
           
            $dbDATA = [
                'vehicle_id' => $request->input('vehicle'),
                'part_no' => $request->input('part_no'),
                'name' => $request->input('name'),
                'quantity' => $request->input('quantity'),
                'location' => $request->input('location'),
                'updated_by' => Auth::user()->id
            ];

            VehicleSpareParts::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function searchVehicleSpareParts(Request $request)
    {
       
        $search = VehicleSpareParts::searchVehicleSpareParts($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->id;
        }

        $data_ids = array_unique($obtain_array);
        $mainData =  VehicleSpareParts::massDataPaginate('id', $data_ids);
        //print_r($data_ids); die();
        if (count($data_ids) > 0) {

            return view::make('vehicle_spare_parts.search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }
    
    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));

        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        VehicleSpareParts::massUpdate('id', $idArray, $dbData);

        return response()->json([
            'message' => 'deleted',
            'message2' => 'Data deleted successfully'
        ]);

        //END FOR VEHICLE Service LOG DELETE

    }

}
