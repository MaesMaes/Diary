<?php
/* @var $this yii\web\View */
use evgeniyrru\yii2slick\Slick;
use yii\helpers\Html;
use yii\web\JsExpression;

$this->title = '';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile">
    <h1>Привет, <?= Yii::$app->user->identity->name ?>, как настрой?</h1>
    <div class="row">
        <?php
            foreach ($banners as $banner):
                $urls = json_decode($banner->URLs);
                if (empty($urls)) continue;
                $items = [];
                foreach ($urls as $url)
                    $items[] = Html::img('/tmp/banners/' . $url, ['class' => 'a-slide']);
        ?>
                <br>
                <div class="profile-banner">
                <?=Slick::widget([

                    // HTML tag for container. Div is default.
                    'itemContainer' => 'div',

                    // HTML attributes for widget container
                    'containerOptions' => ['class' => ''],

                    // Items for carousel. Empty array not allowed, exception will be throw, if empty
    //                'items' => [
    //                    Html::img('/tmp/profile/profile-bg-1.jpg'),
    //                    Html::img('/tmp/profile/profile-bg-1.jpg'),
    //                    Html::img('/tmp/profile/profile-bg-1.jpg'),
    //                ],
                    'items' => $items,

                    // HTML attribute for every carousel item
                    'itemOptions' => [],

                    // settings for js plugin
                    // @see http://kenwheeler.github.io/slick/#settings
                    'clientOptions' => [
                        'autoplay' => true,
                        'dots'     => false,
                        // note, that for params passing function you should use JsExpression object
                        'onAfterChange' => new JsExpression('function() {console.log("The cat has shown")}'),
                        'slidesToShow' => 1,
                        'slidesToScroll' => 1,
                        'arrows' => false,
                        'adaptiveHeight' => true,
                    ],
                ]); ?>
             </div>
        <?
            endforeach;
        ?>
    </div>

</div>

