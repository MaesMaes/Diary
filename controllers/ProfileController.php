<?php

namespace app\controllers;

use app\models\Banners;
use Yii;
use yii\filters\AccessControl;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $banners = Banners::findAll(['place' => 1]);
        return $this->render('index', [
            'banners' => $banners
        ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        $this->redirect('/auth/login');
                    } else {
                        $this->redirect('/site/error');
                    }
                }
            ],
        ];
    }

}
