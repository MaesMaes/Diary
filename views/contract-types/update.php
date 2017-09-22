<?php


/* @var $this yii\web\View */
/* @var $model app\models\Contracts */

$this->title = 'Изменить тип контракта';
$this->params['breadcrumbs'][] = ['label' => 'Типы контрактов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
