<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Costs */

$this->title = 'Добавить расходы';
$this->params['breadcrumbs'][] = ['label' => 'Расходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costs-create">

    <?= $this->render('_form', [
        'model' => $model,
        'itemsOfExpenditure' => $itemsOfExpenditure,
        'users' => $users,
    ]) ?>

</div>
