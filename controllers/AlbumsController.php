<?php

namespace app\controllers;

use Yii;
use app\models\Albums;
use app\models\AlbumsSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AlbumsController implements the CRUD actions for Albums model.
 */
class AlbumsController extends Controller
{
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
     * Lists all Albums models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlbumsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Albums models.
     * @return mixed
     */
    public function actionAllIndex()
    {
        $data = [];
        $models = Albums::find()->all();

        foreach ($models as $model) {
            $data[] = [
                'name' => $model->name,
                'id' => $model->id,
                'imagePreview' => Yii::$app->homeUrl . Albums::$savePath . $model->id . '/' . json_decode($model->images)[0]
            ];
        }

        return $this->render('all-index', [
            'data' => $data
        ]);
    }

    public function actionAllView($id)
    {
        return $this->render('all-view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Albums model.
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
     * Creates a new Albums model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Albums();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->creatorID = Yii::$app->user->id;
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Albums model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Albums model.
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
     * Finds the Albums model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Albums the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Albums::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Контроллер DropZone для загрузки шпегов
     *
     * @param $id
     * @return bool
     */
    public function actionUploadImage($id)
    {
        $fileName = 'file';

        $uploadPath = $this->getUploadPath($id);

        if (isset($_FILES[$fileName])) {
            $albumId = Yii::$app->request->get('id');

            $fileObj = UploadedFile::getInstanceByName($fileName);
            $fileUniqueName = $albumId . '-' . $fileObj->name;
            $fileObj->saveAs($uploadPath . '/' . $fileUniqueName);

            $albumsModel = Albums::findOne($albumId);
            $albumsModel->saveImages($fileUniqueName);

            echo Json::encode($fileObj);
        }

        return false;
    }

    /**
     * Возвращет путь в который будем сохранять картинки альбома
     *
     * @param $modelID
     * @return string
     */
    public function getUploadPath($modelID)
    {
        $uploadPath = Albums::$savePath . $modelID;
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath);
        }
        $uploadPath .= '/';

        return $uploadPath;
    }
}
