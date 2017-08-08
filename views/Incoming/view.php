<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Incoming */

$this->title = 'Приход №' . $model->incomingID;
$this->params['breadcrumbs'][] = ['label' => 'Приходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->incomingID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->incomingID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
        <? if ($model->checkingAccount == 0): ?>
            <?= Html::a('Скачать ПКО', ['test-excel', 'id' => $model->incomingID], ['class' => 'btn btn-warning']) ?>
        <? endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'incomingID',
            [
                'attribute' => 'childName',
                'value' => function($model) {
                    $model = User::findOne($model->childName);
                    return $model->name . ' ' . $model->lastName;
                }
            ],
            [
                'attribute' => 'subject',
                'value' => function($model) {
                    return \app\models\Incoming::getAllSubjects()[$model->subject];
                }
            ],
            'sum',
            'description',
            [
                'attribute' => 'parentName',
                'value' => function($model) {
                    $model = User::findOne($model->parentName);
                    if ($model) return $model->name . ' ' . $model->lastName;
                    else return '';
                }
            ],
            [
                'attribute' => 'checkingAccount',
                'value' => function($model) {
                    return ($model->checkingAccount == 1) ? 'На расчетный счет' : 'В кассу';
                }
            ],
            'date',
        ],
    ]) ?>

</div>