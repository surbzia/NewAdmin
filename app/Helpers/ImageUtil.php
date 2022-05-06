<?php 

namespace App\Helpers;
use DB;
use App\Helpers\Resize;
class ImageUtil 
{
  public static function getHref($img_path,$height,$width, $imageId){
    if($img_path){
    $imageName = $imageId.'-'.$height.'x'.$width;
    $extension = strtolower(strrchr($img_path, '.'));
    $image_returning = 'resized/'.$imageName.$extension;
    $fileCheck = public_path('storage/'.$image_returning);
    /*creating directory according to id if not exist*/
    $image_returning_id_directory = public_path('storage/resized');
    if(!file_exists($image_returning_id_directory)){
        mkdir($image_returning_id_directory);
    }
    /*creating directory according to id  if not exist end*/
    if(!file_exists($fileCheck)){
        /*Generating Image*/
        $image = public_path('storage/'.$img_path);
        $resizeObj = new Resize($image);
        $resizeObj->resizeImage($height,$width,'exact');
        $resizeObj->saveImage($fileCheck,45,$extension,'');
        /*Generating Image End*/
    }
    return asset($image_returning);
    }
  }
}