<?php
use app\models\User;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p> <? if (isset(Yii::$app->user->identity->name)) echo Yii::$app->user->identity->name . ' ' . Yii::$app->user->identity->lastName; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">-->
<!--            <div class="input-group">-->
<!--                <input type="text" name="q" class="form-control" placeholder="Поиск..."/>-->
<!--              <span class="input-group-btn">-->
<!--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
<!--                </button>-->
<!--              </span>-->
<!--            </div>-->
<!--        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header'], 'visible' => !Yii::$app->user->isGuest && User::getRoleNameByUserId(Yii::$app->user->identity->id) == User::USER_TYPE_ADMIN,],
                    ['label' => 'Пользователи', 'icon' => 'user', 'url' => ['/user'], ],
                    ['label' => 'Предметы', 'icon' => 'th-list', 'url' => ['/subject'], ],
                    ['label' => 'Классы', 'icon' => 'list-alt', 'url' => ['/school-class'], ],
                    ['label' => 'События', 'icon' => 'star', 'url' => ['/events']],
                    ['label' => 'О проекте', 'icon' => 'bookmark', 'url' => ['/site/about']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
//                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
//                    ['label' => 'Login', 'url' => ['auth/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

    </section>

</aside>
