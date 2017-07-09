<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = 'Редактировать: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="events-update">

    <?= $this->render('_form', [
        'model' => $model,
        'subjects' => $subjects,
        'moderators' => $moderators,
        'dataProviderPupils' => $dataProviderPupils,
        'searchModelPupils' => $searchModelPupils,
        'dataProviderPupilsOnEvent' => $dataProviderPupilsOnEvent,
    ]) ?>

</div>
