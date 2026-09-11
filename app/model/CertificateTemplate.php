<?php

namespace App\model;

use App\Helpers\Utility;
use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $table = 'certificate_template';

    protected $guarded = [];

    public static $mainRules = [
        'name' => 'required',
        'cert_num_format' => 'required',
        'template_doc' => 'required|mimes:jpeg,JPEG,jpg,JPG,png|max:2048|dimensions:width=3600,height=2250',
        'logo' => 'nullable|mimes:jpeg,JPEG,jpg,JPG,png|max:2048',
        'stamp' => 'nullable|mimes:jpeg,JPEG,jpg,JPG,png|max:2048',
        'cert_name_pos_x' => 'nullable|numeric|required_with:cert_name_pos_y',
        'cert_name_pos_y' => 'nullable|numeric|required_with:cert_name_pos_x',
        'logo_pos_x' => 'nullable|numeric|required_with:logo_pos_y',
        'logo_pos_y' => 'nullable|numeric|required_with:logo_pos_x',
        'company_name_pos_x' => 'nullable|numeric|required_with:company_name_pos_y',
        'company_name_pos_y' => 'nullable|numeric|required_with:company_name_pos_x',
        'heading_pos_x' => 'nullable|numeric|required_with:heading_pos_y',
        'heading_pos_y' => 'nullable|numeric|required_with:heading_pos_x',
        'sub_heading_pos_x' => 'nullable|numeric|required_with:sub_heading_pos_y',
        'sub_heading_pos_y' => 'nullable|numeric|required_with:sub_heading_pos_x',
        'sub_heading_two_pos_x' => 'nullable|numeric|required_with:sub_heading_two_pos_y',
        'sub_heading_two_pos_y' => 'nullable|numeric|required_with:sub_heading_two_pos_x',
        'cert_num_format_pos_x' => 'nullable|numeric|required_with:cert_num_format_pos_y',
        'cert_num_format_pos_y' => 'nullable|numeric|required_with:cert_num_format_pos_x',
        'cert_id_display_pos_x' => 'nullable|numeric|required_with:cert_id_display_pos_y',
        'cert_id_display_pos_y' => 'nullable|numeric|required_with:cert_id_display_pos_x',
        'stamp_pos_x' => 'nullable|numeric|required_with:stamp_pos_y',
        'stamp_pos_y' => 'nullable|numeric|required_with:stamp_pos_x',
    ];

    public static $mainRulesEdit = [
        'name' => 'required',
        'cert_num_format' => 'required',
        'template_doc' => 'nullable|mimes:jpeg,JPEG,jpg,JPG,png|max:2048|dimensions:width=3600,height=2250',
        'logo' => 'nullable|mimes:jpeg,JPEG,jpg,JPG,png|max:2048',
        'stamp' => 'nullable|mimes:jpeg,JPEG,jpg,JPG,png|max:2048',
        'cert_name_pos_x' => 'nullable|numeric|required_with:cert_name_pos_y',
        'cert_name_pos_y' => 'nullable|numeric|required_with:cert_name_pos_x',
        'logo_pos_x' => 'nullable|numeric|required_with:logo_pos_y',
        'logo_pos_y' => 'nullable|numeric|required_with:logo_pos_x',
        'company_name_pos_x' => 'nullable|numeric|required_with:company_name_pos_y',
        'company_name_pos_y' => 'nullable|numeric|required_with:company_name_pos_x',
        'heading_pos_x' => 'nullable|numeric|required_with:heading_pos_y',
        'heading_pos_y' => 'nullable|numeric|required_with:heading_pos_x',
        'sub_heading_pos_x' => 'nullable|numeric|required_with:sub_heading_pos_y',
        'sub_heading_pos_y' => 'nullable|numeric|required_with:sub_heading_pos_x',
        'sub_heading_two_pos_x' => 'nullable|numeric|required_with:sub_heading_two_pos_y',
        'sub_heading_two_pos_y' => 'nullable|numeric|required_with:sub_heading_two_pos_x',
        'cert_num_format_pos_x' => 'nullable|numeric|required_with:cert_num_format_pos_y',
        'cert_num_format_pos_y' => 'nullable|numeric|required_with:cert_num_format_pos_x',
        'cert_id_display_pos_x' => 'nullable|numeric|required_with:cert_id_display_pos_y',
        'cert_id_display_pos_y' => 'nullable|numeric|required_with:cert_id_display_pos_x',
        'stamp_pos_x' => 'nullable|numeric|required_with:stamp_pos_y',
        'stamp_pos_y' => 'nullable|numeric|required_with:stamp_pos_x',
    ];

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
        return 'certificate_template';
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
