<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class Requisition extends Model
{
    //
    protected  $table = 'requisition';

    private static function table(){
        return 'requisition';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'request_category' => 'required',
        'request_type' => 'required',
        'transaction_type' => 'required',
        'request_description' => 'required',
        'amount' => 'required',
        'currency' => 'required_if:transaction_type,2',
        'attachment' => 'array',
        'attachment.*' => 'mimes:png,jpg,jpeg,doc,docx,pdf,xls,xlsx,ppt|max:6144',
    ];

    public static $mainRulesEdit = [
        'request_category' => 'required',
        'request_type' => 'required',
        'request_description' => 'required',
        'amount' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id')->withDefault();

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id')->withDefault();

    }

    public function department(){
        return $this->belongsTo('App\model\Department','dept_id','id')->withDefault();

    }
    public function currency(){
        return $this->belongsTo('App\model\Currency','curr_id','id')->withDefault();

    }

    public function defCurrency(){
        return $this->belongsTo('App\model\Currency','default_curr','id')->withDefault();

    }

    public function approval(){
        return $this->belongsTo('App\model\ApprovalSys','approval_id','id')->withDefault();

    }

    public function requestType(){
        return $this->belongsTo('App\model\RequestType','req_type','id')->withDefault();

    }

    public function requestCat(){
        return $this->belongsTo('App\model\RequestCategory','req_cat','id')->withDefault();

    }

    public function project(){
        return $this->belongsTo('App\model\Project','proj_id','id')->withDefault();

    }

    public function requestUser(){
        return $this->belongsTo('App\user','request_user','id')->withDefault();

    }

    public function denyUser(){
        return $this->belongsTo('App\user','deny_user','id')->withDefault();

    }

    public function accountCat(){
        return $this->belongsTo('App\model\AccountCategory','acct_id','id')->withDefault();

    }

    public function loanRate(){
        return $this->belongsTo('App\model\LoanRates','loan_id','id')->withDefault();

    }

    public function currencyDetail(){
        return $this->belongsTo('App\model\Currency','curr_id','id')->withDefault();

    }

    public function mrData(){
        return $this->belongsTo('App\model\MaterialRequestExtension','material_request_id','id')->withDefault();

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P100);
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->get();

    }

    public static function customDataPaginate($numberOfItems)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)
            ->orderBy('id','DESC')->paginate($numberOfItems);

    }

    public static function customDataPaginate2($column, $post,$numberOfItems)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->orderBy('id','DESC')->paginate($numberOfItems);

    }

    public static function getAllDataByMonthYear($month,$year)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)->orderBy('id','DESC')->get();

    }

    public static function getAllDataByMonthYearApproved($month,$year)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereMonth('created_at', $month)
        ->where('approval_status', '=',Utility::STATUS_ACTIVE)->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            ->whereYear('created_at', $year)->orderBy('id','DESC')->get();

    }

    public static function countData($column, $post)
    {
        return Utility::countData(self::table(),$column, $post);

    }

    public static function specialColumns($column, $post)
    {
       
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsCustomPage($column, $post, $perPage)
    {
        
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate($perPage);

    }
	
	public static function specialColumnsPage($column, $post)
    {
        
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumnsByMonthYear($column,$post,$month,$year)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, $post)
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsByMonthYearApproved($column,$post,$month,$year)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, $post)
        ->where('approval_status', '=',Utility::STATUS_ACTIVE)->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)->orderBy('id','DESC')->get();

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

    public static function specialColumnsPageOr2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)
            ->where(function ($query) use($column, $post, $column2, $post2){
                 $query->where($column, '=',$post)->orWhere($column2, '=',$post2);
            })->orderBy('id','DESC')->paginate(Utility::P35);

    }
    
    public static function specialColumnsApprovedPageOr2($column, $post, $column2, $post2 )
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)
        	->where('complete_status', '=',Utility::STATUS_ACTIVE)
        	->where('approval_status', '=',Utility::STATUS_ACTIVE)    
        	->where('finance_status', '=',Utility::STATUS_ACTIVE)       
        	->where('payment_status', '=',Utility::STATUS_ACTIVE)       
                ->where(function ($query) use($column, $post, $column2, $post2){
                 $query->where($column, '=',$post)->orWhere($column2, '=',$post2);
            })->orderBy('id','DESC')->paginate(Utility::P35);

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

    public static function specialColumnsPage4($column, $post, $column2, $post2, $column3, $post3, $column4, $post4)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
		return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
		->where($column2, '=',$post2)->where($column3, '=',$post3)->where($column4, '=',$post4)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function massData($column, $post)
    {
        return Utility::massData(self::table(),$column, $post);

    }

    public static function massDataPaginate($column, $post)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->orderBy('id','DESC')->paginate(Utility::P100);

    }

    public static function massDataPaginate2($column, $post, $column2, $post2)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
        ->whereIn($column2,$post2)->orderBy('id','DESC')->paginate(Utility::P100);

    }

    public static function massDataCondition($column, $post, $column2, $post2)
    {
        return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);

    }

    public static function firstRow($column, $post)
    {
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

    ///////////////////////////////

    public static function specialArrayColumnsPageDate($column, $post,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            //->whereBetween('created_at',$dateArray)
            ->whereDate('created_at', '>=', $dateArray[0])->whereDate('created_at', '<=', $dateArray[1])
            ->orderBy('id','DESC')->get();

    }

    public static function specialArrayColumnsPageDate2($column, $post, $column2, $post2,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereIn($column2,$post2)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArrayColumnsPageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereIn($column2, $post2)->whereIn($column3, $post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArraySingleColumnsPageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereIn($column2, $post2)->where($column3, $post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArraySingleColumns1PageDate2($column, $post, $column2, $post2,$dateArray)
    {

        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, '=',$post2)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArraySingleColumns2PageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {

        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column,$post)
            ->whereIn($column2, $post2)->where($column3, $post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPageDate($column, $post,$dateArray)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPageDate2($column, $post, $column2, $post2,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function paginateAllDataDate($dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->where('payment_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();
        //return Utility::paginateAllData(self::table());

    }

}
