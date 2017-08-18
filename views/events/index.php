<?php

use app\models\Subject;
use app\models\User;
use edofre\fullcalendar\models\Event;
use yii\helpers\Html;
use yii\grid\GridView;

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
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

//            'id',
                        'name',
                        [
                            'attribute' => 'subject',
                            'value' => function($model) {
                                return Subject::findOne($model->subject)->name;
                            }
                        ],
                        [
                            'attribute' => 'date',
                            'value' => function($model) {
                                return Yii::$app->formatter->asDatetime($model->date);
                            }
                        ],
                        [
                            'attribute' => 'moderator',
                            'value' => function($model) {
                                $model = User::findOne($model->moderator);
                                return $model->name . ' ' . $model->lastName;
                            }
                        ],

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
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
            'defaultView' => 'agendaDay',
        ],
        'events' => $events
    ]);
    ?>
</div>

<script>
    $(function() {
        $(".spoiler-trigger").click(function() {
            $(this).parent().next().collapse('toggle');
        });
    });
</script>
