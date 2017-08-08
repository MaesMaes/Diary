<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Incoming */

$this->title = 'Редактировать приход: ' . $model->incomingID;
$this->params['breadcrumbs'][] = ['label' => 'Приходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->incomingID, 'url' => ['view', 'id' => $model->incomingID]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="incoming-update">

    <?= $this->render('_form', [
        'model' => $model,
        'pupils' => $pupils,
        'parents' => $parents,
        'subject' => $subject,
    ]) ?>

</div>
