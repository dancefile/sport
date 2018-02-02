<?php

namespace app\controllers;

use Yii;
use app\models\Registration;
use app\services\RegService;
use app\models\In;



class RegistrationController extends AppController
{
   
   public function actionSearch($query='') {
   	
	echo json_encode($array);
		
   }
   
   
     public function actionCreate($pre_reg_id=null)
     {
         $model = new Registration();

         if ($pre_reg_id){
             $pre_reg = \app\models\PreRegistration::find()->where(['id'=>$pre_reg_id])->one();
             $model->d1_name = $pre_reg->dancer1_name;
             $model->d1_sname = $pre_reg->dancer1_sname;
             $model->d2_name = $pre_reg->dancer2_name;
             $model->d2_sname = $pre_reg->dancer2_sname;
             $model->d_trener1_name = $pre_reg->trener_name;
             $model->d_trener1_sname = $pre_reg->trener_sname;
             $model->city = $pre_reg->city;
             $model->club = $pre_reg->club;
         }
         
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             
             RegService::regSave($model, false);
             
             return $this->redirect(['in/index']);
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
             
             RegService::regSave($model, true);

             return $this->redirect(['in/index']);
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
