<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Incoming */

$this->title = 'Добавить приход';
$this->params['breadcrumbs'][] = ['label' => 'Приходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-create">

    <?= $this->render('_form', [
        'model' => $model,
        'pupils' => $pupils,
        'parents' => $parents,
        'subject' => $subject,
    ]) ?>

</div>
