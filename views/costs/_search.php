<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CostsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="costs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'costsID') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'itemOfExpenditure') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'sum') ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
