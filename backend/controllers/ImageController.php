<?php

namespace backend\controllers;

use yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use backend\models\PhotoImages;


class ImageController extends Controller
{


   



    //загрузка во временное хранилище
    public function actionUploadAjaxImage(){

        if(Yii::$app->request->isAjax){
            $tempFiles =[];
            $model = new PhotoImages(['scenario' => 'upload']);
            $model->imageFiles = UploadedFile::getInstancesByName('imageFiles');

            $basePath = Yii::getAlias('@frontend/web');
            $path = $basePath . '/' . $model->fileTempPath;

            $count = Yii::$app->request->post('count');

            if ($model->tempUpload()) {

                return $this->renderPartial('_form', ['model' => $model, 'count' => $count]);
            }

        }else{
            return false;
        }
        return false;
    }

    //удаляет временно загруженные файлы
    public function actionDeleteAjaxImage(){
        if(Yii::$app->request->isAjax){
            $file = Yii::$app->request->post('file');
            $path = Yii::getAlias('@frontend/web') . $file;
            if ( is_file ($path) && is_writable($path)) {
                unlink($path);
            }
        }
    }

    //записываем в сесию id изображений для удаления
    public function actionDeleteOldAjaxImage(){
        if(Yii::$app->request->isAjax){
            $session = Yii::$app->session;
            $session->open();

            if ($session->has('delete_img')){
                $delete_img = $session['delete_img'];
                $delete_img[] = (int)Yii::$app->request->post('id');
                $session['delete_img'] = $delete_img;
            }else{
                $delete_img[] = (int)Yii::$app->request->post('id');
                $session['delete_img'] = $delete_img;
            }
            return true;
        }
        return false;
    }
}
