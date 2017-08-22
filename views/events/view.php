<?php

use app\models\Marks;
use app\models\Subject;
use app\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'place',
            [
                'attribute' => 'subject',
                'value' => function($model) {
                    return Subject::findOne($model->subject)->name;
                }
            ],
            [
                'attribute' => 'date',
//                'value' => Yii::$app->formatter->asDatetime($model->date)
            ],
            [
                'attribute' => 'moderator',
                'value' => function($model) {
                    $model = User::findOne($model->moderator);
                    if (isset($model->name) && isset($model->lastName))
                        return $model->name . ' ' . $model->lastName;

                    return '';
                }
            ],

        ],
    ]) ?>

    <h4>Список участников</h4>
    <? $eventID = $model->id; ?>
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
                        return Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->test ?? '-';
                    },
                ],
            ],
            [
                'header' => 'Срез по итогам темы',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{test-theme-mark}',
                'buttons' => [
                    'test-theme-mark' => function ($url,$model,$key) use ($eventID){
                        return Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->test_theme ?? '-';
                    },
                ],
            ],
            [
                'header' => 'Срез по итогам урока, %',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{test-lesson-mark}',
                'buttons' => [
                    'test-lesson-mark' => function ($url,$model,$key) use ($eventID){
                        return (Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->test_lesson ?? '0');
                    }
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
                        return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'lights-no lights lights-green ' . $lights]);
                    },
                    'lights-yellow' => function ($url,$model,$key) use ($eventID) {
                        $lights = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->lights ?? 0;
                        if ($lights == 2) $lights = 'active'; else $lights = '';
                        return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'lights-no lights lights-yellow ' . $lights]);
                    },
                    'lights-red' => function ($url,$model,$key) use ($eventID) {
                        $lights = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->lights ?? 0;
                        if ($lights == 3) $lights = 'active'; else $lights = '';
                        return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'lights-no lights lights-red ' . $lights]);
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
                        return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'smile-no smile smile-1 ' . $active]);
                    },
                    'smile-2' => function ($url,$model,$key) use ($eventID) {
                        $active = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->active ?? 0;
                        if ($active == 2) $active = 'active'; else $active = '';
                        return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'smile-no smile smile-2 ' . $active]);
                    },
                    'smile-3' => function ($url,$model,$key) use ($eventID) {
                        $active = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->active ?? 0;
                        if ($active == 3) $active = 'active'; else $active = '';
                        return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'smile-no smile smile-3 ' . $active]);
                    },
                    'smile-4' => function ($url,$model,$key) use ($eventID) {
                        $active = Marks::findOne(['eventID' => $eventID, 'pupilID' => $model->id])->active ?? 0;
                        if ($active == 4) $active = 'active'; else $active = '';
                        return Html::a('', '#0', ['data-pupil-id' => $model->id, 'class' => 'smile-no smile smile-4 ' . $active]);
                    },
                ],
            ],
            [
                'header' => 'Замечания',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{notes}',
                'buttons' => [
                    'notes' => function ($url,$model,$key) {
                        return '-';
                    },
                ],
            ],
        ],
    ]); ?>

</div>
