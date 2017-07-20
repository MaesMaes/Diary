<?php
// Отображение расписания события где ученик является участником, список оценок по событиям

use app\models\Events;
use app\models\Subject;
use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
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
                    return Yii::$app->formatter->asDate($model->date);
                }
            ],
            [
                'attribute' => 'moderator',
                'value' => function($model) {
                    $model = User::findOne($model->moderator);
                    return $model->name . ' ' . $model->lastName;
                }
            ],
            [
                'label' => 'Оценка',
                'value' => function($model) {
                    return Events::getCurrentPupilPoint($model->id);
                }
            ]

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
