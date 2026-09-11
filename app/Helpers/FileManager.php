<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class FileManager{

    const imageExt = ['jpg','JPG','jpeg','JPEG','png','PNG','gif'];

    const extStorage = 1, intStorage = 0;

    const storageType = self::intStorage;

    public static function imageUrl($imageName=''){

        if(self::storageType == self::extStorage){
            return env('AWS_URL').'images/'.$imageName;
        }else{
            return (env('APP_ENV') == 'local') ? public_path() . '/images/'.$imageName : env('SERVER_IMAGE_PATH').$imageName;
        }

    }

    public static function fileUrl($fileName=''){

        if(self::storageType == self::extStorage){
            //return ' https://uniq-bucket-test.s3.amazonaws.com/files/'.$fileName;
            return env('AWS_URL').'files/'.$fileName;
        }else{
            return (env('APP_ENV') == 'local') ?  public_path('files/') .$fileName : env('SERVER_FILE_PATH').$fileName;
        }

    }

    public static function assignName($file){
        
        if($file != ''){ 
            if(self::storageType == self::extStorage){
                $file_name = time() . "_" . $file->getClientOriginalName();
                return $file_name;
            }else{
                $file_name = time() . "_" . $file->getClientOriginalName() ."." .  $file->getClientOriginalExtension();
                return $file_name;
            }
            
        }
        return '';
    }

    public static function internalUpload($file){
          
        if(in_array( $file->getClientOriginalExtension(),self::imageExt)){
            $file->move(self::imageUrl(), self::assignName($file));
        }else{
            $file->move(self::fileUrl(), self::assignName($file));
        }
        
    }

    public static function externalUpload($file){
        
        if(in_array( $file->getClientOriginalExtension(),self::imageExt)){
            $filePath = 'images/' . self::assignName($file);
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            
        }else{
            $filePath = 'files/' . self::assignName($file);
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        
        //Storage::disk('s3')->url($file);

    }

   public static function getFileExtention($fileName){
        $explode = explode('.', $fileName);
        return end($explode);
   }

    public static function externalDownloadImageUrl($fileName){
        $headers = [
            'Content-Type'        => 'application/jpeg',
            'Content-Disposition' => 'attachment; filename="'. $fileName .'"',
        ];
        return Response::make(Storage::disk('s3')->get('images/'.$fileName), 200, $headers);
    }

    public static function externalDownloadFileUrl($fileName){
        $headers = [
            'Content-Type'        => 'application/jpeg',
            'Content-Disposition' => 'attachment; filename="'. $fileName .'"',
        ];
        return Response::make(Storage::disk('s3')->get('files/'.$fileName), 200, $headers);
    }

    public static function internalDownloadFileUrl($fileName){
        $download = self::fileUrl($fileName);
        return response()->download($download);
    }

    public static function internalDownloadImageUrl($fileName){
        $download = self::imageUrl($fileName);
        return response()->download($download);
    }

    public static function externalDeleteFileUrl($fileName){
        Storage::disk('s3')->delete('files/'. $fileName);
    }

    public static function externalDeleteImageUrl($fileName){
        Storage::disk('s3')->delete('images/'. $fileName);
    }

    public static function internalDeleteFileUrl($fileName){
        $fileUrl = self::fileUrl($fileName);
        if (file_exists($fileUrl) && !empty($fileName)) {
            unlink($fileUrl);
        }
    }

    public static function internalDeleteImageUrl($fileName){
        $fileUrl = self::imageUrl($fileName);
        if (file_exists($fileUrl) && !empty($fileName)) {
            unlink($fileUrl);
        }
    }

    public static function upload($file){
        if(self::storageType == self::extStorage){
            self::externalUpload($file);
        }else{
            self::internalUpload($file);
        }
    }

    public static function url($fileName){
        if(self::storageType == self::extStorage){
            if(in_array(self::getFileExtention($fileName),self::imageExt)){
                return self::imageUrl($fileName);
            }
            return self::fileUrl($fileName);
        }else{
            if(file_exists(self::imageUrl($fileName)) && !empty($fileName)){
                return self::imageUrl($fileName);
            }
            return self::fileUrl($fileName);
            
        }
    }

    public static function storeFile($file)
    {
        if (!$file) {
            return '';
        }

        $fileName = time() . "_" . Utility::generateUID(null, 20) .'_'. preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
        $file->move(
            Utility::FILE_URL(), $fileName
        );
        return $fileName;

    }

    public static function storeMultipleFile($files)
    {
        $storeArr = [];
        if (!$files || !is_array($files)) {
            return [];
        }

        foreach($files as $file){
            $fileName = time() . "_" . Utility::generateUID(null, 20) .'_'. preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
            
            $file->move(
                Utility::FILE_URL(), $fileName
            );
            //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A TEXT TYPE MYSQL COLUMN
            $storeArr[] =  $fileName;

        }
        return $storeArr;

    }


}