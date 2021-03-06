<?php

namespace app\controllers;

use app\models\EventNotes;
use app\models\Marks;
use app\models\SchoolClass;
use app\models\SchoolClassUsers;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
//    public $layout = "main";

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['userManage'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        $this->redirect('/auth/login');
                    } else {
                        $this->redirect('/auth/error');
                    }
                }
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['lastName' => SORT_ASC]];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'role' => User::getRoleName($id),
            'suprik' => Marks::getSuprikFromEvents($id) - EventNotes::getSuprikBalance($id) * 3,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        $roles = User::getRolesMap();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            User::updateRole($model->id, Yii::$app->request->post('role'));
            SchoolClassUsers::setPupil(Yii::$app->request->post('User')['class'], $model->id);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $pupils = User::getAllPupil();

            return $this->render('create', [
                'model' => $model,
                'roles' => $roles,
                'pupils' => $pupils,
                'parents' => User::getAllParents(),
                'classManagement' => ArrayHelper::map(SchoolClass::find()->asArray()->all(), 'id', 'name'),
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $rolesData = User::getRolesData($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            User::updateRole($id, Yii::$app->request->post('role'));
            SchoolClassUsers::setPupil(Yii::$app->request->post('User')['class'], $model->id);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $pupils = User::getAllPupil();

            return $this->render('update', [
                'model' => $model,
                'role' => key($rolesData['role']),
                'roles' => $rolesData['roles'],
                'pupils' => $pupils,
                'parents' => User::getAllParents(),
                'classManagement' => ArrayHelper::map(SchoolClass::find()->asArray()->all(), 'id', 'name'),
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
