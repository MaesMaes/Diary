<?php

use app\models\Banners;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Banners */

$this->title = 'Баннер ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'URLs',
                'value' => function($model) {
                    $urls = json_decode($model->URLs);
                    $html = '';
                    foreach ($urls as $url) {
                        $html .= '<img src="/tmp/banners/' . $url . '" height="150"/>';
                    }

                    return $html;
                }
            ],
        ],
    ]) ?>

</div>
