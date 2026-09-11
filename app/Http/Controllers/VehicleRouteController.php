<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\VehicleRoute;
use Illuminate\Support\Facades\Auth;
use View;
use Validator;
use Illuminate\Http\Request;

class VehicleRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $mainData = VehicleRoute::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle_route.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('vehicle_route.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),VehicleRoute::$mainRules);
        if($validator->passes()){
            
            $countData = VehicleRoute::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $dbDATA = [
                    'name' => $request->input('route_name'),
                    'vehicle_id' => $request->input('vehicle'),
                    'driver_id' => $request->input('driver'),
                    'pickup_points' => $request->input('pickup_points'),
                    'dropoff_points' => ucfirst($request->input('dropoff_points')),
                    'departure_time' => $request->input('departure_time'),
                    'arrival_time' => $request->input('arrival_time'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                VehicleRoute::create($dbDATA);

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
        $request = VehicleRoute::firstRow('id',$request->input('dataId'));
        return view::make('vehicle_route.edit_form')->with('edit',$request);

    }

    public function attachmentForm(Request $request)
    {
        //
        $request = VehicleRoute::firstRow('id',$request->input('dataId'));
        return view::make('vehicle_route.attach_form')->with('edit',$request);
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
        $validator = Validator::make($request->all(),VehicleRoute::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'name' => $request->input('route_name'),
                'vehicle_id' => $request->input('vehicle'),
                'driver_id' => $request->input('driver'),
                'pickup_points' => $request->input('pickup_points'),
                'dropoff_points' => ucfirst($request->input('dropoff_points')),
                'departure_time' => $request->input('departure_time'),
                'arrival_time' => $request->input('arrival_time'),
                'updated_by' => Auth::user()->id
            ];
            $rowData = VehicleRoute::specialColumns('name', $request->input('name'));
            if($rowData->count() > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    VehicleRoute::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                VehicleRoute::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function searchVehicle(Request $request)
    {
       
        $search = VehicleRoute::searchVehicle($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->id;
        }

        $data_ids = array_unique($obtain_array);
        $mainData =  VehicleRoute::massDataPaginate('driver_id', $data_ids);
        //print_r($data_ids); die();
        if (count($data_ids) > 0) {

            return view::make('vehicle_route.vehicle_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
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

            VehicleRoute::massUpdate('id', $idArray, $dbData);

            return response()->json([
                'message' => 'deleted',
                'message2' => 'Data deleted successfully'
            ]);

         //END FOR VEHICLE DELETE

    }

}
