<?php

namespace App\model;

use App\Helpers\Utility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MaterialRequestExtension extends Model
{
    //
    protected  $table = 'material_request_extension';

    private static function table(){
        return 'material_request_extension';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'due_date' => 'required',
    ];

    public static $editMiniRules = [
        'assigned_user' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id')->withDefault();

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id')->withDefault();

    }

    public function userDetail(){
        return $this->belongsTo('App\User','assigned_user','id')->withDefault();

    }

    public function vendorCon(){
        return $this->belongsTo('App\model\VendorCustomer','vendor','id')->withDefault();

    }

    public function currency(){
        return $this->belongsTo('App\model\Currency','trans_curr','id')->withDefault();

    }

    public function transCurr(){
        return $this->belongsTo('App\model\Currency','trans_curr','id')->withDefault();

    }

    public function assigned(){
        return $this->belongsTo('App\User','assigned_user','id')->withDefault();

    }

    public function project(){
        return $this->belongsTo('App\model\Project','project_id','id')->withDefault();

    }

    public function po(){
        return $this->hasMany('App\model\PurchaseOrder','uid','po_uid');

    }

    public function denyUser(){
        return $this->belongsTo('App\user','deny_user','id')->withDefault();

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate('15');
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

    public static function specialColumnsCustomPage($column, $post, $perPage)
    {
        
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate($perPage);

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

    public static function specialColumnsOrPage22($column, $column2, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)
        ->where(function ($query) use($column, $post, $column2){
            $query->where($column, '=',$post)->orWhere($column2, '=',$post);
       })->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumnsOr($column, $column2, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)
        ->where('complete_status', '=',Utility::STATUS_ACTIVE)
        ->where(function ($query) use($column, $post, $column2){
            $query->where($column, '=',$post)->orWhere($column2, '=',$post);
       })->orderBy('id','DESC')->get();

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

    public static function massDataPaginateNotEmpty2($column, $post, $column2, $post2)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '!=',$post)
        ->whereIn($column2,$post2)->orderBy('id','DESC')->paginate(Utility::P100);

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
        //return Utility::firstRow(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->first();

    }

    public static function firstRow2($column, $post,$column2, $post2)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->first();

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

    public static function searchMaterialRequest($value){
        return static::where('material_request_extension.status', '=',Utility::STATUS_ACTIVE)
            ->where(function ($query) use($value){
                $query->where('material_request_extension.mr_number','LIKE','%'.$value.'%')
                    ->orWhere('material_request_extension.due_date','LIKE','%'.$value.'%');
            })->get();
    }

    public static function searchMyMaterialRequest($value){
        return static::where('material_request_extension.status', '=',Utility::STATUS_ACTIVE)
            ->where('material_request_extension.complete_status', '=',Utility::STATUS_ACTIVE)
            ->where(function ($query) use($value){
                $query->where('material_request_extension.mr_number','LIKE','%'.$value.'%')
                    ->orwhere('material_request_extension.created_by', '=',Auth::user()->id)
                    ->orwhere('material_request_extension.assigned_user', '=',Auth::user()->id)
                    ->orWhere('material_request_extension.due_date','LIKE','%'.$value.'%');
            })->get();
    }

}
