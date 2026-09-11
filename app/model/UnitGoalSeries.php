<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;
class UnitGoalSeries extends Model
{
    //
    protected  $table = 'unit_goal_series';

    private static function table(){
        return 'unit_goal_series';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'goal_set' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'appraisal_type' => 'required',
        'objectives_weight' => 'required',
        'technical_competency_weight' => 'required',
        'behavioral_competency_weight' => 'required',
        'rating.*' => 'required',
        'low_score.*' => 'required',
        'high_score.*' => 'required',
        'notification_number' => 'required',
        'notify_time' => 'required',
        'employee_deadline' => 'required',
        'reviewer_deadline' => 'required',
        'interval' => 'required',
    ];


    public static $editRules = [
        'goal_set' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'appraisal_type' => 'required',
        'objectives_score' => 'required',
        'technical_competency_score' => 'required',
        'behavioural_competency_score' => 'required',
        'rating_edit.*' => 'required',
        'low_score_edit.*' => 'required',
        'high_score_edit.*' => 'required',
        'notification_number' => 'required',
        'notify_time' => 'required',
        'employee_deadline' => 'required',
        'reviewer_deadline' => 'required',
        'interval' => 'required',
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

    public function position(){
        return $this->belongsTo('App\model\Position','position_id','id')->withDefault();

    }

    public function hod(){
        return $this->belongsTo('App\User','dept_head','id')->withDefault();

    }

    public function compCat(){
        return $this->belongsTo('App\model\SkillCompCat','sub_comp_cat','id')->withDefault();

    }

    public function compFrame(){
        return $this->belongsTo('App\model\SkillCompFrame','comp_category','id')->withDefault();

    }

    public function surveyData(){
        return $this->belongsTo('App\model\SurveySession','survey_id','id')->withDefault();

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P25);
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::where('status', '=','1')->orderBy('id','DESC')->get();

    }

    public static function paginateData3($column, $post, $column2, $post2, $column3, $post3)
    {
        //return  Utility::paginateData2(self::table(),$column, $post, $column2, $post2);
        return static::where($column, '=',$post)->where($column2, '=',$post2)
            ->where($column3, '=',$post3)->where('status', '=',Utility::STATUS_ACTIVE)
            ->orderBy('id','DESC')->paginate(Utility::P25);

    }

    public static function paginateData4($column, $post, $column2, $post2, $column3, $post3, $column4, $post4)
    {
        //return  Utility::paginateData2(self::table(),$column, $post, $column2, $post2);
        return static::where($column, '=',$post)->where($column2, '=',$post2)->where($column3, '=',$post3)
            ->where($column4, '=',$post4)->where('status', '=',Utility::STATUS_ACTIVE)
            ->orderBy('id','DESC')->paginate(Utility::P25);

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

    public static function massData($column, $post)
    {
        return Utility::massData(self::table(),$column, $post);

    }
    public static function massDataCondition($column, $post, $column2, $post2)
    {
        return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);

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


}
