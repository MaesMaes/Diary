<?php

use app\models\Subject;
use app\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
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
//            'id',
            'name',
            'place',
            [
                'attribute' => 'subject',
                'value' => function($model) {
                    return Subject::findOne($model->subject)->name;
                }
            ],
            [
                'attribute' => 'date',
//                'value' => Yii::$app->formatter->asDatetime($model->date)
            ],
            [
                'attribute' => 'moderator',
                'value' => function($model) {
                    $model = User::findOne($model->moderator);
                    if (isset($model->name) && isset($model->lastName))
                        return $model->name . ' ' . $model->lastName;

                    return '';
                }
            ],

        ],
    ]) ?>

    <h4>Список участников</h4>
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
//            ['attribute' => 'point'],
        ],
    ]); ?>

</div>
