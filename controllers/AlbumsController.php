<?php

namespace app\controllers;

use app\models\Photo;
use app\models\User;
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
        $params = Yii::$app->request->queryParams;

        if (!User::isAdmin())
        $params = [
            'AlbumsSearch' => [
                'creatorID' => Yii::$app->user->id
            ]
        ];

        $dataProvider = $searchModel->search($params);

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
            $img = Photo::findOne(['albumID' => $model->id, 'active' => 1])->url ?? '';
            $data[] = [
                'name' => $model->name,
                'id' => $model->id,
                'imagePreview' => Yii::$app->homeUrl . Albums::$savePath . $model->id . '/' . $img
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
            'images' => Photo::findAll(['albumID' => $id, 'active' => 1])
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
            'images' =>  $images = Photo::findAll(['albumID' => $id, 'active' => true]),
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
        $images = Photo::findAll(['albumID' => $id]);

        $model->load(Yii::$app->request->post());
        $model->save();

        return $this->render('update', [
            'model' => $model,
            'images' => $images,
        ]);
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

    /**
     * Устанавливает или убирает активность фото в альбоме
     */
    public function actionCheckActive()
    {
        if (Yii::$app->request->isPost) {
            $imageID = Yii::$app->request->post('imageID');
            $status = Yii::$app->request->post('status');

            if ($status == 'true') $status = 1;
            else $status = 0;

            $model = Photo::findOne($imageID);
            $model->active = $status;
            $model->save();
        }
    }

    /**
     * Удаляет картинку в альбоме
     */
    public function actionDeleteImage()
    {
        if (Yii::$app->request->isPost) {
            $imageID = Yii::$app->request->post('imageID');
            $albumID = Yii::$app->request->post('albumID');

            $album = Albums::findOne($albumID);

            $album->deleteImageFile($imageID);
        }
    }
}
