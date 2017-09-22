<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы контрактов';
$this->params['breadcrumbs'][] = $this->title; ?>
    <p>
        <?= Html::a('Добавить тип контракта', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        [
            'attribute' => 'title',
        ],
        [
            'attribute' => 'price',
            'value' => function($model) {
                return $model->price . " руб.";
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
        ],
    ],
]);