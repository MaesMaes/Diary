<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EventNotes */

$this->title = 'Редактировать: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Замечания', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="event-notes-update">

    <?= $this->render('_form', [
        'model' => $model,
        'pupils' => $pupils
    ]) ?>

</div>
