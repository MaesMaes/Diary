<?php

namespace app\controllers;

use app\models\Costs;
use app\models\User;
use Dompdf\Dompdf;
use PHPExcel_Cell;
use PHPExcel_IOFactory;
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

    public function actionTestExcel($id)
    {
        $model = $this->findModel($id);
        $tmpFilePath = Yii::getAlias('@app') . '/web/files/Приход №' . $id . '.xlsx';

        $objPHPExcel = PHPExcel_IOFactory::load(Yii::getAlias('@app') . '/web/files/pko_ko-1.xlsx');
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        for ($row = 1; $row <= $highestRow; ++$row) {
            for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                $cell = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                switch ($cell) {
                    case '%ORGANIZATION%':
                        $objWorksheet->setCellValueByColumnAndRow($col, $row, 'ООО "Гипердом"');
                        break;
                    case '%DOC_NUM%':
                        $objWorksheet->setCellValueByColumnAndRow($col, $row, '40000' . $model->incomingID);
                        break;
                    case '%DATE%':
                        $objWorksheet->setCellValueByColumnAndRow($col, $row, $model->date);
                        break;
                    case '%DEBET%':
                        $objWorksheet->setCellValueByColumnAndRow($col, $row, $model->sum);
                        break;
                    case '%CREDIT%':
                        $objWorksheet->setCellValueByColumnAndRow($col, $row, $model->sum);
                        break;
                    case '%SUM%':
                        $objWorksheet->setCellValueByColumnAndRow($col, $row, $model->sum);
                        break;
                }
            }
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($tmpFilePath);

        return Yii::$app->response->sendFile($tmpFilePath);

//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
//        $objWriter->save(Yii::getAlias('@app') . '/web/files/pko_tmp.html');
//
//        $html = file_get_contents(Yii::getAlias('@app') . '/web/files/pko_tmp.html');
//        $dompdf = new Dompdf();
//        $dompdf->loadHtml($html);
//
//        // (Optional) Setup the paper size and orientation
//        $dompdf->setPaper('A4', 'landscape');
//
//        // Render the HTML as PDF
//        $dompdf->render();
//
//        // Output the generated PDF to Browser
//        $dompdf->stream();
    }
}
