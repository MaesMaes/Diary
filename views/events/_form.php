<?php

use app\models\Marks;
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

    <?php $form = ActiveForm::begin(); ?> <br>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->dropDownList($model->eventTypes); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?><br/>
        </div>
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
    <? if (!$model->isNewRecord) {
        $eventID = $model->id;
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProviderPupilsOnEvent,
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
                        'test-mark' => function ($url, $model, $key) use ($eventID) {
                            return Html::dropDownList(
                                'list',
                                Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->test ?? 0,
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
                        'test-theme-mark' => function ($url,$model,$key) use ($eventID){
                            return Html::dropDownList(
                                'list',
                                Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->test_theme ?? 0,
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
                        'test-lesson-mark' => function ($url,$model,$key) use ($eventID){
                            return Html::input('string', 'test__lesson__mark',
                                   Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->test_lesson ?? 0,
                                   ['data-pupil-id' => $model->id, 'class' => 'js-set-test__lesson__mark test__lesson__mark'])
                                 . Html::tag('span', '%', ['class' => 'test__lesson__percent']);
                        },
                    ],
                ],
                [
                    'header' => 'Светофор',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{lights-green}{lights-yellow}{lights-red}',
                    'buttons' => [
                        'lights-green' => function ($url,$model,$key) use ($eventID) {
                            $lights = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->lights ?? 0;
                            if ($lights == 1) $lights = 'active'; else $lights = '';
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-lights lights lights-green ' . $lights]);
                        },
                        'lights-yellow' => function ($url,$model,$key) use ($eventID) {
                            $lights = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->lights ?? 0;
                            if ($lights == 2) $lights = 'active'; else $lights = '';
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-lights lights lights-yellow ' . $lights]);
                        },
                        'lights-red' => function ($url,$model,$key) use ($eventID) {
                            $lights = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->lights ?? 0;
                            if ($lights == 3) $lights = 'active'; else $lights = '';
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-lights lights lights-red ' . $lights]);
                        },
                    ],
                ],
                [
                    'header' => 'Активность на уроке',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{smile-1}{smile-2}{smile-3}{smile-4}',
                    'buttons' => [
                        'smile-1' => function ($url,$model,$key) use ($eventID){
                            $active = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->active ?? 0;
                            if ($active == 1) $active = 'active'; else $active = '';
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-smile smile smile-1 ' . $active]);
                        },
                        'smile-2' => function ($url,$model,$key) use ($eventID) {
                            $active = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->active ?? 0;
                            if ($active == 2) $active = 'active'; else $active = '';
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-smile smile smile-2 ' . $active]);
                        },
                        'smile-3' => function ($url,$model,$key) use ($eventID) {
                            $active = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->active ?? 0;
                            if ($active == 3) $active = 'active'; else $active = '';
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-smile smile smile-3 ' . $active]);
                        },
                        'smile-4' => function ($url,$model,$key) use ($eventID) {
                            $active = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->active ?? 0;
                            if ($active == 4) $active = 'active'; else $active = '';
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-smile smile smile-4 ' . $active]);
                        },
                    ],
                ],
                [
                    'header' => 'Замечания',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{notes}',
                    'buttons' => [
                        'notes' => function ($url,$model,$key) {
                            return Html::a('Добавить замечание', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-notes event-notes']);
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
                    <div class="modal-footer">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>

<script>
    $(function() {

        //Контрольная работа
        $('.js-set-test__mark').on('change', function (e) {
            var pupilID = $(this).attr('data-pupil-id');
            var value = $(this).val();
            var that = $(this);
            $.ajax({
                url: '/marks/test-mark',
                method: 'POST',
                data: {
                    pupilID: pupilID,
                    value: value,
                    type: 'test'
                },
                success: function() {
                }
            });
        });

        //Срез по итогам темы
        $('.js-set-test__theme__mark').on('change', function (e) {
            var pupilID = $(this).attr('data-pupil-id');
            var value = $(this).val();
            var that = $(this);
            $.ajax({
                url: '/marks/test-mark',
                method: 'POST',
                data: {
                    pupilID: pupilID,
                    value: value,
                    type: 'test_theme'
                },
                success: function() {
                }
            });
        });

        //Срез по итогам урока
        $('.js-set-test__lesson__mark').on('change', function (e) {
            var pupilID = $(this).attr('data-pupil-id');
            var value = $(this).val();
            var that = $(this);
            $.ajax({
                url: '/marks/test-mark',
                method: 'POST',
                data: {
                    pupilID: pupilID,
                    value: value,
                    type: 'test_lesson'
                },
                success: function() {
                }
            });
        });

        //Светофор
        $('.js-set-lights').on('click', function (e) {
            var pupilID = $(this).attr('data-pupil-id');
            var value = 0;
            if ($(this).hasClass('lights-green')) value = 1;
            if ($(this).hasClass('lights-yellow')) value = 2;
            if ($(this).hasClass('lights-red')) value = 3;
            var that = $(this);
            $.ajax({
                url: '/marks/test-mark',
                method: 'POST',
                data: {
                    pupilID: pupilID,
                    value: value,
                    type: 'lights'
                },
                success: function() {
//                    $('.js-set-lights').removeClass('active');
                    that.siblings().removeClass('active');
                    that.addClass('active');
                }
            });
        });

        //Активность на урок
        $('.js-set-smile').on('click', function (e) {
            var pupilID = $(this).attr('data-pupil-id');
            var value = 0;
            if ($(this).hasClass('smile-1')) value = 1;
            if ($(this).hasClass('smile-2')) value = 2;
            if ($(this).hasClass('smile-3')) value = 3;
            if ($(this).hasClass('smile-4')) value = 4;
            var that = $(this);
            $.ajax({
                url: '/marks/test-mark',
                method: 'POST',
                data: {
                    pupilID: pupilID,
                    value: value,
                    type: 'active'
                },
                success: function() {
//                    $('.js-set-smile').removeClass('active');
                    that.siblings().removeClass('active');
                    that.addClass('active');
                }
            });
        });
    });
</script>