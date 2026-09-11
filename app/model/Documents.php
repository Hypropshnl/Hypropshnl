<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;
use Dom\Document;

class Documents extends Model
{
    //
    protected  $table = 'documents';

    private static function table(){
        return 'documents';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'document_name' => 'required',
        'document_category' => 'required',
        'attachment.*' => 'mimes:png,jpg,jpeg,doc,docx,pdf,xls,xlsx,ppt|max:6144',
    ];

    public static $mainRulesEdit = [
        'document_name' => 'required',
        'document_category' => 'required',
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

    public function docCategory(){
        return $this->belongsTo('App\model\DocumentCategory','category_id','id')->withDefault();

    }

    public function documentFiles(){
        return $this->hasMany('App\model\DocumentFiles','document_id','id')->where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC');

    }

    public function archivedAttachments(){
        return $this->hasMany('App\model\DocumentFiles','document_id','id')->where('status', '=',Utility::STATUS_DELETED)->orderBy('id','DESC');

    }

    public function childDocuments(){
        return $this->hasMany('App\model\Documents','parent_id','id')->where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC');

    }

    public function parentDocument(){
        return $this->belongsTo('App\model\Documents','parent_id','id')->withDefault();

    }

    /**
     * Recursive status update
     */
    public function deleteRestoreWithChildren(int $status)
    {
        // Update current folder
        $this->status = $status;
        $this->save();

        // Get child folders
        $children = Documents::where('parent_id', $this->id)->get();

        // Recursive loop
        foreach ($children as $child) {

            // Call same function again
            $child->deleteRestoreWithChildren($status);
        }
    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate('15');
        //return Utility::paginateAllData(self::table());

    }

    public static function paginateAllDataNull()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereNull('parent_id')->orderBy('id','DESC')->paginate(Utility::P35);
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

    public static function firstRow2($table,$column, $post2,$column2, $post)
    {
        return Utility::firstRow2($table,$column, $post2,$column2, $post);

    }

    public static function massUpdate($column, $arrayPost, $arrayDataUpdate=[])
    {
        return static::whereIn($column , $arrayPost)->update($arrayDataUpdate);

    }

    public static function defaultUpdate($column, $postId, $arrayDataUpdate=[])
    {

        return static::where($column , $postId)->update($arrayDataUpdate);

    }

    public static function searchDocument($column, $post,$type)
    {
        return static::where('status', '=',$type)->where($column,'LIKE','%'.$post.'%')->orderBy('id','DESC')->get();

    }

    public static function paginateDocumentArchive()
    {
        return static::where('status', '=',Utility::STATUS_DELETED)->orderBy('id','DESC')->paginate(Utility::P50);
        //return Utility::paginateAllData(self::table());

    }

    public static function paginateDocumentArchiveNull()
    {
        return static::where('status', '=',Utility::STATUS_DELETED)->orderBy('id','DESC')->whereNull('parent_id')->paginate(Utility::P50);
        //return Utility::paginateAllData(self::table());

    }

    public static function searchUsingDate($dateArray,$type)
    {
        return static::where('status', '=',$type)//->whereBetween('created_at',$dateArray)
        ->whereDate('created_at', '>=', $dateArray[0])->whereDate('created_at', '<=', $dateArray[1])
        ->orderBy('id','DESC')->get();

    }

    public static function massDataConditionDate($column, $post, $type, $dateArray)
    {

        return static::where('status', '=',$type)->whereIn($column, $post)
            ->whereIn($column, $post)//->whereBetween('created_at',$dateArray)
            ->whereDate('created_at', '>=', $dateArray[0])->whereDate('created_at', '<=', $dateArray[1])
            ->orderBy('id','DESC')->get();
    }

    /**
     * Search documents by filename in the JSON 'docs' column
     * Performs O(n) linear search through all documents and their attachments
     *
     * @param string $filename - The filename to search for (partial match supported)
     * @param string $status - Document status filter (default: active)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchByAttachmentFilename($filename, $status = null)
    {
        $status = $status ?? Utility::STATUS_ACTIVE;

        // Get all documents with the specified status
        $documents = static::where('status', '=', $status)->get();

        $matchingDocuments = collect();

        // O(n) search through each document
        foreach ($documents as $document) {
            // Decode the JSON docs column
            $attachments = json_decode($document->docs, true);

            // Skip if no attachments or invalid JSON
            if (!is_array($attachments) || empty($attachments)) {
                continue;
            }

            // Search for filename in the attachments array (case-insensitive)
            foreach ($attachments as $attachment) {
                if (stripos($attachment, $filename) !== false) {
                    $matchingDocuments->push($document);
                    break; // Found match, no need to check other attachments in this document
                }
            }
        }

        return $matchingDocuments;
    }

    /**
     * Search documents by filename in the JSON 'docs' column with pagination
     * Performs O(n) linear search but returns paginated results
     *
     * @param string $filename - The filename to search for (partial match supported)
     * @param int $perPage - Number of results per page
     * @param string $status - Document status filter (default: active)
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function searchByAttachmentFilenamePaginated($filename, $perPage = 15, $status = null)
    {
        $matchingDocuments = self::searchByAttachmentFilename($filename, $status);

        // Manual pagination since we're working with a collection
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $items = $matchingDocuments->forPage($currentPage, $perPage);

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $matchingDocuments->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'pageName' => 'page']
        );
    }

}
