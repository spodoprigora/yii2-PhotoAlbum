<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PhotoAlbum */

$this->title = 'Update Photo Album: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Photo Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="photo-album-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'images' => $images,
        'image' => $image
    ]) ?>

</div>
