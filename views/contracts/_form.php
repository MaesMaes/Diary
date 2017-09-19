<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contracts */
/* @var $form yii\widgets\ActiveForm */
/* @var $contractTypesSelect array */
/* @var $parentsSelect array */
/* @var $childrenSelect array */
?>

<div class="banners-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'type_id')->dropDownList($contractTypesSelect) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'client_id')->dropDownList($parentsSelect) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'child_id')->dropDownList($childrenSelect) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'note')->textarea() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'datetime') ?>
        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if(!$model->isNewRecord) {
            echo Html::a($model->is_stopped ? 'Возобновить контракт' : 'Разорвать контракт', ['abort', 'id' => $model->id], ['class' => $model->is_stopped ? 'btn btn-success' : 'btn btn-danger']);
        }
        ?>

    </div>

    <?php ActiveForm::end(); ?>
</div>
