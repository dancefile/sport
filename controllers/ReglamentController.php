<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use app\models\Tur;
use app\models\TurSearch;
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
    public function actionIndex()
    {        
        $searchModel = new CategorySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);      
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,

            ]);
    }


    // public function actions()
    //    {
    //        return ArrayHelper::merge(parent::actions(), [
    //            'editCell' => [                                       // identifier for your editable column action
    //                'class' => EditableColumnAction::className(),     // action class name
    //                'modelClass' => Category::className(),                // the model for the record being edited
    //                'outputMessage' => function($model, $attribute, $key, $index) {
    //                      return '';                                  // any custom error to return after model save
    //                },
    //                'showModelErrors' => true,                        // show model validation errors after save
    //                'errorOptions' => ['header' => '']                // error summary HTML options
    //            ]
    //        ]);
    //    }    


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
