<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'lastName',
            'name',
            'birthDate',
            'email:email',
            'password',
            [
                'attribute' => 'photo',
                'visible' => (isset($model->photo)) ? true : false
            ],
            [
                'attribute' => 'phone',
                'visible' => (isset($model->phone)) ? true : false
            ],
            [
                'attribute' => 'className',
//                'visible' => (isset($model->phone)) ? true : false
            ],
            [
                'attribute' => 'classManagement',
                'value' => function($model) {
                    return \app\models\SchoolClass::findOne($model->classManagement)->name;
                },
                'visible' => (isset($model->classManagement)) ? true : false
            ],
            [
                'attribute' => 'parent',
                'value' => function($model) {
                    return \app\models\User::findOne($model->parent)->name . ' ' . \app\models\User::findOne($model->parent)->lastName;
                },
                'visible' => (isset($model->parent)) ? true : false
            ],
            [
                'label' => 'Роль',
                'value' => $role
            ],
            [
                'label' => 'Суприки',
                'value' => $suprik
            ]
        ],
    ]) ?>

</div>
