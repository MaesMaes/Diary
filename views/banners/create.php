<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Banners */

$this->title = 'Создать баннер';
$this->params['breadcrumbs'][] = ['label' => 'Баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-create">

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'places' => $places,
    ]) ?>

</div>
