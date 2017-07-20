<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
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
