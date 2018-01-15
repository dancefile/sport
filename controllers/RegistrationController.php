<?php

namespace app\controllers;

use Yii;
use app\models\Registration;




class RegistrationController extends AppController
{
   
     public function actionCreate()
     {
         $model = new Registration();

         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             
             RegService::regCreate($model);
             
             Yii::$app->session->setFlash('success', "Успешно!");
             return $this->redirect(['create']);
         } else {
             return $this->render('create', [
                 'model' => $model,
             ]);
         }
     }

}
