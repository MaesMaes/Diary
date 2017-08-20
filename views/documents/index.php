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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить документ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'category',
            'name',
            'path',
//            [
//                'label' => 'Просмотр',
//                'value' => function($model) {
//                    return Html::a('Открыть', $model->path, ['target' => '_blank']);
//                }
//            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        return Html::a('Открыть', Yii::$app->getHomeUrl() . $model->path, ['target' => '_blank']);
                    },
                ],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
