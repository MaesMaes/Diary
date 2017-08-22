<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EventNotes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-notes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'eventID')->textInput() ?>

    <?= $form->field($model, 'pupilID')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'worked')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
