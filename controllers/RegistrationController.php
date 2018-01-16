<?php

namespace app\controllers;

use Yii;
use app\models\Registration;
use app\services\RegService;
use app\models\In;



class RegistrationController extends AppController
{
   
     public function actionCreate()
     {
         $model = new Registration();

         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             
             RegService::regSave($model);
             
             Yii::$app->session->setFlash('success', "Успешно!");
             return $this->redirect(['create']);
         } else {
             return $this->render('create', [
                 'model' => $model,
             ]);
         }
     }
     
    public function actionUpdate($id)
    {
        $in = $this->findModel($id);
        $model = new \app\models\Registration();
        $model->loadFromRecord($in);
       
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             
             RegService::regView($model);
             
             Yii::$app->session->setFlash('success', "Успешно!");
             return $this->redirect(['create']);
         } else {
             return $this->render('create', [
                 'model' => $model,
             ]);
         }
    }
    
        /**
     * Finds the In model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return In the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = In::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
