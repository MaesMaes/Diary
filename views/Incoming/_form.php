<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Incoming */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="incoming-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'childName')->dropDownList($pupils) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'parentName')->dropDownList($parents, ['prompt'=>'Нет']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'subject')->dropDownList($subject) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'sum')->textInput()->widget(\yii\widgets\MaskedInput::className(), [
                'name' => 'sum',
                'clientOptions' => [
                    'alias' => 'decimal',
                    'radixPoint' => '.',
                    'groupSeparator' => ' ',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
<!--        <div class="col-md-4">-->
<!--            --><?//= $form->field($model, 'date')->widget(DateTimePicker::classname(), [])?>
<!--        </div>-->
    </div>

    <?= $form->field($model, 'checkingAccount')->checkbox(['label' => 'На расчетный счет'])?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
