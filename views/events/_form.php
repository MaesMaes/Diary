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

    <? if (!$model->isNewRecord) { ?>
<!--        --><?php //Pjax::begin(); ?>
    <? } ?>

    <?php $form = ActiveForm::begin(); ?> <br>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?><br/>
        </div>
<!--    </div>-->
<!--    <div class="row">-->
        <div class="col-md-3">
            <?= $form->field($model, 'subject')->dropDownList($subjects) ?><br/>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [])?>
        </div>
        <div class="col-md-2">
            <?php
                if (\app\models\User::isAdmin()) {
                    echo $form->field($model, 'moderator', ['readonly' => true])->dropDownList($moderators);
                } else {
                    echo $form->field($model, 'moderator')->dropDownList($moderators, ['disabled' => true, 'value' => Yii::$app->user->id]);
                }
            ?><br/>
        </div>
    </div>

    <h4>Список участников</h4>
    <? if (!$model->isNewRecord) { ?>
        <?= GridView::widget([
            'dataProvider' => $dataProviderPupilsOnEvent,
//            'filterModel' => $searchModelPupils,
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
                ['attribute' => 'point'],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ( $action === 'delete' ) {
                            return '/events/delete-pupil-from-event?id=' . $model->id;
                        }
                    }
                ],
            ],
        ]); ?>
    <? } else { ?>
        <p>Для добавлянения участников сначало создайте событие</p>
    <? } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <? if (!$model->isNewRecord) { ?>
            <?= Html::a('Добавить участников', ['pupils-list', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            <?= Html::a('Оценить участников', ['event-pupils-points', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <? } ?>
    </div>
    <?php ActiveForm::end(); ?>

    <? if ($model->isNewRecord) { ?>
<!--        --><?php //ActiveForm::end(); ?>
<!--        --><?php //Pjax::end(); ?>
    <? } ?>

</div>

<? if (!$model->isNewRecord) { ?>
<!--     HTML-код модального окна -->
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
                    <?php Pjax::begin([
                        'clientOptions' => [
                            'push' => false
                        ],
                    ]); ?>

<!--                    --><?php //$form = ActiveForm::begin([
//                        'action' => ['update', 'id' => $model->id],
//                        'method' => 'get',
//                    ]); ?>
<!--                    --><?//= $form->field($searchModelPupils, 'name') ?>
<!--                    <div class="form-group">-->
<!--                        --><?//= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
<!--                        --><?//= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
<!--                    </div>-->
<!--                    --><?php //ActiveForm::end(); ?>

<!--                    --><?php //$form = ActiveForm::begin(); ?>
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
                                'rowSelectedClass' => GridView::TYPE_SUCCESS,
                                'checkboxOptions' => function($model) {
                                    if ($model->isPupilInThisEvent(Yii::$app->request->get('id')))
                                        return ["value" => $model->id,  'checked' => 'true', 'event_id' => Yii::$app->request->get('id')];
                                },
                                'options' => ['class_id' => $model->id]
                            ]
                        ],
                    ]); ?>
                    <div class="modal-footer">
                        <?= Html::submitButton('Добавить в список участников', ['class' => 'btn btn-success']) ?>
<!--                        --><?php //ActiveForm::end(); ?>
                        <?php Pjax::end(); ?>
                    </div>
                    <?php
//                        $this->registerJs(
//                            '$("document").ready(function(){
//                                $("#new_note").on("pjax:end", function() {
//                                    $.pjax.reload({container:"#notes"});  //Reload GridView
//                                });
//                            });'
//                        );
                    ?>
                </div>
            </div>
        </div>
    </div>
<? } ?>