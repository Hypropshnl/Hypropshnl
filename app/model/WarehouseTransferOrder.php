<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;
use Monolog\Handler\Curl\Util;

class WarehouseTransferOrder extends Model
{
    //
    protected  $table = 'warehouse_transfer_order';

    const BIN_MODEL = 'App\model\Bin';
    const WAREHOUSE_MODEL = 'App\model\Warehouse';
    const INVENTORY_MODEL = 'App\model\Inventory';
    const ZONE_MODEL = 'App\model\Zone';
    const USER_MODEL = 'App\User';

    private static function table(){
        return 'warehouse_transfer_order';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'from_warehouse' => 'required',
        'zone_id_from' => 'required',
        'bin_id_from' => 'required',
        'return_warehouse' => 'required',
        'zone_id_return' => 'required',
        'bin_id_return' => 'required',
        'inventory_item' => 'required',
        'order_desc' => 'required',
        'due_date' => 'required',
        'transfer_quantity' => 'required|digit',
    ];

    public static $mainRulesEdit = [
        'from_warehouse' => 'required',
        'zone_id_from1' => 'required',
        'bin_id_from1' => 'required',
        'return_warehouse' => 'required',
        'zone_id_return1' => 'required',
        'bin_id_return1' => 'required',
        'inventory_item' => 'required',
        'order_desc' => 'required',
        'due_date' => 'required',
        'transfer_quantity' => 'required',
    ];

    public static $updateOrderRules = [
        'return_quantity' => 'required',
        'password' => 'required',
        'order_status' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo(self::USER_MODEL,'created_by','id')->withDefault();

    }

    public function user_u(){
        return $this->belongsTo(self::USER_MODEL,'updated_by','id')->withDefault();

    }

    public function approve_user(){
        return $this->belongsTo(self::USER_MODEL,'approved_by','id')->withDefault();

    }

    public function inventory(){
        return $this->belongsTo(self::INVENTORY_MODEL,'inventory_id','id')->withDefault();

    }

    public function fromWarehouse(){
        return $this->belongsTo(self::WAREHOUSE_MODEL,'from_whse','id')->withDefault();

    }

    public function fromZone(){
        return $this->belongsTo(self::ZONE_MODEL,'from_zone','id')->withDefault();

    }

    public function fromBin(){
        return $this->belongsTo(self::BIN_MODEL,'from_bin','id')->withDefault();

    }

    public function toWarehouse(){
        return $this->belongsTo(self::WAREHOUSE_MODEL,'to_whse','id')->withDefault();

    }

    public function toZone(){
        return $this->belongsTo(self::ZONE_MODEL,'to_zone','id')->withDefault();

    }

    public function toBin(){
        return $this->belongsTo(self::BIN_MODEL,'to_bin','id')->withDefault();

    }

    public function returnWarehouse(){
        return $this->belongsTo(self::WAREHOUSE_MODEL,'return_whse','id')->withDefault();

    }

    public function returnZone(){
        return $this->belongsTo(self::ZONE_MODEL,'return_zone','id')->withDefault();

    }

    public function returnBin(){
        return $this->belongsTo(self::BIN_MODEL,'return_bin','id')->withDefault();

    }



    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P35);
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::where('status', '=','1')->orderBy('id','DESC')->get();

    }

    public static function countData($column, $post)
    {
        return Utility::countData(self::table(),$column, $post);

    }

    public static function specialColumns($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPage($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumns2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPage2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumns3($column, $post, $column2, $post2, $column3, $post3)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPage3($column, $post, $column2, $post2, $column3, $post3)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumnsDate($dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)//->whereBetween('created_at',$dateArray)
        ->whereDate('created_at', '>=', $dateArray[0])->whereDate('created_at', '<=', $dateArray[1])
        ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsDate3($column, $post, $dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            //->whereBetween('created_at',$dateArray)
            ->whereDate('created_at', '>=', $dateArray[0])->whereDate('created_at', '<=', $dateArray[1])
            ->orderBy('id','DESC')->get();

    }

    public static function massData($column, $post = [])
    {
        //return Utility::massData(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->orderBy('id','DESC')->get();

    }

    public static function massDataPaginate($column, $post = [])
    {
        //return Utility::massData(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function massDataCondition($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)->where($column2, '=',$post2)
            ->orderBy('id','DESC')->get();

    }

    public static function massDataConditionPaginate($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)->where($column2, '=',$post2)
            ->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function massDataMassCondition($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->whereIn($column2,$post2)
            ->orderBy('id','DESC')->get(Utility::P35);

    }

    public static function massDataMassConditionPaginate($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->whereIn($column2,$post2)
            ->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function firstRow($column, $post)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->first();

    }

    public static function firstRow2($column, $post,$column2, $post2)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->where($column2, '=',$post2)->first();

    }

    public static function firstRow3($column, $post2,$column2, $post,$column3, $post3)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)->first();

    }

    public static function massUpdate($column, $arrayPost, $arrayDataUpdate=[])
    {
        return static::whereIn($column , $arrayPost)->update($arrayDataUpdate);

    }

    public static function defaultUpdate($column, $postId, $arrayDataUpdate=[])
    {

        return static::where($column , $postId)->update($arrayDataUpdate);

    }
    public static function deleteItem($postId)
    {
        return Utility::deleteItem(self::table(),$postId);

    }

    public static function deleteItemData($id,$postId)
    {
        return Utility::deleteItemData(self::table(),$id,$postId);

    }

    public static function searchWarehouseTransferOrder($value){
        return static::where('warehouse_transfer_order.status',Utility::STATUS_ACTIVE)
            ->leftjoin('inventory', 'inventory.id', '=', 'warehouse_transfer_order.inventory_id')
            ->where(function ($query) use($value){
                $query->where('inventory.item_name','LIKE','%'.$value.'%')
                    ->orWhere('warehouse_transfer_order.order_id','LIKE','%'.$value.'%');
            })->get(['warehouse_transfer_order.id']);
    }

}
