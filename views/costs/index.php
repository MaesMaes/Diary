<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Расходы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costs-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'costsID',
            'date',
            [
                'attribute' => 'itemOfExpenditure',
                'value' => function($model) {
                    return \app\models\Costs::getAllItemOfExpenditure()[$model->itemOfExpenditure];
                }
            ],
            [
                'attribute' => 'name',
                'value' => function($model) {
                    $model = User::findOne($model->name);
                    if ($model) return $model->name . ' ' . $model->lastName;
                    else return '';
                }
            ],
            [
                'attribute' => 'sum',
                'value' => function($model) {
                    return number_format($model->sum, 0, '', ' ');
                }
            ],
            // 'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
