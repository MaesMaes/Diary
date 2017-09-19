<?php

namespace app\controllers;

use app\models\Contracts;
use app\models\ContractsSearch;
use Yii;
use yii\web\Controller;

/**
 * ContractsController implements the CRUD actions for Contracts model.
 */
class ContractsController extends Controller {


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
}