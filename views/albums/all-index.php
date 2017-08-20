<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlbumsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотоальбомы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="albums-index">
    <div class="row">
<!--        <pre>--><?// print_r($data); die; ?><!--</pre>-->
        <? foreach ($data as $album) { ?>
            <a class="album-wrap" href="/albums/all-view?id=<?=$album['id'] ?>">
                <div class="album-wrap-img" style="background: url('<?=$album['imagePreview'] ?>') center center; background-size: cover;">
                    <div class="album-wrap-img-title"><?=$album['name'] ?></div>
                </div>
            </a>
        <? } ?>
    </div>
</div>