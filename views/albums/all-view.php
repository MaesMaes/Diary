<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Albums */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Фотоальбомы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="albums-view">
    <div class="row">
        <?php
        $images = json_decode($model->images);
        if (!empty($images))
            foreach ($images as $img):
                ?>
<!--                <a id="single_image" href="image_big.jpg">-->
<!--                    <img src="image_small.jpg" alt=""/>-->
<!--                </a>-->

                <div class="img-block">
                    <a id="single_image" href="<?='/uploads/albums/' . $model->id . '/' . $img ?>">
                        <div class="img-block-img" style="background: url('<?='/uploads/albums/' . $model->id . '/' . $img ?>'); background-size: cover;"></div>
                    </a>
                </div>
                <?php
            endforeach;
        ?>
    </div><br>
</div>

<script>
    $(document).ready(function() {

        /* This is basic - uses default settings */

        $("a#single_image").fancybox();

        /* Using custom settings */

        $("a#inline").fancybox({
            'hideOnContentClick': true
        });

        /* Apply fancybox to multiple items */

        $("a.group").fancybox({
            'transitionIn'	:	'elastic',
            'transitionOut'	:	'elastic',
            'speedIn'		:	600,
            'speedOut'		:	200,
            'overlayShow'	:	false
        });

    });
</script>
