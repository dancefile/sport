<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\JudgeSearch;
use app\models\Judge;

class JudgesController extends \yii\web\Controller
{
	public $defaultAction = 'list';

	public function actionList()
	{
	 	
		        $searchModel = new JudgeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);	
	}

    public function actionCreate()
    {
        $model = new Judge();

        //Значения по умолчанию
        //$model->skay = 1;
        //$model->solo = 1;
        //$model->program = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['judges/list']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

protected function findModel($id)
    {
        if (($model = Judge::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

     //   $model->clas = explode(", ", $model->clas);
     //   $model->dances = explode(", ", $model->dances);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['judges/list']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }



}