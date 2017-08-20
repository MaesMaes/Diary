<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Documents */

$this->title = 'Добавить документ';
$this->params['breadcrumbs'][] = ['label' => 'Нормативные документы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
