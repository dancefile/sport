<?php

namespace app\controllers;

use Yii;
use app\models\Timetable;
use app\models\TimetableSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TimetableController implements the CRUD actions for Timetable model.
 */
class TimetableController extends Controller
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
     * Lists all Timetable models.
     * @return mixed
     */
    public function actionIndex()//$otd_id=null
    {            
        $otds = \app\models\Otd::find()->all();
        $searchModel = new TimetableSearch();

        foreach ($otds as $otd) {
            $searchModel->otd_id =$otd['id'];
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//            if ($otd['id']==$otd_id) {
//                $active = true;
//            } else {
//                $active = null;
//            }
            $tabs[]=[
                'label'     =>  'Отделение '.$otd['name'],
                'content'   =>  $this->render(
                    '_tab', 
                    [
                        'dataProvider' =>  $dataProvider,
                        'otd_id' => $otd['id'],
                    ]
                ),
//                'active' => $active,
            ];
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'tabs' => $tabs,
        ]);
    }

    /**
     * Displays a single Timetable model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Timetable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($otd_id)
    {
        $model = new Timetable();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'otd_id' => $otd_id,
        ]);
    }

    /**
     * Updates an existing Timetable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Timetable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionLoad($otd_id) 
    {
        Timetable::deleteAll(['otd_id'=>$otd_id]);
        
        $turs = \app\models\Tur::find()->joinWith(['category', 'category.otd', 'ins'])->where(['category.otd_id'=>$otd_id])->asArray()->all();
        
//        $tt= array_filter($turs, function() {
//            if ($this['category']['program']==4){
//                return true;
//            }
//            
//        });
//        echo '<pre>', print_r($tt), '</pre>';
//        exit;
            
        foreach ($turs as $key=>$tur) {
            $tt = new Timetable();
            $tt->time = $tur['turTime'];
            $tt->otd_id = $tur['category']['otd_id'];
            $tt->tur_id = $tur['id'];
            $tt->tur_name = $tur['name'];
            $tt->category_name = $tur['category']['name'];
            $tt->tur_number = $tur['nomer'];
            $tt->reg_pairs = count($tur['ins']);
            $tt->programm = $tur['category']['program'];
            $tt->dances = $tur['dances'];
            $tt->heats_count = $tur['zahodcount'];
            $tt->dances_count = count(explode(',', $tur['dances']));
            $tt->save();
        } 
        
        return $this->redirect(['index', 'otd_id'=>$otd_id]);
    }
    /**
     * Finds the Timetable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Timetable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Timetable::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
