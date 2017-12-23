<?php

namespace app\controllers;

use Yii;
use app\models\Registration;
use app\models\RegistrationSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



/**
 * CategoryController implements the CRUD actions for Category model.
 */
class RegistrationController extends AppController
{
    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new RegistrationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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

    // public $judge_list;

    // /**
    //  * Displays a single Category model.
    //  * @param integer $id
    //  * @return mixed
    //  */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    // /**
    //  * Creates a new Category model.
    //  * If creation is successful, the browser will be redirected to the 'view' page.
    //  * @return mixed
    //  */
    // public function actionCreate()
    // {
    //     $model = new Category();

    //     //Значения по умолчанию
    //     $model->skay = 1;
    //     $model->solo = 1;
    //     $model->program = 1;

    //     $judge_list = Judge::find()->select(['sname'])->indexBy('id')->column();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
    //         return $this->redirect(['reglament/index']);
    //     } else {
    //         return $this->render('create', [
    //             'model' => $model,
    //             'judge_list' => $judge_list,
    //         ]);
    //     }
    // }

    // /**
    //  * Updates an existing Category model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
    //  */

    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     $model->clas = explode(", ", $model->clas);
    //     $model->dances = explode(", ", $model->dances);

    //     $judge_list = Judge::find()->select(['sname'])->indexBy('id')->column();

    //     // $judge_list = Judge::find()->with('chesses')->all();
        
    //     // print_r($judge_list);
    //     // exit;

    //     $model->chesses_list = Chess::find()->select(['judge_id'])->indexBy('judge_id')->where(['category_id' => $model->id])->column();    


    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['reglament/index']);
    //     } else {
    //         return $this->render('update', [
    //             'model' => $model,
    //             'judge_list' => $judge_list,
    //         ]);
    //     }
    // }

    // /**
    //  * Deletes an existing Category model.
    //  * If deletion is successful, the browser will be redirected to the 'index' page.
    //  * @param integer $id
    //  * @return mixed
    //  */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['reglament/index']);
    // }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // protected function findModel($id)
    // {
    //     if (($model = Category::findOne($id)) !== null) {
    //         return $model;
    //     } else {
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }
    // }
}
