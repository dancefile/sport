<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\JudgeSearch;
use app\models\Judge;
use app\models\Otd;
use app\models\Category;
use app\models\Chess;

class JudgesController extends \yii\web\Controller
{
	public $defaultAction = 'list';

	public function actionList()
	{
	 	
		$searchModel = new JudgeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('list', ['dataProvider' => $dataProvider,]);	
	}

    public function actionCreate()
    {
        $model = new Judge();
        $model->language_id = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['judges/list']);
        } else {
            return $this->render('create', ['model' => $model,]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['judges/list']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionShaxmat($otd=0)
    {
    	

		if ($otd) {
			$otdes = Otd::findOne($otd);
			$Categories = Category::find()->where(['otd_id' => $otd])->orderBy('name')->all();
			$Chess = Chess::find()->all();//['category_id' => 30]
			$Judges = Judge::find()->orderBy('name')->all();
			return $this->render('shaxmat', ['otd' => $otd, 'otdname' => $otdes->name, 'Categories' => $Categories, 'Chess' => $Chess, 'Judges' => $Judges]);	
    	} else {
	 		$otdes = Otd::find()->orderBy('name')->all(); 
    		return $this->render('listotd', ['otdes' => $otdes]);
	 	}
		
		//return $this->redirect(['judges/shaxmat','otd'=>'1']);;
	}

}