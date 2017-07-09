<?php

use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Events */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="events-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'subject')->dropDownList($subjects) ?><br/>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [])?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'moderator')->dropDownList($moderators) ?><br/>
        </div>
    </div>

    <h4>Список участников</h4>
    <? if (!$model->isNewRecord) { ?>
        <?= GridView::widget([
            'dataProvider' => $dataProviderPupilsOnEvent,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'name'],
                ['attribute' => 'lastName'],
                [
                    'attribute' => 'birthDate',
                    'value' => function($model) {
                        return Yii::$app->formatter->asDate($model->birthDate);
                    }
                ],
                ['attribute' => 'className'],
            ],
        ]); ?>
    <? } else { ?>
        <p>Для добавлянения участников сначало создайте событие</p>
    <? } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <? if (!$model->isNewRecord) { ?>
            <a href="#myModal" class="btn btn-success btn-right" data-toggle="modal">Редактировать список участников</a>
        <? } ?>
    </div>

    <? if ($model->isNewRecord) { ?>
        <?php ActiveForm::end(); ?>
    <? } ?>

</div>

<? if (!$model->isNewRecord) { ?>
    <!-- HTML-код модального окна -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Добавить участников</h4>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body">
    <!--                --><?php //Pjax::begin(); ?>
    <!--                --><?php //$form = ActiveForm::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderPupils,
                        'filterModel' => $searchModelPupils,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            ['attribute' => 'name'],
                            ['attribute' => 'lastName'],
                            [
                                'attribute' => 'birthDate',
                                'value' => function($model) {
                                    return Yii::$app->formatter->asDate($model->birthDate);
                                }
                            ],
                            ['attribute' => 'className'],
                            [
                                'class'=>'kartik\grid\CheckboxColumn',
                                'vAlign'=>'middle',
    //                            'header' => 'доб',
                                'rowSelectedClass' => GridView::TYPE_SUCCESS,
                                'checkboxOptions' => function($model) {
//                                    echo '<pre>'; print_r($model->events);
//                                    if (!empty($model->events) &&
//                                        in_array(Yii::$app->request->get('id'), $model->events))
//                                        $model->events[0]->id == Yii::$app->request->get('id'))
                                    if ($model->isPupilInThisEvent(Yii::$app->request->get('id')))
                                        return ["value" => $model->id,  'checked' => 'true', 'event_id' => Yii::$app->request->get('id')];
                                },
                                'options' => ['class_id' => $model->id]
                            ]
                        ],
                    ]); ?>
                    <div class="modal-footer">
                        <?= Html::submitButton('Добавить в список участников', ['class' => 'btn btn-success']) ?>
                        <?php ActiveForm::end(); ?>
    <!--                    --><?php //Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>