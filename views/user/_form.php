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
            <?= $form->field($model, 'lastName')->textInput(['maxlength' => true])->label('Фамилия') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Имя') ?>
        </div>
        <div class="col-md-3">
            <div class="form-group field-user-password">
                <label class="control-label" for="user-role">Роль</label>
                <?= Html::dropDownList('role', $role, $roles, ['class' => 'form-control']) ?>
                <div class="help-block"></div>
            </div>
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
            <?= $form->field($model, 'birthDate')->textInput(['maxlength' => true])->label('Дата рождения') ?>
        </div>
    </div>

    <div class="row">
<!--        <div class="col-md-3">-->
<!--            --><?//= $form->field($model, 'child')->dropDownList($pupils, ['prompt'=>'Нет']) ?>
<!--        </div>-->
        <div class="col-md-3">
            <?= $form->field($model, 'class')->dropDownList($classManagement, ['prompt'=>'Нет']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'parent')->dropDownList($parents, ['prompt'=>'Нет']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'classManagement')->dropDownList($classManagement, ['prompt'=>'Нет']) ?>
        </div>
    </div>

    <br>


<!--    --><?//= $form->field($model, 'isAdmin')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function() {
        function setFieldVisible(role) {
            var fieldDependents = {
                'pupil': {
                    'hideProps': ['classmanagement']
                },
                'teacher': {
                    'hideProps': ['class', 'parent']
                },
                'expert': {
                    'hideProps': ['classmanagement', 'class', 'parent']
                },
                'parent': {
                    'hideProps': ['classmanagement', 'class', 'parent']
                },
                'admin': {
                    'hideProps': []
                }
            };
            var eName = '.field-user-';

            $(eName + 'classmanagement').show();
            $(eName + 'class').show();
            $(eName + 'parent').show();

            fieldDependents[role].hideProps.forEach(function(item, i, arr){
                console.log(item);
                $(eName + item).hide();
            });
        }

        setFieldVisible($('select[name="role"]').val());
        $('select[name="role"]').on('change', function() {
            setFieldVisible($(this).val());
        });
    });
</script>
