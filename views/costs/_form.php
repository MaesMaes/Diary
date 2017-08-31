<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Costs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="costs-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'itemOfExpenditure')->dropDownList($itemsOfExpenditure) ?>
        </div>
        <div class="col-md-3">
<!--            --><?//= $form->field($model, 'date')->widget(DateTimePicker::classname(), [])?>
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
        <div class="col-md-3">
            <?= $form->field($model, 'name')->dropDownList($users) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
