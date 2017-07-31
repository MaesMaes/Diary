<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['options']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="options-index">

    <?=$this->render('/banners/index', [
        'dataProvider' => $dataProviderBanners,
        'searchModel' => $searchModelBanners,
    ]); ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>-->
<!--        --><?//= Html::a('Create Options', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->
<!--    --><?//= GridView::widget([
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
//            'prop',
//            'value',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]); ?>
</div>
