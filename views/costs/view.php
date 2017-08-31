<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Costs */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Расходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costs-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->costsID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->costsID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
                    return number_format($model->sum, 0, '', ' ') . ' руб.';
                }
            ],
            'description',
        ],
    ]) ?>

</div>
