<?php

use app\models\Banners;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContractsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Контракты';
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        [
            'label' => 'Сумма контракта',
            'value' => function($model) {
                return $model->contractType->title;
            }
        ],
        [
            'label' => 'Сумма контракта',
            'value' => function($model) {
                return $model->contractType->price . ' руб.';
            }
        ],
        [
            'attribute' => 'client',
            'value' => function($model) {
                return $model->client->name . ' ' . $model->client->lastName;
            }
        ],
        [
            'attribute' => 'child',
            'value' => function($model) {
                return $model->child->name . ' ' . $model->child->lastName;
            }
        ],
        [
            'attribute' => 'datetime',
            'value' => function($model) {
                return date("d-M-Y h:i:s",  strtotime($model->datetime));
            }
        ],
        [
            'attribute' => 'note',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}',
        ],
    ],
]);