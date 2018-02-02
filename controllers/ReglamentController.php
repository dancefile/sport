<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use app\models\Tur;
use app\models\TurSearch;
use app\models\Judge;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ReglamentController extends AppController
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex($otd_id=null, $otd_name = null)
    {        
        if (!$otd_id){
            $otd = \app\models\Otd::find()->one();
            $otd_id = $otd->id;
            $otd_name = $otd->name;
        }
        
        $searchModel = new CategorySearch();
        $searchModel->otd_id =$otd_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);      
        $dataProvider->pagination= false;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'otd_list' => Category::getOtdList(),
            'otd_name' => $otd_name,
        ]);
    }

    
    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
