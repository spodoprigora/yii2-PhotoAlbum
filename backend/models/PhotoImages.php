<?php

namespace backend\models;

use yii;
use yii\helpers\ArrayHelper;
use common\models\photo\PhotoImage as BaseImage;


class PhotoImages extends BaseImage{

    public $fileTempPath = 'files/photo/temp';

    public $imageFiles;

    public function rules(){

        return ArrayHelper::merge(
            parent::rules(),
            [
                [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 20],
            ]
        );
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['upload'] =['imageFiles'];
        return $scenarios;
    }

    //загрузка изображений в временную папку
    public function tempUpload()
    {
        $basePath = Yii::getAlias('@frontend/web');
        if ($this->validate()) {
            if (!is_dir($basePath . '/' . $this->fileTempPath)) {
                mkdir($basePath . '/' . $this->fileTempPath, 0777, TRUE);
            }
            foreach ($this->imageFiles as $file) {
               if($file->saveAs($basePath . '/' . $this->fileTempPath .'/'. $this->transliterate($file->baseName) . '.' . $file->extension)){
                   chmod($basePath . '/' . $this->fileTempPath . '/' . $this->transliterate($file->baseName) . '.' . $file->extension, 0777);
               }
            }
            return true;
        } else {
            return false;
        }
    }

    public function getTempPath(){
       return '/' . $this->fileTempPath . '/';
    }

    public function getPath(){
        return '/' . $this->filePath . '/';
    }

    //перемещаем изображения из временной папки в постоянную
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {

            if(strstr($this->image, 'temp')!== false)
            {
               //новые добавленные изображения
                $basePath = Yii::getAlias('@frontend/web');
                $this->image = $this->transliterate(basename($this->image));

                $tempPath = $basePath . '/' . $this->fileTempPath . '/' . $this->image;
                $newPath = $basePath . '/' . $this->filePath . '/' . $this->image;
                chmod($basePath . '/' . $this->filePath, 0777);
                if(is_file($tempPath)){
                    copy($tempPath, $newPath);
                    chmod($newPath, 0777);
                    unlink($tempPath);
                }
            }
            return true;
        }
        return false;
    }

    public static function deleteOldImg($img_id){
        foreach ($img_id as $id){
            $image = PhotoImages::findOne($id);
            if($image){
                $path = Yii::getAlias('@frontend/web') . $image->getPath() . $image->image;
                if ( is_file ($path) && is_writable($path))
                {
                    unlink($path);
                }
                $image->delete();

            }
        }

    }

    public function transliterate($st) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
            'і' => 'i',   'ї' => 'yi',  "'" => '',
            "`" => '',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            'І' => 'I',   'Ї' => 'YI',
        );
        return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($st, $converter));
    }


}