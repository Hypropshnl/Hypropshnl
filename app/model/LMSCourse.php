<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class LMSCourse extends Model
{
    //
    protected  $table = 'lms_course';

    private static function table(){
        return 'lms_course';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    private const SIGN_IMAGE_RULES = 'nullable|mimes:jpeg,JPEG,jpg,JPG,png|max:2048';
    private const REQUIRED_SIGN_IMAGE_RULES = 'required|' . self::SIGN_IMAGE_RULES;

    public static $mainRules = [
        'course_category' => 'required',
        'course_name' => 'required',
        'course_code' => 'required',
        'name_one_sign' => self::REQUIRED_SIGN_IMAGE_RULES,
        'name_two_sign' => self::SIGN_IMAGE_RULES
    ];

    public static $mainRulesEdit = [
        'course_name' => 'required',
        'course_category' => 'required',
        'course_code' => 'required',
        'name_one_sign' => self::SIGN_IMAGE_RULES,
        'name_two_sign' => self::SIGN_IMAGE_RULES
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

    public function category(){
        return $this->belongsTo('App\model\LMSCourseCategory','category_id','id')->withDefault();

    }

    public function lessonMany(){
        return $this->hasMany('App\model\LMSLesson','couser_id','id');

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P50);

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

    public static function specialColumnsMass($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->orderBy('id','DESC')->get();

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

    public static function specialColumnsOr2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->orWhere($column2, '=',$post2)->orderBy('id','DESC')->get();

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
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function massData($column, $post)
    {
        return Utility::massData(self::table(),$column, $post);

    }

    public static function massDataPaginate($column, $post)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->orderBy('id','DESC')->paginate(Utility::P100);

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

    public static function searchCourse($value){
        return static::leftjoin('department', 'department.id', '=', 'lms_course.department_id')
            ->leftjoin('lms_course_category', 'lms_course_category.id', '=', 'lms_course.category_id')
            ->where('lms_course.status', '=',Utility::STATUS_ACTIVE)
            ->where('lms_course.active_status', '=',Utility::STATUS_ACTIVE)
            ->where(function ($query) use($value){
                $query->where('lms_course.name','LIKE','%'.$value.'%')
                    ->orWhere('lms_course.code','LIKE','%'.$value.'%') ->orWhere('lms_course.amount','LIKE','%'.$value.'%')
                    ->orWhere('lms_course_category.name','LIKE','%'.$value.'%')->orWhere('department.dept_name','LIKE','%'.$value.'%');
            })->orderBy('lms_course.id','DESC')->get(['lms_course.code']);
    }

}
