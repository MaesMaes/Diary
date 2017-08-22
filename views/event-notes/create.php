<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EventNotes */

$this->title = 'Create Event Notes';
$this->params['breadcrumbs'][] = ['label' => 'Event Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-notes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
