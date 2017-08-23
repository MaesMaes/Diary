<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventNotesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Замечания';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-notes-index">

    <p>
        <?= Html::a('Добавить замечание', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'pupilID',
                'value' => function($model) {
                    $user = User::findOne($model->pupilID);
                    return $user->lastName . ' ' . $user->name;
                }
            ],
            'note:ntext',
            'date',
            [
                'attribute' => 'worked',
                'value' => function($model) {
                    return ($model->worked == 0) ? 'Нет' : 'Да';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
