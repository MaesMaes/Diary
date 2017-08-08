<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IncomingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="incoming-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'incomingID') ?>

    <?= $form->field($model, 'childName') ?>

    <?= $form->field($model, 'subject') ?>

    <?= $form->field($model, 'sum') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'parentName') ?>

    <?php // echo $form->field($model, 'checkingAccount') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
