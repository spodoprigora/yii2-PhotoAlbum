<?php

namespace backend\models;

use yii;
use common\models\photo\PhotoAlbum as BaseAlbum;


class PhotoAlbum extends BaseAlbum{

    public function getPhotoImages()
    {
        return $this->hasMany(PhotoImages::className(), ['album_id' => 'id']);
    }

    public function beforeDelete()
    {
        $images = $this->photoImages;

        $basePath = Yii::getAlias('@frontend/web');
        $path = $basePath . '/' . $images[0]->filePath . '/';
        foreach ($images as $image){
            if(is_file($path .$image->image) && is_writable($path .$image->image)){
                unlink($path .$image->image);
            }
           
        }

        return parent::beforeDelete();
    }

}