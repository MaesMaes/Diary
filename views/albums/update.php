<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Albums */

$this->title = 'Редактировать альбом: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Фотоальбомы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="albums-update">

    <?= $this->render('_form', [
        'model' => $model,
        'images' => $images,
    ]) ?>

</div>
