<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Subject */

$this->title = 'Добавить предмет';
$this->params['breadcrumbs'][] = ['label' => 'Предметы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
