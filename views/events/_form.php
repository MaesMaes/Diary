<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
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
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->dropDownList($model->eventTypes); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?><br/>
        </div>
<!--    </div>-->
<!--    <div class="row">-->
        <div class="col-md-3">
            <?= $form->field($model, 'subject')->dropDownList($subjects) ?><br/>
        </div>
        <div class="col-md-3">
            <?php
            if (\app\models\User::isAdmin()) {
                echo $form->field($model, 'moderator')->dropDownList($moderators);
            } else {
                echo $form->field($model, 'moderator')->dropDownList($moderators, ['disabled' => 'disabled', 'value' => Yii::$app->user->id]);
            }
            ?><br/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'date')->widget(DateTimePicker::classname(), [])?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'duration')->textInput(['maxlength' => true])?>
        </div>
    </div>

    <h4>Список участников</h4>
    <? if (!$model->isNewRecord) { ?>
        <?= GridView::widget([
            'dataProvider' => $dataProviderPupilsOnEvent,
//            'filterModel' => $searchModelPupils,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'lastName'],
                ['attribute' => 'name'],
                ['attribute' => 'className'],
                [
                    'header' => 'Контрольная работа',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{test-mark}',
                    'buttons' => [
                        'test-mark' => function ($url,$model,$key) {
                            return Html::dropDownList(
                                'list',
                                5,
                                [0 => '-', 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                                ['data-pupil-id' => $model->id, 'class' => 'js-set-test__mark']
                            );
                        },
                    ],
                ],
                [
                    'header' => 'Срез по итогам темы',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{test-theme-mark}',
                    'buttons' => [
                        'test-theme-mark' => function ($url,$model,$key) {
                            return Html::dropDownList(
                                'list',
                                5,
                                [0 => '-', 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                                ['data-pupil-id' => $model->id, 'class' => 'js-set-test__theme__mark']
                            );
                        },
                    ],
                ],
                [
                    'header' => 'Срез по итогам урока',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{test-lesson-mark}',
                    'buttons' => [
                        'test-lesson-mark' => function ($url,$model,$key) {
                            return Html::input('string', 'test__lesson__mark', 50, ['data-pupil-id' => $model->id, 'class' => 'js-set-test__lesson__mark test__lesson__mark'])
                                 . Html::tag('span', '%', ['class' => 'test__lesson__percent']);
                        },
                    ],
                ],
                [
                    'header' => 'Светофор',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{lights-green}{lights-yellow}{lights-red}',
                    'buttons' => [
                        'lights-green' => function ($url,$model,$key) {
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-lights-green lights lights-green']);
                        },
                        'lights-yellow' => function ($url,$model,$key) {
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-lights-yellow lights lights-yellow']);
                        },
                        'lights-red' => function ($url,$model,$key) {
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-lights-red lights lights-red']);
                        },
                    ],
                ],
                [
                    'header' => 'Активность на уроке',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{smile-1}{smile-2}{smile-3}{smile-4}',
                    'buttons' => [
                        'smile-1' => function ($url,$model,$key) {
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-smile__1 smile smile-1']);
                        },
                        'smile-2' => function ($url,$model,$key) {
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-smile__2 smile smile-2']);
                        },
                        'smile-3' => function ($url,$model,$key) {
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-smile__3 smile smile-3']);
                        },
                        'smile-4' => function ($url,$model,$key) {
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-smile__4 smile smile-4']);
                        },
                    ],
                ],
                [
                    'header' => 'Замечания',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{notes}',
                    'buttons' => [
                        'notes' => function ($url,$model,$key) {
                            return Html::a('Добавить замечание', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-notes btn event-notes']);
                        },
                    ],
                ],
//                <a href="#myModal" class="btn btn-primary" data-toggle="modal">Открыть модальное окно</a>
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ( $action === 'delete' ) {
                            return '/events/delete-pupil-from-event?id=' . $model->id;
                        }
                    },
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
<!--            --><?//= Html::a('Оценить участников', ['event-pupils-points', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <? } ?>
    </div>
    <?php ActiveForm::end(); ?>

    <? if ($model->isNewRecord) { ?>
<!--        --><?php //ActiveForm::end(); ?>
<!--        --><?php //Pjax::end(); ?>
    <? } ?>

</div>

<? if (!$model->isNewRecord) { ?>
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Оценить ученика</h4>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body">
<!--                    --><?php //Pjax::begin([
//                        'clientOptions' => [
//                            'push' => false
//                        ],
//                    ]); ?>

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
<!--                    --><?//= GridView::widget([
//                        'dataProvider' => $dataProviderPupils,
//                        'filterModel' => $searchModelPupils,
//                        'columns' => [
//                            ['class' => 'yii\grid\SerialColumn'],
//                            ['attribute' => 'name'],
//                            ['attribute' => 'lastName'],
//                            [
//                                'attribute' => 'birthDate',
//                                'value' => function($model) {
//                                    return Yii::$app->formatter->asDate($model->birthDate);
//                                }
//                            ],
//                            ['attribute' => 'className'],
//                            [
//                                'class'=>'kartik\grid\CheckboxColumn',
//                                'vAlign'=>'middle',
//                                'rowSelectedClass' => GridView::TYPE_SUCCESS,
//                                'checkboxOptions' => function($model) {
//                                    if ($model->isPupilInThisEvent(Yii::$app->request->get('id')))
//                                        return ["value" => $model->id,  'checked' => 'true', 'event_id' => Yii::$app->request->get('id')];
//                                },
//                                'options' => ['class_id' => $model->id]
//                            ]
//                        ],
//                    ]); ?>
                    <div class="modal-footer">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                        <!--                        --><?php //ActiveForm::end(); ?>
<!--                        --><?php //Pjax::end(); ?>
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