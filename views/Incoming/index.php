<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IncomingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Приходы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить приход', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'showFooter' => true,
        'columns' => [
//            'incomingID',
            [
                'attribute' => 'childName',
                'value' => function($model) {
                    $model = User::findOne($model->childName);
                    return $model->name . ' ' . $model->lastName;
                },
                'footer'=> '<b>Итого:</b>',
            ],
            [
                'attribute' => 'subject',
                'value' => function($model) {
                    return \app\models\Incoming::getAllSubjects()[$model->subject];
                }
            ],
            [
                'attribute' => 'sum',
            ],
            [
                'attribute' => 'checkingAccount',
                'value' => function($model) {
                    return ($model->checkingAccount == 1) ? 'На расчетный счет' : 'В кассу';
                }
            ],
            [
                'attribute' => 'date',
                'value' => function($model) {
                    return (null !== Yii::$app->formatter->asDatetime($model->date)) ? Yii::$app->formatter->asDatetime($model->date) : '';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
