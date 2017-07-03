<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */

$this->title = 'Добавить класс';
$this->params['breadcrumbs'][] = ['label' => 'Класс', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-class-create">

    <?= $this->render('_form', [
        'model' => $model,
        'dataProviderPupil' => $dataProviderPupil,
    ]) ?>

</div>
