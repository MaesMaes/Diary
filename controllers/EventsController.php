<?php

namespace app\controllers;

use app\models\Points;
use app\models\SchoolClass;
use app\models\Subject;
use app\models\User;
use app\models\UserSearch;
use DateTime;
use edofre\fullcalendar\models\Event;
use Yii;
use app\models\Events;
use app\models\EventsSearch;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventsController implements the CRUD actions for Events model.
 */
class EventsController extends Controller
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
     * Lists all Events models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $eventsForCalendar = $dataProvider->query->all();

        //Выводим инфу о событиях только тем пользователям которые его создавали
        $role = User::getRoleNameByUserId(Yii::$app->user->identity->id);
        if ($role != User::USER_TYPE_ADMIN) {
            $dataProvider->query->where('moderator = ' . Yii::$app->user->id);
//            $eventsForCalendar = $dataProvider->query->where('moderator = ' . Yii::$app->user->id)->all();
        }
//        echo '<pre>';

        $events = [];
        $classManagementID = User::findOne(Yii::$app->user->id)->classManagement;
        $classManagement = SchoolClass::findOne($classManagementID)->name;
//        print_r($classManagement);

        foreach ($eventsForCalendar as $event) {
            $date = new DateTime();

            //Показываем только события класса где пользователь ведет руководство
            if ($role != User::USER_TYPE_ADMIN) {
                $classNames = $event->getEventClasses();
//                print_r($classNames);

                if ($event->moderator != Yii::$app->user->id && !in_array($classManagement, $classNames)) continue;
            }

            $duration = 2700;
            if (isset($event->duration))
                $duration = $event->duration * 60;

            $date->setTimestamp(strtotime($event->date) + $duration);
            $dateEventEnd = $date->format('Y-m-d H:i:s');

            $events[] = new Event([
                    'id'               => $event->id,
                    'title'            => $event->name . ": "
                                            . Subject::findOne($event->subject)->name . ' - '
                                            . $event->place . ', Классы: '
                                            . $event->getEventClasses(true),
                    'start'            => str_replace(' ', 'T', $event->date),
                    'end'              => str_replace(' ', 'T', $dateEventEnd),
                    'startEditable'    => false,
                    'durationEditable' => false,
                    'overlap'          => false,
                    'url'              => '/events/view?id=' . $event->id,
                    'color'            => 'orange',
            ]);
        }
//        echo '<pre>'; print_r($events); die;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'events' => $events,
        ]);
    }

    /**
     * Отображение расписания события где ученик является участником,
     * список оценок по событиям. Выводиться ученику и родителю.
     *
     * @return mixed
     */
    public function actionScore()
    {
        $query = Events::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (User::isRole(User::USER_TYPE_PUPIL))
            $query->leftJoin('events_users', 'event_id=id')->where('user_id=' . Yii::$app->user->id);

        if (User::isRole(User::USER_TYPE_PARENT)) {
            $childId = User::findOne(Yii::$app->user->id)->child ?? 0;
            $query->leftJoin('events_users', 'event_id=id')->where('user_id=' . $childId);
        }

        return $this->render('indexForPupils', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Events model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProviderPupilsOnEvent' => new ActiveDataProvider([
                'query' => User::find()->joinWith('events')->where(['event_id' => $id])
            ]),
        ]);
    }

    /**
     * Creates a new Events model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Events();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->checkModeratorValue($model);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'subjects' => ArrayHelper::map(Subject::find()->all(), 'id', 'name'),
                'moderators' => User::getAllModerators(),
            ]);
        }
    }

    /**
     * Updates an existing Events model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

//        $this->formatDateFields($model);

        //Обновление списка участников
//        if (Yii::$app->request->post('selection'))
//        {
//            //Получаем выбранных учеников из формы
//            $pupils = Yii::$app->request->post('selection');
//            if (empty($pupils)) {
//                User::deleteRelationWithEvent($id);
//            }
//
//            //Сохраняем их
//            $model->savePupils($pupils);
//
//            return $this->redirect(['update', 'id' => $model->id]);
//        }

        //Обновление основной формы
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->checkModeratorValue($model);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $s = new UserSearch();
            return $this->render('update', [
                'model' => $model,
                'subjects' => ArrayHelper::map(Subject::find()->all(), 'id', 'name'),
                'moderators' => User::getAllModerators(),
//                'dataProviderPupils' => new ActiveDataProvider([
//                    'query' => User::find()->joinWith('class')->where(['user.id' => User::getUsersByRole('pupil')])
//                ]),
                'dataProviderPupils' => $s->search(Yii::$app->request->queryParams),
                'dataProviderPupilsOnEvent' => new ActiveDataProvider([
                    'query' => User::find()->joinWith('events')->where(['event_id' => $model->id])
                ]),
//                'dataProviderPupilsOnEvent' => $s->search(Yii::$app->request->queryParams),
                'searchModelPupils' => $s,
            ]);
        }
    }

    /**
     * Deletes an existing Events model.
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
     * Добавление участников события
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionPupilsList($id)
    {
        $s = new UserSearch();

        if (Yii::$app->request->isPost)
        {
            $model = $this->findModel($id);

            if ($pupils = Yii::$app->request->post('pupilsId')) {
                $pupils = explode(',', $pupils);
                $model->savePupils($pupils, false);
            }
//            else {
//                User::deleteRelationWithEvent($id);
//            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $dataProviderPupils = $s->search(Yii::$app->request->queryParams);
//        $dataProviderPupils->pagination = true;
        $dataProviderPupils->pagination  = false;

        return $this->render('pupilsList', [
            'model' => $this->findModel($id),
//            'dataProviderPupils' => $s->search(Yii::$app->request->queryParams),
            'dataProviderPupils' => $dataProviderPupils,
            'searchModelPupils' => $s,
            'dataProviderPupilsOnEvent' => new ActiveDataProvider([
                'query' => User::find()->joinWith('events')->where(['event_id' => $id]),
                'pagination' => false,
            ]),
        ]);
    }

    /**
     * Оценить участников события
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionEventPupilsPoints($id)
    {
        // validate if there is a editable input saved via AJAX
        if (Yii::$app->request->post('hasEditable')) {
            $userId = Yii::$app->request->post('editableKey');
            $point = current($_POST['User'])['point'] ?? 0;

//            print_r($id); die;

            if (empty(Points::findOne([ 'user_id' => $userId, 'event_id' => $id ]))) {
                $model = new Points();
                $model->event_id = $id;
                $model->user_id = $userId;
                $model->point = $point;
                $model->save();
            } else {
                $model = Points::findOne([ 'user_id' => $userId, 'event_id' => $id ]);
                $model->point = $point;
                $model->save();
            }

            $out = Json::encode(['output' => '', 'message' => '']);
            echo $out;

            return;
        }

        return $this->render('eventPupilsPoints', [
            'model' => $this->findModel($id),
            'dataProviderPupilsOnEvent' => new ActiveDataProvider([
                'query' => User::find()
                    ->joinWith('events')->where(['events_users.event_id' => $id])
            ]),
        ]);
    }

//    public function actionPupilsListA($id)
//    {
//        $s = new UserSearch();
//
//        if (Yii::$app->request->isPost) {
//            echo '<pre>';
//            print_r(Yii::$app->request->post());
//            die;
//        }
//
//        return $this->render('pupilsList', [
//            'model' => $this->findModel($id),
//            'dataProviderPupils' => $s->search(Yii::$app->request->queryParams),
//            'searchModelPupils' => $s,
//            'dataProviderPupilsOnEvent' => new ActiveDataProvider([
//                'query' => User::find()->joinWith('events')->where(['event_id' => $id])
//            ]),
//        ]);
//    }

    /**
     * Finds the Events model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Events the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Events::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Форматирует дату в  формат d.m.Y
     *
     * @param $model
     */
    private function formatDateFields($model)
    {
        $model->date = Yii::$app->formatter->asDate($model->date);

        // Ставим обработчик который после успешной проверки данных в пользовательском формате вернет дату в формат для mysql
        $model->on(ActiveRecord::EVENT_BEFORE_UPDATE, function () use ($model) {
            $model->date = \DateTime::createFromFormat('d.m.Y', $model->date)->format('Y-m-d');
        });
    }

    /**
     * Проверяет установлено ли поле модератор, если нет -
     * установит текущего пользователя
     *
     * @param $model
     */
    private function checkModeratorValue($model)
    {
        if (!isset($model->moderator)) {
            $model->moderator = Yii::$app->user->id;
            $model->save();
        }
    }
}
