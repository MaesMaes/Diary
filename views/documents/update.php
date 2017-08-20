<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */

$this->title = 'Редактировать документ №: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Нормативные документы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="documents-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
