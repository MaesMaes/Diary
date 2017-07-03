<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'name',
//        'pageSummary' => 'Page Total',
        'vAlign'=>'middle',
//        'headerOptions'=>['class'=>'kv-sticky-column'],
//        'contentOptions'=>['class'=>'kv-sticky-column'],
//        'editableOptions'=>['header'=>'Name', 'size'=>'md']
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'lastName',
//        'pageSummary' => 'Page Total',
        'vAlign'=>'middle',
//        'headerOptions'=>['class'=>'kv-sticky-column'],
//        'contentOptions'=>['class'=>'kv-sticky-column'],
//        'editableOptions'=>['header'=>'Name', 'size'=>'md']
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'birthDate',
        'format' => ['date', 'php:d.m.Y'],
//        'pageSummary' => 'Page Total',
        'vAlign'=>'middle',
//        'headerOptions'=>['class'=>'kv-sticky-column'],
//        'contentOptions'=>['class'=>'kv-sticky-column'],
//        'editableOptions'=>['header'=>'Name', 'size'=>'md']
    ],
//    [
//        'attribute'=>'color',
//        'value'=>function ($model, $key, $index, $widget) {
//            return "<span class='badge' style='background-color: {$model->color}'> </span>  <code>" .
//            $model->color . '</code>';
//        },
//        'filterType'=>GridView::FILTER_COLOR,
//        'vAlign'=>'middle',
//        'format'=>'raw',
//        'width'=>'150px',
//        'noWrap'=>true
//    ],
//    [
//        'class'=>'kartik\grid\BooleanColumn',
//        'attribute'=>'lastName',
//        'vAlign'=>'middle',
//    ],
    [
        'class'=>'kartik\grid\CheckboxColumn',
//        'attribute'=>'school_class_id',
        'vAlign'=>'middle',
        'header' => 'В классе',
        'rowSelectedClass' => GridView::TYPE_SUCCESS,
        'checkboxOptions' => function($model) {
            if (isset($model->class->id) && $model->class->id == Yii::$app->request->get('id'))
                return ["value" => $model->id,  'checked' => 'true', 'school_class_id' => $model->class->id];
        },
        'options' => ['class_id' => $model->id]
    ],
//    [
//        'class' => 'kartik\grid\ActionColumn',
//        'dropdown' => true,
//        'vAlign'=>'middle',
//        'urlCreator' => function($action, $model, $key, $index) { return '#'; },
//        'viewOptions'=>['title'=>'Посмотреть', 'data-toggle'=>'tooltip'],
//        'updateOptions'=>['title'=>'Обновить', 'data-toggle'=>'tooltip'],
//        'deleteOptions'=>['title'=>'Удалить', 'data-toggle'=>'tooltip'],
//    ],
//    ['class' => 'kartik\grid\CheckboxColumn']
];
?>

<div class="school-class-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= Html::dropDownList('pupils', $selectedPupils, $pupils, ['class' => 'form-control', 'multiple' => true]) ?><!--<Br/>-->
    <h4>Список учеников</h4>
<?= \kartik\grid\GridView::widget([
    'dataProvider' => $dataProviderPupil,
//    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
//    'beforeHeader'=>[
//        [
//            'columns'=>[
//                ['content'=>'Header Before 1', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
//                ['content'=>'Header Before 2', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
//                ['content'=>'Header Before 3', 'options'=>['colspan'=>3, 'class'=>'text-center warning']],
//            ],
//            'options'=>['class'=>'skip-export'] // remove this row from export
//        ]
//    ],
//    'toolbar' =>  [
//        ['content'=>
//            Html::button('&lt;i class="glyphicon glyphicon-plus">&lt;/i>', ['type'=>'button', 'title'=>Yii::t('kvgrid', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
//            Html::a('&lt;i class="glyphicon glyphicon-repeat">&lt;/i>', ['grid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>Yii::t('kvgrid', 'Reset Grid')])
//        ],
//        '{export}',
//        '{toggleData}'
//    ],
    'pjax' => true,
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'responsive' => true,
    'hover' => true,
//    'floatHeader' => true,
//    'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
//    'showPageSummary' => true,
//    'panel' => [
//        'type' => GridView::TYPE_INFO
//    ],
]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php  $this->registerJsFile('/js/view-school_class.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
