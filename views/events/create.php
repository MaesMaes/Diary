<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = 'Создание события';
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-create">

    <?= $this->render('_form', [
        'model' => $model,
        'subjects' => $subjects,
    ]) ?>

</div>
