<?php

namespace app\controllers;

use app\models\Contracts;
use app\models\ContractsSearch;
use app\models\ContractTypes;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * ContractsController implements the CRUD actions for Contracts model.
 */
class ContractsController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete', 'update', 'abort'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Contracts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContractsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Contract model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contracts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        // Типы контрактов
        $contractTypes = ContractTypes::find()->all();
        $contractTypesSelect = [];
        foreach ($contractTypes as $contractType) {
            $id = $contractType->id;
            $title = $contractType->title;
            $contractTypesSelect[$id] = $title;
        }

        // Родители
        $parentsSelect = User::getAllParents();
        $childrenSelect = User::getAllPupil();

        return $this->render('create', [
            'model' => $model,
            'contractTypesSelect' => $contractTypesSelect,
            'parentsSelect' => $parentsSelect,
            'childrenSelect' => $childrenSelect
        ]);
    }

    /**
     * Updates an existing Contract model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = Contracts::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        if($model) {
            // Типы контрактов
            $contractTypes = ContractTypes::find()->all();
            $contractTypesSelect = [];
            foreach ($contractTypes as $contractType) {
                $id = $contractType->id;
                $title = $contractType->title;
                $contractTypesSelect[$id] = $title;
            }

            // Родители
            $parentsSelect = User::getAllParents();
            $childrenSelect = User::getAllPupil();

            return $this->render('update', [
                'model' => $model,
                'contractTypesSelect' => $contractTypesSelect,
                'parentsSelect' => $parentsSelect,
                'childrenSelect' => $childrenSelect
            ]);
        } else {
            return $this->render('index');
        }
    }

    // Разрыв контракта
    public function actionAbort($id) {
        $model = Contracts::findOne($id);
        if($model) {
            if($model->is_stopped)
                $model->is_stopped = false;
            else
                $model->is_stopped = true;

            $model->save();
        }

        return $this->redirect(['index']);
    }
}