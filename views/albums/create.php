<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Albums */

$this->title = 'Добавить альбом';
$this->params['breadcrumbs'][] = ['label' => 'Фотоальбомы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="albums-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
