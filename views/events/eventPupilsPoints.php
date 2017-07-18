<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = 'Оценка участников';
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Оценить участников';
?>
<div class="events-view">

    <?php $form = ActiveForm::begin(); ?> <br>

    <?= GridView::widget([
        'dataProvider' => $dataProviderPupilsOnEvent,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'name'],
            ['attribute' => 'lastName'],
            [
                'attribute' => 'birthDate',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->birthDate);
                }
            ],
            ['attribute' => 'className'],
            [
                'class'=>'kartik\grid\EditableColumn',
                'attribute' => 'point',
            ],
        ],
    ]); ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success js-send-pupils__list', 'data' => ['id' => $model->id]]) ?>

    <?php ActiveForm::end(); ?>

</div>
