<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Ваше имя') ?>

    <?= $form->field($model, 'lastName')->textInput(['maxlength' => true])->label('Фамилия') ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label('Телефон') ?>

    <?= $form->field($model, 'birthDate')->textInput(['maxlength' => true])->label('Дата рождения') ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Почта') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Пароль') ?>

<!--    --><?//= $form->field($model, 'isAdmin')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
