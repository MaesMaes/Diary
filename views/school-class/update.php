<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */

$this->title = 'Редактировать класс: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Классы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="school-class-update">


    <?= $this->render('_form', [
        'model' => $model,
        'dataProviderPupil' => $dataProviderPupil,
    ]) ?>

</div>
