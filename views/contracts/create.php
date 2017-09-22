<?php


/* @var $this yii\web\View */
/* @var $model app\models\Contracts */
/* @var $contractTypesSelect array */
/* @var $parentsSelect array */
/* @var $childrenSelect array */

$this->title = 'Создать контракт';
$this->params['breadcrumbs'][] = ['label' => 'Контракты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-create">

    <?= $this->render('_form', [
        'model' => $model,
        'contractTypesSelect' => $contractTypesSelect,
        'parentsSelect' => $parentsSelect,
        'childrenSelect' => $childrenSelect
    ]) ?>

</div>
