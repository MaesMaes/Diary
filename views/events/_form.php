<?php

use app\models\Marks;
use app\models\PlacesList;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
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
<!--            --><?//= $form->field($model, 'place')->dropDownList(ArrayHelper::map(PlacesList::find()->all(), 'id', 'name'), ['prompt'=>'Не указано']) ?><!--<br/>-->
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
        <div class="col-md-3">
            <?= $form->field($model, 'theme')->textInput(['maxlength' => true])?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'standard')->textInput(['maxlength' => true])?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'deep')->textInput(['maxlength' => true])?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'task1')->textInput(['maxlength' => true])?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'task2')->textInput(['maxlength' => true])?>
        </div>
    </div>

    <h4>Список участников</h4>
    <? if (!$model->isNewRecord) {
        $eventID = $model->id;
        ?>
        <div class="pupils__list-table">
        <?= GridView::widget([
            'dataProvider' => $dataProviderPupilsOnEvent,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'lastName'],
                ['attribute' => 'name'],
                ['attribute' => 'className'],
                [
                    'header' => 'Активность на уроке',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{smile-5}{smile-1}{smile-2}{smile-4}{smile-6}',
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
                        'smile-5' => function ($url,$model,$key) use ($eventID) {
                            $active = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->active ?? 0;
                            if ($active == 5) $active = 'active'; else $active = '';
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-smile smile smile-5 ' . $active]);
                        },
                        'smile-6' => function ($url,$model,$key) use ($eventID) {
                            $active = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->active ?? 0;
                            if ($active == 6) $active = 'active'; else $active = '';
                            return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-set-smile smile smile-6 ' . $active]);
                        },
                    ],
                ],
                [
                    'header' => 'Срез урока, %',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{test-lesson-mark}',
                    'buttons' => [
                        'test-lesson-mark' => function ($url,$model,$key) use ($eventID){
                            return Html::dropDownList(
                                'list',
                                Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->test_lesson ?? 0,
                                [0 => 0, 20 => 20, 40 => 40, 60 => 60, 80 => 80, 100 => 100],
                                ['data-pupil-id' => $model->id, 'class' => 'js-set-test__lesson__mark']
                            );
//                            return Html::input('string', 'test__lesson__mark',
//                                Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->test_lesson ?? 0,
//                                ['data-pupil-id' => $model->id, 'class' => 'js-set-test__lesson__mark test__lesson__mark']);
                        },
                    ],
                ],
                [
                    'header' => 'Контрольная работа по теме',
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
//                [
//                    'header' => 'Замечания',
//                    'class' => 'yii\grid\ActionColumn',
//                    'template' => '{notes}',
//                    'buttons' => [
//                        'notes' => function ($url,$model,$key) {
//                            return Html::a('Добавить замечание', '#myModal', ['data-toggle' => "modal", 'data-pupil-id' => $model->id, 'class' => 'js-set-notes event-notes']);
//                        },
//                    ],
//                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
//                    'urlCreator' => function ($action, $model, $key, $index) {
//                        if ( $action === 'delete' ) {
//                            return Html::a('', '/events/delete-pupil-from-event?event-id=' . $model->id, [
//                                'data-method'  => 'post',
//                            ]);
//                        }
//                    },
                    'buttons'  => [
                        'delete' => function ($url, $pupilModel) use ($model){
//                            $url = Url::to(['',  ['pupilID' => $pupilModel->id, 'eventID' => $model->id]]);
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'data' => ['pupil-id' => $pupilModel->id, 'event-id' => $model->id],
                                'class' => 'js-delete__pupil__on__event'
                            ]);
                        },
                    ]
                ],
            ],
        ]); ?>
        </div>
    <? } else { ?>
        <p>Для добавлянения участников сначало создайте событие</p>
    <? } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <? if (!$model->isNewRecord) { ?>
            <?= Html::a('Добавить классы', '#myModalAddPupils', ['class' => 'btn btn-default', 'data-toggle' => "modal"]) ?>
<!--            --><?//= Html::a('Добавить учеников', ['/events/pupils-list', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            <?= Html::a('Проведено', ['create-mini-group', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены?',
                    'method' => 'post',
                ],
            ]) ?>
<!--            --><?//= Html::a('Оценить участников', ['event-pupils-points', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <? } ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<? if (!$model->isNewRecord) { ?>
    <div id="myModalAddPupils" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Добавить участников</h4>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="notes-container">
                    <h3>Классы</h3>
                    <p>Добавьте из списка 1 или несколько классов.</p>
                    <?= Select2::widget([
                        'name' => 'members',
                        'data' => $schoolClasses,
                        'options' => [
                            'placeholder' => 'Классы',
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="modal-body">
                    <div class="modal-footer">
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success js-add__members', 'data-event-id' => $model->id]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>

<script>
    $(function() {

        //Переключает набор оценок для каждого типа осбытия
        function turnMarks(type) {
            var head = $('th');
            $('th, td').removeClass('hidden');
            switch (type) {
                case 'Урок':
                    head.eq(8).addClass('hidden');
                    $('td:nth-child(9)').addClass('hidden');
                    break;
                case 'Самостоятельная работа':
                        head.eq(7).addClass('hidden');
                        $('td:nth-child(8)').addClass('hidden');
                        head.eq(6).addClass('hidden');
                        $('td:nth-child(7)').addClass('hidden');
                        head.eq(5).addClass('hidden');
                        $('td:nth-child(6)').addClass('hidden');
                        head.eq(4).addClass('hidden');
                        $('td:nth-child(5)').addClass('hidden');
                    break;
                case 'Секция':
                        head.eq(8).addClass('hidden');
                        $('td:nth-child(9)').addClass('hidden');
                        head.eq(7).addClass('hidden');
                        $('td:nth-child(8)').addClass('hidden');
                        head.eq(6).addClass('hidden');
                        $('td:nth-child(7)').addClass('hidden');
                        head.eq(5).addClass('hidden');
                        $('td:nth-child(6)').addClass('hidden');
                    break;
                case 'Модуль':

                    break;
                case 'Урок основной':
                    head.eq(8).addClass('hidden');
                    $('td:nth-child(9)').addClass('hidden');
                    break;
                case 'Минигруппа':
                        head.eq(7).addClass('hidden');
                        $('td:nth-child(8)').addClass('hidden');
                        head.eq(6).addClass('hidden');
                        $('td:nth-child(7)').addClass('hidden');
                        head.eq(5).addClass('hidden');
                        $('td:nth-child(6)').addClass('hidden');
                        head.eq(4).addClass('hidden');
                        $('td:nth-child(5)').addClass('hidden');
                    break;
                default:
            }
        }

        //Hide fields
        function hideFields(type) {
            var s = $('input[name="Events[standard]"]').parent().parent();
            var d = $('input[name="Events[deep]"]').parent().parent();
            var t = $('input[name="Events[theme]"]').parent().parent();
            s.addClass('hidden');
            d.addClass('hidden');
            t.addClass('hidden');

            if (type == 'Урок') {
                t.removeClass('hidden');
            }
            if (type == 'Урок основной') {
                t.removeClass('hidden');
            }
            if (type == 'Самостоятельная работа') {
                s.removeClass('hidden');
                d.removeClass('hidden');
            }
        }

        $('select[name="Events[name]"]').on('change', function() {
            hideFields($(this).val());
            turnMarks($(this).val());
        });

        hideFields($('select[name="Events[name]"]').val());
        turnMarks($('select[name="Events[name]"]').val());

        function reloadNotesList(pupilID) {
            $.ajax({
                url: '/event-notes/get-pupil-notes',
                method: 'POST',
                data: {
                    pupilID: pupilID
                },
                success: function(data) {
                    console.log(data);
                    if (data != 'no-notes') {
                        var html = '';
                        $.each(data, function(index, value) {
                            html += '<p class="note-item">' + value.note + '</p>';
                        });
                        $('.js-notes__container').html(html);
                    } else {
                        $('.js-notes__container').html('Замечаний нет');
                    }
                }
            });
        }

        //Замечания
        $('.js-set-notes').on('click', function() {
            var pupilID = $(this).attr('data-pupil-id');
            reloadNotesList(pupilID);
        });

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

        //Удаление ученика из списка
        $('.js-delete__pupil__on__event').on('click', function (e) {
            e.preventDefault();
            var pupilID = $(this).attr('data-pupil-id');
            var eventID = $(this).attr('data-event-id');
            $.ajax({
                url: '/events/delete-pupil-from-event',
                method: 'POST',
                data: {
                    pupilID: pupilID,
                    eventID: eventID
                },
                success: function() {
                }
            });
        });

        //Добавить участников
        $('.js-add__members').on('click', function (e) {
            var members = $('#w5').val();
            var eventID = $(this).attr('data-event-id');
            $.ajax({
                url: '/events/add-school-classes-to-event?id=' + eventID,
                method: 'POST',
                data: {
                    members: members
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
            if ($(this).hasClass('smile-5')) value = 5;
            if ($(this).hasClass('smile-6')) value = 6;
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
                    that.siblings().removeClass('active');
                    that.addClass('active');
                }
            });
        });
    });
</script>