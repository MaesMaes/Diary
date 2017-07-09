<?php
/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 22.06.17
 * Time: 6:58
 */

namespace app\controllers;


use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public $layout = "main-login";

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('/auth/login');
    }

    public function actionTest()
    {
//        $user = User::findOne(2);

//        Yii::$app->user->login($user);
//        Yii::$app->user->logout();

        if (Yii::$app->user->isGuest) {
            echo 'Привет, гость';
        } else {
            echo 'Пользователь авторизован';
        }
    }

    public function actionError()
    {
        return $this->render('error');
    }
}