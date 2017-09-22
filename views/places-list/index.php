<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlacesListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Места проведения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="places-list-index">
    <p>
        <?= Html::a('Добавить место', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
