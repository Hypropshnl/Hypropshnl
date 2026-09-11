<?php

namespace App\model;

use App\Helpers\Utility;
use Illuminate\Database\Eloquent\Model;

class OfflineCourse extends Model
{
    protected $table = 'offline_courses';

    protected $guarded = [];

    public static $mainRules = [
        'title' => 'required',
        'cert_template_id' => 'required|integer|exists:certificate_template,id',
        'name_one_role' => 'nullable|string',
        'name_two_role' => 'nullable|string',
        'name_one_sign' => 'nullable|mimes:jpeg,JPEG,jpg,JPG,png|max:2048|dimensions:width=860,height=352',
        'name_two_sign' => 'nullable|mimes:jpeg,JPEG,jpg,JPG,png|max:2048|dimensions:width=860,height=352',
    ];

    public function certificateTemplate()
    {
        return $this->belongsTo('App\model\CertificateTemplate', 'cert_template_id', 'id')->withDefault();
    }

    public function user_c()
    {
        return $this->belongsTo('App\User', 'created_by', 'id')->withDefault();
    }

    public function user_u()
    {
        return $this->belongsTo('App\User', 'updated_by', 'id')->withDefault();
    }

    private static function table()
    {
        return 'offline_courses';
    }

    public static function getAllData()
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->orderBy('id', 'DESC')->get();
    }

    public static function paginateAllData()
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->orderBy('id', 'DESC')->paginate(15);
    }

    public static function countData($column, $post)
    {
        return Utility::countData(self::table(), $column, $post);
    }

    public static function specialColumns($column, $post)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)
            ->orderBy('id', 'DESC')->get();
    }

    public static function firstRow($column, $post)
    {
        return static::where('status', '=', Utility::STATUS_ACTIVE)->where($column, '=', $post)->first();
    }

    public static function defaultUpdate($column, $postId, $arrayDataUpdate = [])
    {
        return static::where($column, $postId)->update($arrayDataUpdate);
    }

    public static function massUpdate($column, $arrayPost, $arrayDataUpdate = [])
    {
        return static::whereIn($column, $arrayPost)->update($arrayDataUpdate);
    }
}
