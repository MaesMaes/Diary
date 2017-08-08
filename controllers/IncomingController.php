<?php

namespace app\controllers;

use app\models\Costs;
use app\models\User;
use Yii;
use app\models\Incoming;
use app\models\IncomingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IncomingController implements the CRUD actions for Incoming model.
 */
class IncomingController extends Controller
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
     * Lists all Incoming models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IncomingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Incoming model.
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
     * Creates a new Incoming model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Incoming();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->incomingID]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'pupils' => User::getAllPupil(),
                'parents' => User::getAllParents(),
                'subject' => Incoming::getAllSubjects(),
            ]);
        }
    }

    /**
     * Updates an existing Incoming model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->incomingID]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'pupils' => User::getAllPupil(),
                'parents' => User::getAllParents(),
                'subject' => Incoming::getAllSubjects(),
            ]);
        }
    }

    /**
     * Deletes an existing Incoming model.
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
     * Finds the Incoming model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Incoming the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Incoming::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCashBalance()
    {
        $incomig = 0;
        $incomigArr = Incoming::findAll(['checkingAccount' => 0]);
        foreach ($incomigArr as $in)
            $incomig += $in->sum;

        $costs = 0;
        $costsArr = Costs::findAll([]);
        foreach ($costsArr as $co)
            $costs += $co->sum;

        return $this->render('cashBalance',[
            'balance' => $incomig - $costs
        ]);
    }
}
