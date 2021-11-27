<?php

namespace App\Traits;

use Image;
use Storage;

trait ResourceTrait
{
    public function saveImage($requestImage)
    {
        if (!empty($requestImage) && $requestImage != 'null') :
            $extension          = $requestImage->getClientOriginalExtension();
            $originalImage      = date('YmdHis') . "-" .rand(1, 50) .'.'.$extension;
            $image_thumbnail    = date('YmdHis') . "-" .'-40x40'.rand(1, 50) . '.'.$extension;

            $directory              = 'images/';

            if(!is_dir($directory)) {
                mkdir($directory);
            }

            $originalImageUrl      = $directory . $originalImage;
            $imageThumbnailUrl    = $directory . $image_thumbnail;

            Image::make($requestImage)->save($originalImageUrl, 80);
            Image::make($requestImage)->fit(40, 40)->save($imageThumbnailUrl, 80);

            $images = array(
                'original_image'    => $originalImageUrl,
                'image_thumbnail'   => $imageThumbnailUrl,
            );
            return $images;
        else:
            return false;
        endif;
    }

    public function deleteImage($files)
    {
        try {
            foreach ($files as $file):
                if($file !="" && file_exists($file)):
                    unlink($file);
                endif;
            endforeach;
            return true;
        } catch (\Exception $e){
            return false;
        }
    }

    public function saveFile($requested_file)
    {
        if (!empty($requested_file) && $requested_file != 'null') :
            $extension          = $requested_file->getClientOriginalExtension();
            $mime_type          = $requested_file->getMimeType();

            $originalFile     = date('YmdHis') . "_original_".rand(1, 50) .'.'.$extension;
            $directory        = 'files/';

            if(!is_dir($directory)) {
                mkdir($directory);
            }
            $originalFileUrl       = $directory . $originalFile;

            $requested_file->move($directory, $originalFileUrl);

            return $originalFileUrl;
        else:
            return false;
        endif;
    }

    public function deleteFile($file)
    {
        try {
            if($file !="" && file_exists($file)):
                unlink($file);
            endif;
            return true;
        } catch (\Exception $e){
            return false;
        }
    }
}
