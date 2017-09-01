<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EventNotes */

$this->title = 'Добавить замечания';
$this->params['breadcrumbs'][] = ['label' => 'Замечания', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-notes-create">

    <?= $this->render('_form', [
        'model' => $model,
        'pupils' => $pupils,
        'dataProviderUsers' => $dataProviderUsers,
        'searchModelUsers' => $searchModelUsers,
    ]) ?>

</div>
