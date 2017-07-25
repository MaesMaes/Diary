<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = 'Оценка участников';
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['events/update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Оценить участников';
?>
<div class="events-view">

<!--    --><?php //$form = ActiveForm::begin(); ?><!-- <br>-->
    <?php
        $eventId = $model->id;
    ?>
    <?= \kartik\dynagrid\DynaGrid::widget([
        'gridOptions' => [
            'dataProvider' => $dataProviderPupilsOnEvent,
            'pjax' => true,
            'responsive' => true,
            'hover' => true,
            'resizableColumns' => true,
            'showPageSummary'=>false,

        ],
        'theme'=>'panel-info',
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
        'options' => ['id' => 'user']
    ]); ?>

<!--    --><?//= Html::submitButton('Сохранить', ['class' => 'btn btn-success js-send-pupils__list', 'data' => ['id' => $model->id]]) ?>

<!--    --><?php //ActiveForm::end(); ?>

</div>
