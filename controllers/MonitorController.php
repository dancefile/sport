<?php

namespace app\controllers;

use yii;
use yii\web\Controller;

class MonitorController extends Controller {
    public function actionIndex($otd_id=null) {
        $searchModel = new \app\models\TurSearch();
        $searchModel->otd_id = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', ['dataProvider'=>$dataProvider, 'searchModel'=>$searchModel]);
    }
}
