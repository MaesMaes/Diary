<?php

use app\models\Events;
use app\models\Subject;
use app\models\User;
use edofre\fullcalendar\models\Event;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить событие', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="panel panel-content">
        <div class="panel-heading">
            Классический список событий
            <button type="button" class="btn btn-primary btn-xs spoiler-trigger pull-right" data-toggle="collapse"><span class="glyphicon glyphicon-chevron-down"></span></button>
        </div>
        <div class="panel-collapse collapse out">
            <div class="panel-body">
                <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'event_title',
                        [
                            'attribute' => 'name',
                            'filter' => Events::$eventTypesS,
                        ],
                        [
                            'attribute' => 'subject',
                            'filter' => ArrayHelper::map(Subject::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
                            'value' => function($model) {
                                return Subject::findOne($model->subject)->name;
                            }
                        ],
                        [
                            'attribute' => 'date',
                            'filter' => DateTimePicker::widget([
                                'model'=>$searchModel,
                                'attribute'=>'date',
                                'language' => 'ru',
                            ]),
                            'value' => function($model) {
                                return Yii::$app->formatter->asDatetime($model->date);
                            }
                        ],
                        [
                            'attribute' => 'moderator',
                            'value' => function($model) {
                                $model = User::findOne($model->moderator);
                                return $model->name . ' ' . $model->lastName;
                            },
//                            'filter' => User::getAllModerators()
                        ],

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
    <?= edofre\fullcalendar\Fullcalendar::widget([
        'options'       => [
            'id'       => 'calendar',
            'language' => 'ru',
        ],
        'clientOptions' => [
            'weekNumbers' => true,
            'selectable'  => true,
            'defaultView' => 'agendaWeek',
            'viewRender' => new JsExpression("
                function (view, element) {                
                    var b = $('#calendar').fullCalendar('getDate');
                    $.ajax({
                        url: '/events/get-events-on-current-date',
                        method: 'POST',
                        data: {
                            currentDate: b.format('YYYY-MM-DD'),
                            year: b.format('YYYY'),
                            month: b.format('MM'),
                        },
                        success: function(events) {
                            console.log(events);
                            $('#calendar').fullCalendar('removeEvents');
                            $('#calendar').fullCalendar('addEventSource', JSON.parse(events));         
                            $('#calendar').fullCalendar('rerenderEvents');
                        }
                    });
                 }
            "),
        ],
//        'events' => $events,
        'events' => [],
    ]);
    ?>
</div>

<script>
    $(function() {
        $(".spoiler-trigger").click(function() {
            $(this).parent().next().collapse('toggle');
        });
        $('body').on( 'click', '.fc-event', function(e){
            e.preventDefault();
            window.open( $(this).attr('href'), '_blank' );
        });

//        $.ajax({
//            url: '/event/get-events-on-current-date',
//            method: 'POST',
//            data: {
//                currentDate: currentDate
//            },
//            success: function(data) {
//                console.log(data);
//            }
//        });
    });
</script>
