<?php

namespace backend\controllers;

use backend\models\PhotoImages;
use backend\models\Upload;
use yii;
use backend\models\PhotoAlbum;
use backend\models\search\PhotoAlbumSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlbumController implements the CRUD actions for Album model.
 */
class PhotoAlbumController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

   
    /**
     * Lists all Album models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhotoAlbumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Album model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Album model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PhotoAlbum();
        $image = new PhotoImages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $images = Yii::$app->request->post('img');
            $title = Yii::$app->request->post('title');
            $alt = Yii::$app->request->post('alt');
            $description = Yii::$app->request->post('description');
            $display_order = Yii::$app->request->post('display_order');
            foreach ($images as $key => $item){
                $image = new PhotoImages();
                $image->album_id = $model->id;
                $image->image = $images[$key];
                $image->title = $title[$key];
                $image->alt = $alt[$key];
                $image->description = $description[$key];
                $image->display_order = $display_order[$key];
                $image->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            $basePath = Yii::getAlias('@frontend/web');
            FileHelper::removeDirectory($basePath . '/' . $image->fileTempPath);

            return $this->render('create', [
                'model' => $model,
                'image' => $image,
            ]);
        }
    }

    /**
     * Updates an existing Album model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $images = $model->photoImages; //существующте изображения
        $image = new PhotoImages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $session = Yii::$app->session;
            $session->open();

            if ($session->has('delete_img') && !empty($session['delete_img'])){
                $delete_img = $session['delete_img'];
                PhotoImages::deleteOldImg($delete_img);
                $session['delete_img'] =[];
            }

            $images = Yii::$app->request->post('img');
            $title = Yii::$app->request->post('title');
            $alt = Yii::$app->request->post('alt');
            $description = Yii::$app->request->post('description');
            $display_order = Yii::$app->request->post('display_order');
            if($images){
                foreach ($images as $key => $item){
                    $image = PhotoImages::find()->where(['album_id' => $model->id])->andWhere(['image' => basename($images[$key])])->one();
                    if($image){//старое изображение
                        $image->title = $title[$key];
                        $image->alt = $alt[$key];
                        $image->description = $description[$key];
                        $image->display_order = $display_order[$key];
                        $image->save();
                    }else{ // новое изображение
                        $image = new PhotoImages();
                        $image->album_id = $model->id;
                        $image->image = $images[$key];
                        $image->title = $title[$key];
                        $image->alt = $alt[$key];
                        $image->description = $description[$key];
                        $image->display_order = $display_order[$key];
                        $image->save();
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'image' => $image,
                'images' => $images,
            ]);
        }
    }

    /**
     * Deletes an existing Album model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Album model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Album the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PhotoAlbum::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
