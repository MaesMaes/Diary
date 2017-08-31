<?php

namespace app\controllers;

use app\models\EventNotes;
use app\models\Events;
use DateTime;
use Yii;
use app\models\Marks;
use app\models\MarksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarksController implements the CRUD actions for Marks model.
 */
class MarksController extends Controller
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
     * Lists all Marks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Marks model.
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
     * Creates a new Marks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Marks();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Marks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Marks model.
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
     * Finds the Marks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Marks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Marks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Контрольная работа
     */
    public function actionTestMark()
    {
        if (Yii::$app->request->isPost) {
            $pupilID = Yii::$app->request->post('pupilID');
            $eventID = $this->getEventID(Yii::$app->request->referrer);
            $value = Yii::$app->request->post('value');
            $type = Yii::$app->request->post('type');


            //Начислять суприки всем ученикам кто присутствовал и не имеет за прошлый день замечаний по поведению
            $eventModel = Events::findOne($eventID);
            $date = new DateTime();
            $date->setTimestamp(strtotime($eventModel->date) - 60 * 60 * 24);
            $lastDaySQLFormat = $date->format('Y-m-d');
            $eventNoteModel = EventNotes::find()
                                ->where(['between', 'date', "$lastDaySQLFormat 0:0:0", "$lastDaySQLFormat 23:59:59" ])
                                ->all();


            if (!$this->validateActionType($type)) return;

            $model = Marks::getOrCreateModel($eventID, $pupilID);
            $model->validateNotes = (isset($eventNoteModel) && empty($eventNoteModel)) ? true : false;
            $model->{$type} = $value;
            print_r($model);
            $model->save();
        }
    }

    /**
     * Возвращет id ивента по рефереру
     *
     * @param $link
     * @return mixed
     */
    private function getEventID($link)
    {
        $queryParams = parse_url($link)['query'];
        parse_str($queryParams, $params);
        return $params['id'];
    }

    /**
     * Проверяет валидность типа из AJAX, это нужно т.к.
     * будет динамическое обращение к данным из этого поля.
     *
     * @param $type
     * @return bool
     */
    private function validateActionType($type)
    {
        switch ($type) {
            case 'test':
                return true;
            case 'test_theme':
                return true;
            case 'test_lesson':
                return true;
            case 'lights':
                return true;
            case 'active':
                return true;
            default:
                return false;
        }
    }
}
