<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PlacesList */

$this->title = 'Добавить место';
$this->params['breadcrumbs'][] = ['label' => 'Места проведения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="places-list-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
