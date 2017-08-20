<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documents-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput() ?>
        </div>
        <? if (!$model->isNewRecord ): ?>
            <div class="col-md-2">
                <div class="form-group field-documents-name">
                    <label class="control-label" for="documents-name">Текущий файл</label><br>
                    <?=Html::a(explode('/', $model->path)[count(explode('/', $model->path)) - 1], Yii::$app->getHomeUrl() . $model->path, ['target' => '_blank']) ?>
                    <div class="help-block"></div>
                </div>
            </div>
        <? endif; ?>
        <div class="col-md-4">
            <? if ($model->isNewRecord ) { ?>
                <?= $form->field($model, 'docFile')->fileInput() ?>
            <? }else{ ?>
                <?= $form->field($model, 'docFile')->fileInput()->label('Перезаписать?') ?>
            <? }?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
