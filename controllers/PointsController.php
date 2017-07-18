<?php

namespace app\controllers;

use Yii;
use app\models\Points;
use app\models\PointsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PointsController implements the CRUD actions for Points model.
 */
class PointsController extends Controller
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
     * Lists all Points models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PointsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Points model.
     * @param integer $user_id
     * @param integer $event_id
     * @return mixed
     */
    public function actionView($user_id, $event_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_id, $event_id),
        ]);
    }

    /**
     * Creates a new Points model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Points();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'event_id' => $model->event_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Points model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param integer $event_id
     * @return mixed
     */
    public function actionUpdate($user_id, $event_id)
    {
        $model = $this->findModel($user_id, $event_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'event_id' => $model->event_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Points model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param integer $event_id
     * @return mixed
     */
    public function actionDelete($user_id, $event_id)
    {
        $this->findModel($user_id, $event_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Points model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param integer $event_id
     * @return Points the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $event_id)
    {
        if (($model = Points::findOne(['user_id' => $user_id, 'event_id' => $event_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
