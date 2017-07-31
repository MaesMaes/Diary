<?php

namespace app\controllers;

use app\models\ImageUpload;
use app\models\User;
use Yii;
use app\models\Banners;
use app\models\BannersSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BannersController implements the CRUD actions for Banners model.
 */
class BannersController extends Controller
{
    const PLACES = [
        1 => 'Профиль'
    ];

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
        ];
    }

    /**
     * Lists all Banners models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Banners model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Banners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banners();
        $roles = User::getRolesMap();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'roles' => $roles,
                'places' => self::PLACES,
            ]);
        }
    }

    /**
     * Updates an existing Banners model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $roles = User::getRolesMap();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect( ['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'roles' => $roles,
                'places' => self::PLACES,
            ]);
        }
    }

    /**
     * Deletes an existing Banners model.
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
     * Finds the Banners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUploadImage($id)
    {
        $fileName = 'file';
        $uploadPath = Banners::getUploadPath();

        if (isset($_FILES[$fileName])) {
            $bannerId = Yii::$app->request->get('id');

            $fileObj = UploadedFile::getInstanceByName($fileName);
            $fileUniqueName = $bannerId . '-' . $fileObj->name;
            $fileObj->saveAs($uploadPath . '/' . $fileUniqueName);

            $bannerModel = Banners::findOne($bannerId);
            $bannerModel->saveImages($fileUniqueName);

            echo Json::encode($fileObj);
        }

        return false;
    }

    public function actionDeleteImage()
    {
        if (Yii::$app->request->isPost) {
            $modelID = Yii::$app->request->post('modelID');
            $imageName = Yii::$app->request->post('imageName');

            $bannerModel = Banners::findOne($modelID);
            $bannerModel->deleteImages($imageName);
        }
    }
}
