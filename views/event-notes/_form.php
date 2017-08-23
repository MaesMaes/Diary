<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EventNotes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-notes-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'pupilID')->dropDownList($pupils) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'note')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'worked')->dropDownList([0 => 'Нет', 1 => 'Да']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
