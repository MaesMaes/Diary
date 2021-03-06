<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Marks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="marks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'eventID')->textInput() ?>

    <?= $form->field($model, 'pupilID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test')->textInput() ?>

    <?= $form->field($model, 'test_theme')->textInput() ?>

    <?= $form->field($model, 'test_lesson')->textInput() ?>

    <?= $form->field($model, 'lights')->textInput() ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
