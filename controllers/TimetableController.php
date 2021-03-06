<?php

namespace app\controllers;

use Yii;
use app\models\Timetable;
use app\models\TimetableSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use richardfan\sortable\SortableAction;

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

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Timetable::className(),
                'orderColumn' => 'sortItem',
//                'on afterRun' => self::timeupdate(5),
            ],
            
            // your other actions
        ];
    }
    
    /**
     * Lists all Timetable models.
     * @return mixed
     */
    public function actionIndex()//$otd_id=null
    {            
        return $this->render('index');
    }

    /**
     * Creates a new Timetable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($otd_id, $otd_name)
    {
        $model = new Timetable();
        $model->otd_id = $otd_id;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('index', ['otd_id'=>$otd_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'otd_id' => $otd_id,
            'otd_name' => $otd_name,
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
            Timetable::timeUpdate($model->otd_id);
            return $this->render('index', ['otd_id' => $model->otd_id]);
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
    
    public function actionDeletezero($otd_id)
    {
//        $qq= Timetable::find()->where(['AND', ['otd_id' => $otd_id], ['reg_pairs' => 0], ['<>', 'custom', '0']])->all();
//        print_r($qq);
//        exit;
        Timetable::deleteAll([
                            'AND',
                            ['otd_id' => $otd_id],
                            ['OR', ['reg_pairs' => 0], ['reg_pairs' => NULL]],
                            ['custom' => 0]
                        ]);
        return $this->render('index', ['otd_id'=>$otd_id]);
    }

    public function actionLoad($otd_id) 
    {
        Timetable::deleteAll(['otd_id'=>$otd_id]);
        Timetable::loadTurData($otd_id);
        return $this->render('index');
    }
    
    public function actionTimeupdate($otd_id)
    {
        Timetable::timeUpdate($otd_id);
        return $this->render('index', ['otd_id'=>$otd_id]);
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
