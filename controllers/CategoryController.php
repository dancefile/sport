<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use app\models\Tur;
use app\models\TurSearch;
use app\models\Judge;
use app\models\Chess;
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
        
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('reglament', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    public $judge_list;

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

        //Значения по умолчанию
        $model->skay = 1;
        $model->solo = 1;
        $model->program = 1;

        $judge_list = Judge::find()->select(['sname'])->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect(['reglament/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'judge_list' => $judge_list,
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

        $model->clas = explode(", ", $model->clas);
        $model->dances = explode(", ", $model->dances);

        $judge_list = Judge::find()->select(['sname'])->indexBy('id')->column();

        $model->chesses_list = Chess::find()->select(['judge_id'])->indexBy('judge_id')->where(['category_id' => $model->id])->column();    


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['reglament/index', 'otd_id' => $model->otd_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'judge_list' => $judge_list,
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

        return $this->redirect(['reglament/index']);
    }
    
//    public function actionGetdances($prog)
//    {
////        echo '<pre>', print_r($prog), '</pre>';
////        exit;
//        Category::getDanceList($prog);
//        return $this->renderAjax('update');
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
