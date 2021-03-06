<?php

namespace app\controllers;

use Yii;
use app\models\Tur;
use app\models\TurSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

/**
 * TurController implements the CRUD actions for Tur model.
 */
class TurController extends Controller
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



    public function actions()
       {
           return ArrayHelper::merge(parent::actions(), [
               'editCell' => [                                       // identifier for your editable column action
                   'class' => EditableColumnAction::className(),     // action class name
                   'modelClass' => Tur::className(),                // the model for the record being edited
                   'outputMessage' => function($model, $attribute, $key, $index) {
                         return '';                                  // any custom error to return after model save
                   },
                   'showModelErrors' => true,                        // show model validation errors after save
                   'errorOptions' => ['header' => '']                // error summary HTML options
               ]
           ]);
       }    
    /**
     * Lists all Tur models.
     * @return mixed
     */
    public function actionIndex($cat_id=null)
    {
        $searchModel = new TurSearch();
        $searchModel->category_id =$cat_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($cat_id){
            $last_tur = Tur::find()->select('id')->where(['category_id' => $cat_id])->orderBy(['nomer' => SORT_DESC])->one();
        } else {
            $last_tur = null;
        }
        return $this->render('../reglament/_turs', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'last_tur' => $last_tur,
        ]);
    }

    /**
     * Displays a single Tur model.
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
     * Creates a new Tur model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($category_id, $dances)
    {
        $model = new Tur();

        $model->typeSkating = 1;
        $model->typezahod = 1;
        $model->category_id = $category_id;
        $model->dances = explode(", ", $dances);
        $n = Tur::find()->where(['category_id' => $category_id])->max('nomer');
        $model->nomer = ++$n;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['reglament/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tur model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->dances = explode(", ", $model->dances);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['tur/index', 'cat_id' => $model->category_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tur model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['reglament/index']);
    }

    /**
     * Finds the Tur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tur::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
