<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PhotoAlbum */

$this->title = 'Create Photo Album';
$this->params['breadcrumbs'][] = ['label' => 'Photo Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-album-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'image' => $image,
        'model_upload' => $model_upload,
    ]) ?>

</div>
