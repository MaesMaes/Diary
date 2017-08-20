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
        <?php
            $role = User::getRoleNameByUserId(Yii::$app->user->identity->id);
            $guest = Yii::$app->user->isGuest;

            $eventsUrl = '/events';
            if ($role == User::USER_TYPE_PUPIL || $role == User::USER_TYPE_PARENT)
                $eventsUrl = '/events/score';
        ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Профиль', 'icon' => 'user', 'url' => ['/profile'], ],
                    ['label' => 'Меню', 'options' => ['class' => 'header'], ],
                    [
                        'label' => 'Пользователи',
                        'icon' => 'user',
                        'url' => ['/user'],
                        'visible' => !$guest && $role == User::USER_TYPE_ADMIN,
                    ],
                    [
                        'label' => 'Предметы',
                        'icon' => 'th-list',
                        'url' => ['/subject'],
                        'visible' => !$guest && $role == User::USER_TYPE_ADMIN,
                    ],
                    [
                        'label' => 'Классы',
                        'icon' => 'list-alt',
                        'url' => ['/school-class'],
                        'visible' => !$guest && $role == User::USER_TYPE_ADMIN,
                    ],
                    [
                        'label' => 'События',
                        'icon' => 'star',
                        'url' => [$eventsUrl],
                        'visible' => !$guest
                    ],
                    ['label' => 'О проекте', 'icon' => 'bookmark', 'url' => ['/site/about']],
                    [
                        'label' => 'Gii',
                        'icon' => 'file-code-o',
                        'url' => ['/gii'],
                        'visible' => !$guest && $role == User::USER_TYPE_ADMIN,
                    ],
                    [
                        'label' => 'ДДС',
                        'icon' => 'usd',
                        'url' => '#',
                        'items' =>
                            [
                                [
                                    'label' => 'Приходы',
                                    'url' => ['/incoming'],
                                    'icon' => 'arrow-left',
                                ],
                                [
                                    'label' => 'Расходы',
                                    'url' => ['/costs'],
                                    'icon' => 'arrow-right',
                                ],
                                [
                                    'label' => 'Кассовый остаток',
                                    'url' => ['/incoming/cash-balance'],
                                    'icon' => 'briefcase',
                                ],
                            ],
                        'visible' => !$guest && $role == User::USER_TYPE_ADMIN,
                    ],
                    [
                        'label' => 'Нормативные документы',
                        'icon' => 'file-pdf-o',
                        'url' => '/documents',
                        'visible' => !$guest && ($role == User::USER_TYPE_ADMIN),
                    ],
                    [
                        'label' => 'Нормативные документы',
                        'icon' => 'file-pdf-o',
                        'url' => '/documents/smart-view',
                        'visible' => !$guest && ($role == User::USER_TYPE_ADMIN || $role == User::USER_TYPE_TEACHER ||  $role == User::USER_TYPE_PARENT),
                    ],
                    [
                        'label' => 'Настройки',
                        'icon' => 'gear',
                        'url' => '#',
                        'items' =>
                            [
                                [
                                    'label' => 'Баннеры',
                                    'url' => ['/banners'],
                                    'icon' => 'image',
                                ],
                            ],
                        'visible' => !$guest && $role == User::USER_TYPE_ADMIN,
                    ],
//                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
//                    ['label' => 'Login', 'url' => ['auth/login'], 'visible' => $guest],
                ],
            ]
        ) ?>

    </section>

</aside>
