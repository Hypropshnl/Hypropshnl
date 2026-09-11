<?php
/**
 * Created by PhpStorm.
 * User: snweze
 * Date: 3/8/2018
 * Time: 9:22 AM
 */

namespace App\Helpers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Numbering
{


    //BIN TYPE NUMBERING
    public static function binType($table){
        
        $code = 'Bin-Type-';
        $data = DB::table($table)->where('status', Utility::STATUS_ACTIVE)->orderBy('id','DESC')->first();
        if(!empty($data)){
            $dataId = $data->id + 1;
            return $code.$dataId;
        }
        return $code.'1';
        

    }

    //WAREHOUSE NUMBERING
    public static function warhouse($table){
        
        $code = 'wh-';
        $data = DB::table($table)->where('status', Utility::STATUS_ACTIVE)->orderBy('id','DESC')->first();
        if(!empty($data)){
            $dataId = $data->id + 1;
            return $code.$dataId;
        }
        return $code.'1';
        

    }

    //INVENTORY NUMBERING
    public static function inventory($table){
        
        $code = 'Item-';
        $data = DB::table($table)->where('status', Utility::STATUS_ACTIVE)->orderBy('id','DESC')->first();
        if(!empty($data)){
            $dataId = $data->id + 1;
            return $code.$dataId;
        }
        return $code.'1';

    }

    //INVENTORY NUMBERING DURING IMPORT
    public static function inventoryImport($dataId){
        $code = 'Item-';
        return $code.$dataId;

    }

    //BIN NUMBERING
    public static function bin($table){
        
        $code = 'Bin-';
        $data = DB::table($table)->where('status', Utility::STATUS_ACTIVE)->orderBy('id','DESC')->first();
        if(!empty($data)){
            $dataId = $data->id + 1;
            return $code.$dataId;
        }
        return $code.'1';

    }

    //RFQ NUMBERING
    public static function rfq($table){
        
        $code = 'RFQ-';
        $data = DB::table($table)->where('status', Utility::STATUS_ACTIVE)->orderBy('id','DESC')->first();
        if(!empty($data)){
            $dataId = $data->id + 1;
            return $code.$dataId;
        }
        return $code.'1';

    }

    //PURCHASE ORDER NUMBERING
    public static function purchaseOrder($table){
            
        $code = 'PO-';
        $data = DB::table($table)->where('status', Utility::STATUS_ACTIVE)->orderBy('id','DESC')->first();
        if(!empty($data)){
            $dataId = $data->id + 1;
            return $code.$dataId;
        }
        return $code.'1';

    }

    //Quotes NUMBERING
    public static function quote($table){
            
        $code = 'Qt-';
        $data = DB::table($table)->where('status', Utility::STATUS_ACTIVE)->orderBy('id','DESC')->first();
        if(!empty($data)){
            $dataId = $data->id + 1;
            return $code.$dataId;
        }
        return $code.'1';

    }

    //MATERIAL REQUEST NUMBERING
    public static function materialRequest($table){
            
        $code = 'MR-';
        $data = DB::table($table)->where('status', Utility::STATUS_ACTIVE)->orderBy('id','DESC')->first();
        if(!empty($data)){
            $dataId = $data->id + 1;
            return $code.$dataId;
        }
        return $code.'1';

    }

    //MATERIAL REQUEST NUMBERING
    public static function storeLocation($table){
            
        $code = 'ST-';
        $data = DB::table($table)->where('status', Utility::STATUS_ACTIVE)->orderBy('id','DESC')->first();
        if(!empty($data)){
            $dataId = $data->id + 1;
            return $code.$dataId;
        }
        return $code.'1';

    }

   
}