<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Нормативные документы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-index">
-    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        return Html::a('Посмотреть', Yii::$app->getHomeUrl() . $model->path, ['target' => '_blank']);
                    },
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        return Html::a('Скачать', Yii::$app->getHomeUrl() . $model->path, ['download' => 'download']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
