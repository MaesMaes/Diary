<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="school-class-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= Html::dropDownList('pupils', $selectedPupils, $pupils, ['class' => 'form-control', 'multiple' => true]) ?><!--<Br/>-->
    <h4>Добавить учеников</h4>
<pre>
    <? print_r($pupils); ?>
</pre>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
