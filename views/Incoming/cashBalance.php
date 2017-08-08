<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IncomingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кассовый остаток';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>Текущий кассовый остаток: <?= $balance ?> руб.</p>

</div>
