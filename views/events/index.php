<?php

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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить событие', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
