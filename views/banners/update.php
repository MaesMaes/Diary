<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banners */

$this->title = 'Редактирование баннера: ID (' . $model->id . ')';
$this->params['breadcrumbs'][] = ['label' => 'Баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="banners-update">
    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'places' => $places,
    ]) ?>

</div>
