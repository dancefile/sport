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
class CategoryController extends AppController
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

        // $otdCount = Category::find()
        //     ->select(['otd'])
        //     ->DISTINCT(true)
        //     ->count();
        
        $searchModel = new CategorySearch();
        
        // for ($otd=1; $otd<=$otdCount; $otd++) {

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            return $this->render('reglament', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,

            ]);
        // }

        

    


        // $turSearchModel = new TurSearch();
        // $turDataProvider = $turSearchModel->search(Yii::$app->request->queryParams);        

        

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        //     'turSearchModel' => $turSearchModel,
        //     'turDataProvider' => $turDataProvider,
        // ]);
    }


    public function actions()
       {
           return ArrayHelper::merge(parent::actions(), [
               'editname' => [                                       // identifier for your editable column action
                   'class' => EditableColumnAction::className(),     // action class name
                   'modelClass' => Category::className(),                // the model for the record being edited
                   // 'outputValue' => function ($model, $attribute, $key, $index) {
                   //       return (int) $model->$attribute / 100;      // return any custom output value if desired
                   // },
                   'outputMessage' => function($model, $attribute, $key, $index) {
                         return '';                                  // any custom error to return after model save
                   },
                   'showModelErrors' => true,                        // show model validation errors after save
                   'errorOptions' => ['header' => '']                // error summary HTML options
                   // 'postOnly' => true,
                   // 'ajaxOnly' => true,
                   // 'findModel' => function($id, $action) {},
                   // 'checkAccess' => function($action, $model) {}
               ]
           ]);
       }    


    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
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
