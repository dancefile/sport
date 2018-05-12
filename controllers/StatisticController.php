<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Statistic;

class StatisticController extends Controller{
    
    public function actionIndex() {
        return $this->render('index');
    }
    
    
    
    public function actionCity() {
        $model = new Statistic();
        $dataProvider = $model->getStatCity();

        return $this->render('city', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionClub() {
        $model = new Statistic();
        $dataProvider = $model->getStatClub();

        return $this->render('club', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
