<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContractsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Контракты';
$this->params['breadcrumbs'][] = $this->title; ?>
<p>
    <?= Html::a('Добавить контракт', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        [
            'label' => 'Тип контракта',
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
                return date("d.m.Y h:i:s",  strtotime($model->datetime));
            }
        ],
        [
            'attribute' => 'note',
        ],
        [
            'attribute' => 'is_stopped',
            'format' => 'boolean',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}',
        ],
    ],
]);