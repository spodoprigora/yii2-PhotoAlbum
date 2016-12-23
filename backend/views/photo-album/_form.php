<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PhotoAlbum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="album-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'display_order')->textInput() ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?php $i = 0; ?>
    <?php if(!empty($images)):?>
        <?foreach ($images as $key=>$img):?>
            <div class="row" data-num="<?=$i;?>">
                <div class="col-lg-4">
                    <?= Html::img($img->getPath() . $img->image, ['class' => 'img-responsive', 'style' => 'display:block']); ?>
                    <?= Html::hiddenInput('img['. $i .']', $img->getPath() . $img->image); ?>
                </div>
                <div class="col-lg-6">
                    <?= Html::label('title'); ?>
                    <?= Html::textInput('title['. $i .']', $img->title, ['class' => 'form-control']); ?>
                    <?= Html::label('alt'); ?>
                    <?= Html::textInput('alt['. $i .']', $img->alt, ['class' => 'form-control', 'rows' => 5]); ?>
                    <?= Html::label('description'); ?>
                    <?= Html::textarea('description['. $i .']', $img->description, ['class' => 'form-control', 'rows' => 3]); ?>
                    <?= Html::label('display order'); ?>
                    <?= Html::textInput('display_order['. $i .']', $img->display_order, ['class' => 'form-control int']); ?>
                    <div class="num_error"></div>
                </div>
                <div class="col-lg-2">
                    <?= Html::tag('span', 'Remove', ['class' => 'btn btn-danger img_delete-old']); ?>
                    <?= Html::hiddenInput('', $img->id, ['class' => 'delete-id']); ?>
                </div>
            </div>
            <hr>
            <br>
            <?php $i++;?>
        <?endforeach;?>
    <?php endif;?>
    <span id="count" class="hidden" data-count="<?=$i;?>"></span>

    <div id="images"><!--для аякс контента--></div>

    <div class="buttons">
        <?= Html::tag('span', 'Add images', ['class' => 'btn btn-info', 'id' => 'btn-add-image']); ?>
    </div>
    <?= Html::activeFileInput($image, 'imageFiles[]', ['id' => 'upload-image-button', 'multiple' =>'true', 'class' => 'hidden'])?>
    <br>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>