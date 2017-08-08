<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Costs */

$this->title = 'Редактировать расход: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Расходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->costsID]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="costs-update">

    <?= $this->render('_form', [
        'model' => $model,
        'itemsOfExpenditure' => $itemsOfExpenditure,
        'users' => $users,
    ]) ?>

</div>
