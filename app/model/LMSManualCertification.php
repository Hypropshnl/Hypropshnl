<?php

namespace App\model;

use App\Helpers\Utility;
use Illuminate\Database\Eloquent\Model;

class LMSManualCertification extends Model
{
    protected $table = 'lms_manual_certification';

    private static function table()
    {
        return 'lms_manual_certification';
    }

    protected $guarded = [];

    public static $mainRules = [
        'offline_course' => 'required|integer|exists:offline_courses,id',
        'selected_items' => 'required',
        'issue_date' => 'required',
    ];

    public function user_c()
    {
        return $this->belongsTo('App\User', 'created_by', 'id')->withDefault();
    }

    public function user_u()
    {
        return $this->belongsTo('App\User', 'updated_by', 'id')->withDefault();
    }

    public function department()
    {
        return $this->belongsTo('App\model\Department', 'dept_id', 'id')->withDefault();
    }

    public function userData()
    {
        return $this->belongsTo('App\User', 'user_id', 'id')->withDefault();
    }

    public function tempUserData()
    {
        return $this->belongsTo('App\model\TempUsers', 'temp_user', 'id')->withDefault();
    }

    public function offlineCourse()
    {
        return $this->belongsTo('App\model\OfflineCourse', 'course_id', 'id')->withDefault();
    }

    public function departmentData()
    {
        return $this->belongsTo('App\model\Department', 'dept_id', 'id')->withDefault();
    }

    public static function paginateAllData()
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->orderBy('id', 'DESC')->paginate(Utility::P50);
    }

    public static function getAllData()
    {
        return static::where('status', '=', '1')->orderBy('id', 'DESC')->get();
    }

    public static function countData($column, $post)
    {
        return Utility::countData(self::table(), $column, $post);
    }

    public static function specialColumns($column, $post)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)->orderBy('id', 'DESC')->get();
    }

    public static function specialColumnsPage($column, $post)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)->orderBy('id', 'DESC')->paginate(Utility::P50);
    }

    public static function specialColumns2($column, $post, $column2, $post2)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)
            ->where($column2, '=', $post2)->orderBy('id', 'DESC')->get();
    }

    public static function specialColumnsPage2($column, $post, $column2, $post2)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)
            ->where($column2, '=', $post2)->orderBy('id', 'DESC')->paginate(Utility::P35);
    }

    public static function specialColumns3($column, $post, $column2, $post2, $column3, $post3)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)
            ->where($column2, '=', $post2)->where($column3, '=', $post3)->orderBy('id', 'DESC')->get();
    }

    public static function specialColumnsPage3($column, $post, $column2, $post2, $column3, $post3)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)
            ->where($column2, '=', $post2)->where($column3, '=', $post3)->orderBy('id', 'DESC')->paginate(Utility::P35);
    }

    public static function massData($column, $post)
    {
        return Utility::massData(self::table(), $column, $post);
    }

    public static function massDataPaginate($column, $post = [])
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->whereIn($column, $post)
            ->orderBy('id', 'DESC')->paginate(Utility::P50);
    }

    public static function massDataCondition($column, $post, $column2, $post2)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->whereIn($column, $post)->where($column2, '=', $post2)
            ->orderBy('id', 'DESC')->get();
    }

    public static function massDataConditionPaginate($column, $post, $column2, $post2)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->whereIn($column, $post)->where($column2, '=', $post2)
            ->orderBy('id', 'DESC')->paginate(Utility::P50);
    }

    public static function massDataConditionPaginate2($column, $post, $column2, $post2, $column3, $post3)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->whereIn($column, $post)->where($column2, '=', $post2)
        ->where($column3, '=', $post3)->orderBy('id', 'DESC')->paginate(Utility::P50);
    }

    public static function firstRow($column, $post)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)->first();
    }

    public static function firstRow2($column, $post, $column2, $post2)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)
            ->where($column2, '=', $post2)->first();
    }

    public static function firstRow3($column, $post, $column2, $post2, $column3, $post3)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)
            ->where($column2, '=', $post2)->where($column3, '=', $post3)->first();
    }

    public static function massUpdate($column, $arrayPost, $arrayDataUpdate = [])
    {
        return static::whereIn($column, $arrayPost)->update($arrayDataUpdate);
    }

    public static function defaultUpdate($column, $postId, $arrayDataUpdate = [])
    {
        return static::where($column, $postId)->update($arrayDataUpdate);
    }
}
