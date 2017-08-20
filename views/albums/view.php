<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Albums */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Фотоальбомы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="albums-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы увурены?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'creatorID',
                'value' => function($model) {
                    $user = User::findOne($model->creatorID);
                    return $user->name ?? '' . ' ' . $user->lastName ?? '';
                }
            ],
        ],
    ]) ?>
    <div class="row">
        <?php
        $images = json_decode($model->images);
        if (!empty($images))
            foreach ($images as $img):
                ?>
                <div class="img-block">
                    <div class="img-block-img" style="background: url('<?='/uploads/albums/' . $model->id . '/' . $img?>'); background-size: cover;"></div>
                </div>
                <?php
            endforeach;
        ?>
    </div><br>

</div>
