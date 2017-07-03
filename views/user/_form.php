<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'signup-form form-register1'],
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Ваше имя') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'lastName')->textInput(['maxlength' => true])->label('Фамилия') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'birthDate')->textInput(['maxlength' => true])->label('Дата рождения') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label('Телефон') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Пароль') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Почта') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'photo')->textInput(['maxlength' => true])->label('Фото') ?>
        </div>
        <div class="col-md-3">
            <div class="form-group field-user-password">
                <label class="control-label" for="user-role">Роль</label>
                <?= Html::dropDownList('role', $role, $roles, ['class' => 'form-control']) ?><br/>
                <div class="help-block"></div>
            </div>
        </div>
    </div>



<!--    --><?//= $form->field($model, 'isAdmin')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
