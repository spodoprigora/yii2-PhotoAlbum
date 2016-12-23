<?php
use yii\bootstrap\Html;
//форма с результатом Ajax загрузки изображений
?>
<div class="row">
    <?php $i = $count; //счетчик изображений?>
    <?php foreach ($model->imageFiles as $image): ?>
        <div class="row" data-num="<?=$i;?>">
            <div class="col-lg-4">
                <?= Html::img($model->getTempPath() . $model->transliterate($image->name), ['class' => 'img-responsive', 'style' => 'display:block']); ?>
                <?= Html::hiddenInput('img['. $i .']', $model->getTempPath() . $model->transliterate($image->name)); ?>
            </div>
            <div class="col-lg-6">
                <?= Html::label('title'); ?>
                <?= Html::textInput('title['. $i .']', '', ['class' => 'form-control']); ?>
                <?= Html::label('alt'); ?>
                <?= Html::textInput('alt['. $i .']', '', ['class' => 'form-control', 'rows' => 5]); ?>
                <?= Html::label('description'); ?>
                <?= Html::textarea('description['. $i .']', '',['class' => 'form-control', 'rows' => 3]); ?>
                <?= Html::label('display order'); ?>
                <?= Html::textInput('display_order['. $i .']', '',['class' => 'form-control int'  ]); ?>
                <div class="num_error"></div>
            </div>
            <div class="col-lg-2">
                <?= Html::tag('span', 'Remove', ['class' => 'btn btn-danger img_delete']); ?>
            </div>
        </div>
        <hr>
        <br>
        <?php $i++; ?>
    <?php endforeach; ?>
</div>