<?php

namespace App\model;

use App\Helpers\Utility;
use Illuminate\Database\Eloquent\Model;

class VendorsPool extends Model
{
    //
    protected  $table = 'vendors_pool';

    private static function table(){
        return 'vendors_pool';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public static $mainRules = [
        'memo' => 'required|mimes:png,jpg,jpeg,pdf|max:6144',
        'hse_policy_doc' => 'mimes:png,jpg,jpeg,pdf|max:6144',
        'iso_doc' => 'mimes:png,jpg,jpeg,pdf|max:6144',
        'reference_doc' => 'required|mimes:png,jpg,jpeg,pdf|max:6144',
        'company_profile' => 'mimes:png,jpg,jpeg,pdf|max:6144',
        'company_name' => 'required',
        'currency' => 'required',
        'address' => 'required',
        'country' => 'required',
        'company_no' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'contact_email' => 'required',
        'contact_name' => 'required',
        'tax_no' => 'required',
        'bank_name' => 'required',
        'account_no' => 'required',
        'account_name' => 'required',
        'job_category' => 'required',
        'annual_turnover' => 'required',
        'hse_cert' => 'required',
        'iso_cert' => 'required',
        'reference' => 'required',
    ];
    

    public function currencyData(){
        return $this->belongsTo('App\model\Currency','currency','id');
    }

    public function countryData(){
        return $this->belongsTo('App\model\Country','country_id','id');
    }

    public function approval(){
        return $this->belongsTo('App\model\VendorsPoolApprovalSys','approval_id','id');

    }

    public function denyUser(){
        return $this->belongsTo('App\user','deny_user','id');

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P100);
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

    public static function countData2($column, $post,$column2, $post2)
    {
        return Utility::countData2(self::table(),$column, $post,$column2, $post2);

    }

    public static function specialColumns($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('company_name','DESC')->get();

    }

    public static function specialColumnsPage($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('company_name','DESC')->paginate(Utility::P35);

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

    public static function specialColumnsCustomPage($column, $post, $perPage)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate($perPage);

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

        return static::where($column , '=', $postId)->update($arrayDataUpdate);

    }

    public static function searchVendor($value){
        return static::where('vendors_pool.status', '=',Utility::STATUS_ACTIVE)
            ->where(function ($query) use($value){
                $query->where('vendors_pool.company_name','LIKE','%'.$value.'%')
                    ->orWhere('vendors_pool.address1','LIKE','%'.$value.'%') ->orWhere('vendors_pool.phone','LIKE','%'.$value.'%')
                    ->orWhere('vendors_pool.address2','LIKE','%'.$value.'%')->orWhere('vendors_pool.contact_name','LIKE','%'.$value.'%')
                    ->orWhere('vendors_pool.tax_no','LIKE','%'.$value.'%')->orWhere('vendors_pool.email','LIKE','%'.$value.'%')
                    ->orWhere('vendors_pool.vat_no','LIKE','%'.$value.'%')->orWhere('vendors_pool.company_no','LIKE','%'.$value.'%')
                    ->orWhere('vendors_pool.company_no','LIKE','%'.$value.'%')->orWhere('vendors_pool.bank_name','LIKE','%'.$value.'%')
                    ->orWhere('vendors_pool.bank_account_no','LIKE','%'.$value.'%')->orWhere('vendors_pool.bank_account_name','LIKE','%'.$value.'%');
            })->get();
    }

}
