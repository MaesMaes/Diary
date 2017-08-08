<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Incoming */

$this->title = 'Update Incoming: ' . $model->incomingID;
$this->params['breadcrumbs'][] = ['label' => 'Incomings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->incomingID, 'url' => ['view', 'id' => $model->incomingID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="incoming-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
