<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Costs */

$this->title = 'Create Costs';
$this->params['breadcrumbs'][] = ['label' => 'Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
