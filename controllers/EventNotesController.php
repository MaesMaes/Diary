<?php

namespace app\controllers;

use app\models\Events;
use app\models\User;
use Yii;
use app\models\EventNotes;
use app\models\EventNotesSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * EventNotesController implements the CRUD actions for EventNotes model.
 */
class EventNotesController extends Controller
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
     * Lists all EventNotes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventNotesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EventNotes model.
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
     * Creates a new EventNotes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EventNotes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EventNotes model.
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
                'pupils' => User::getAllPupil(true)
            ]);
        }
    }

    /**
     * Deletes an existing EventNotes model.
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
     * Finds the EventNotes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EventNotes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventNotes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Возвращает список замечаний ученика в пределах события
     */
    public function actionGetPupilNotes()
    {
        if (Yii::$app->request->isPost) {
            $pupilID = Yii::$app->request->post('pupilID');
            $eventID = Events::getEventID(Yii::$app->request->referrer);

            $dArr = [];
            $data = EventNotes::find()->where(['pupilID' => $pupilID, 'eventID' => $eventID])->all();
            foreach ($data as $note) {
                $dArr[] = [
                    'id' => $note->id,
                    'note' => $note->note,
                    'worked' => $note->worked,
                ];
            }
            if (empty($dArr)) $dArr = 'no-notes';

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $dArr;
        }
    }
}
