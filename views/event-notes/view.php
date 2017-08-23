<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EventNotes */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Замечания', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-notes-view">

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
            [
                'attribute' => 'pupilID',
                'value' => function($model) {
                    $user = User::findOne($model->pupilID);
                    return $user->lastName . ' ' . $user->name;
                }
            ],
            'note:ntext',
            'date',
            [
                'attribute' => 'worked',
                'value' => function($model) {
                    return ($model->worked == 0) ? 'Нет' : 'Да';
                }
            ],
        ],
    ]) ?>

</div>
