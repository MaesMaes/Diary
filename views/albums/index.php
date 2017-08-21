<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlbumsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотоальбомы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="albums-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить альбом', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Все альбомы', ['all-index'], ['class' => 'btn btn-warning']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'creatorID',
                'value' => function($model) {
                    $user = User::findOne($model->creatorID);
                    return $user->name ?? '' . ' ' . $user->lastName ?? '';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
