<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Costs */

$this->title = 'Update Costs: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->costsID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="costs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
