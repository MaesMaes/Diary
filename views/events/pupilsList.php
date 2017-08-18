<?php

use app\models\SchoolClass;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = 'Добавить участников';
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Добавить участников';
?>
<div class="events-view">
<!--    --><?php //Pjax::begin([
////        'clientOptions' => [
////            'push' => false
////        ],
//    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProviderPupils,
        'filterModel' => $searchModelPupils,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'lastName'],
            ['attribute' => 'name'],
            [
                'attribute' => 'birthDate',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->birthDate);
                }
            ],
            [
                'attribute' => 'className',
                'filter' => ArrayHelper::map(SchoolClass::find()->asArray()->all(), 'name', 'name'),
                'options' => ['4A' => ['selected' => true]],
            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'vAlign'=>'middle',
                'rowSelectedClass' => GridView::TYPE_SUCCESS,
                'checkboxOptions' => function($model) {
//                    if ($model->isPupilInThisEvent(Yii::$app->request->get('id')))
//                        return ["value" => $model->id,  'checked' => 'true', 'event_id' => Yii::$app->request->get('id')];
                },
                'options' => ['class_id' => $model->id]
            ]
        ],
    ]); ?>

    <?= Html::a('Добавить участников', null, ['class' => 'btn btn-success js-send-pupils__list', 'data' => ['id' => $model->id]]) ?>

<!--    --><?php //Pjax::end(); ?>

</div>

<script>
    $(function() {
        $('.js-send-pupils__list').on('click', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: '/events/pupils-list?id=' + id,
                method: 'POST',
                data: {
                    pupilsId: function() {
                        var pupilsIds = [];
                        $('input[name="selection[]"]').each(function() {
                            if ($(this).prop('checked') === true)
                                pupilsIds.push($(this).val());
                        });

                        return pupilsIds;
                    }
                },
                success: function(data) {
                    console.log(data);
                }
            });
        });
    });
</script>
