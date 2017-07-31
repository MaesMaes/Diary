<?php

use app\models\Banners;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BannersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Баннеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить баннер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'URLs:url',
            'roleIDs',
            [
                'attribute' => 'place',
                'value' => function($model) {
                    return Banners::PLACES[$model->place];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ],
        ],
    ]); ?>
</div>
