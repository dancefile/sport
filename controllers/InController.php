<?php

namespace app\controllers;

use Yii;
use app\models\In;
use app\models\InSearch;
use app\models\Dancer;
use app\models\Couple;
use app\models\Tur;
use app\models\Category;
use app\models\Setings;
use app\models\Club;
use app\models\City;
use app\models\Country;
use app\models\Trener;


use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use kartik\grid\EditableColumnAction;


/**
 * InController implements the CRUD actions for In model.
 */
class InController extends Controller
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
     * Lists all In models.
     * @return mixed
     */
    public function actionIndex($category_id=null, $otd_id=null)
    {        
        $searchModel = new InSearch();
        
        $otd_list = In::getOtdList();
        $class_list = In::getClassList();

        $searchModel->otd_id = $otd_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        
        return $this->render('index', 
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'otd_list' =>$otd_list,
                'otd_id' => $otd_id,
                'class_list' => $class_list,
            ]
        );
    }

    /**
     * Displays a single In model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionReplace()
    {
        $post = Yii::$app->request->post();
        $items = explode(',', $post['replace_ins']);
        $ins = In::find()->where(['id' => $items])->all();        
        $tur = Tur::find()->where(['category_id'=>$post['new-category-id']])->orderBy('nomer')->one();
        
        if (isset($post['replace'])){
            foreach ($ins as $in) {
                if (self::checkDuplicate($in, $tur)){
                    $in->updateAttributes(['tur_id' => $tur->id]);
                } 
            }
        } elseif (isset($post['copy'])){
            foreach ($ins as $in) {
                if (self::checkDuplicate($in, $tur)){
                    $new_in = new In();
                    $new_in->couple_id = $in->couple_id;
                    $new_in->tur_id = $tur->id;
                    $new_in->nomer = $in->nomer;
                    $new_in->who = $in->who;
                    $new_in->save(false);
                }
            }
        }
          
        return $this->redirect(['index', 'otd_id' => $post['otd_id']]);
    }
    
    private function checkDuplicate($in, $tur)
    {
        $c = In::find()
                ->where([
                    'couple_id' => $in->couple_id,
                    'tur_id' => $tur->id,
                ]);
        if($c->count()==0){
            return true;
        } else {
            Yii::$app->session->addFlash(
                    'danger', 
                    'Обнаружен Дублткат! Пара №'.$in->nomer.' уже сужествует в категории '.$tur->category->name);
        }
    }


    private function inSave($tur, $coupleId)
    {
        foreach ($tur as $key => $value) {
            if ($value) {
                $i = new In();
                $i->couple_id = $coupleId;
                $i->nomer = $value;
                $i->tur_id = $key;
                $i->save(false);  
            } 
        }
    }


    private function countrySave($country)
    {
        if (!$country){
            return false;
        } elseif (is_numeric($country)) {
            return $country;
        } else {
            $c = new Country();
            $c->name = $country;
            $c->save();
            return $c->id;
        } 
    }

    private function citySave($city, $country)
    {   
        $c = new City();

        if (!$city){
            $c->name = NULL;
        } elseif (is_numeric($city)) {
            return $city;
        } else {
            $c->name = $city;
        } 
        $c->country_id = $country;
        $c->save();
        return $c->id;
    }

    private function clubSave($club, $city)
    {
        $c = new Club();

        if (!$club && !$city) {
            return NULL;
        } elseif (!$club) {
            $c->name = NULL;
        } elseif (is_numeric($club)) {
            return $club;
        } else { 
            $c->name = $club;
        }
        $c->city_id = $city;
        $c->save();
        return $c->id;
    }

    private function dancerSave($dancer, $gender)
    {
        if ($dancer['sname']) {
            $d = new Dancer;
            $d->attributes = $dancer;
            $d->gender = $gender;
            $d->save();
            return $d;
        } else {
            return NULL;
        }
    }



    /**
     * Updates an existing In model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $in = $this->findModel($id);
        $model = new \app\models\Registration();
        $model->loadFromRecord($in);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             
             RegService::regSave($model);
             
             Yii::$app->session->setFlash('success', "Успешно!");
             return $this->redirect(['create']);
         } else {
             return $this->render('update', [
                 'in' => $model,
             ]);
         }
    }

    /**
     * Deletes an existing In model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, sname AS text')
                ->from('dancer')
                ->where(['like', 'sname', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Dancer::find($id)->sname];
        }
        return $out;
    }
    
        public function actionDancerInfo($id = null,$id_search = null,$type=null) {
            $query = new Query;
     $out = [];
          switch ($id_search) { 
        case 'registration-d2_sname': //фамилия партнерши	
        
        
           $query->select(['sname', 'name'])
            ->from('dancer')
            ->where('id ="' . $id .'"')
            ->limit(1);
            $command = $query->createCommand();
            $data = $command->queryAll();
       
          foreach ($data as $d) {
            $out = [
                'registration_d2_sname' => $d['sname'],
                'registration_d2_name' => $d['name'],
                
            ];
           }
        
        break;  
        
        case 'registration-d1_sname': //фамилия партнера
        
        
           $query->select(['sname', 'name'])
            ->from('dancer')
            ->where('id ="' . $id .'"')
            ->limit(1);
            $command = $query->createCommand();
            $data = $command->queryAll();
       
          foreach ($data as $d) {
            $out = [
                'registration_d1_sname' => $d['sname'],
                'registration_d1_name' => $d['name'],
                
            ];
           }
        
        break; 
           
        
           case 'registration-d_trener1_sname'://фамилия тренера
           case 'registration-d_trener2_sname':
           case 'registration-d_trener3_sname':
           case 'registration-d_trener4_sname':
           case 'registration-d_trener5_sname':
           case 'registration-d_trener6_sname':
           
                      $query->select(['sname', 'name',])
            ->from('trener')
            ->where('id ="' . $id .'"')
            ->limit(1);
            $command = $query->createCommand();
            $data = $command->queryAll();
       
          foreach ($data as $d) {
            $out = [
            'trener'.substr($id_search, 21,1).'_sname'  => $d['sname'],
            'trener'.substr($id_search, 21,1).'_name'   => $d['name'],
            ];
           }
               
           break; 
              
          }
           echo Json::encode($out); 
        }
        
    
    public function actionDancerList($q = null,$id_search = null) {
        $query = new Query;

        $out = [];
        
     switch ($id_search) {   
        
        case 'registration-d1_sname': //фамилия партнера
        case 'registration-d2_sname': //фамилия партнерши	
        
        
           $query->select(['sname', 'name', 'id'])
            ->from('dancer')
            ->where('sname LIKE "%' . $q .'%"')
            ->orderBy('sname')
            ->limit(10);
            $command = $query->createCommand();
            $data = $command->queryAll();
       
          foreach ($data as $d) {
            $out[] = [
                'type' => 1,
                'name' => $d['sname'] .' '.$d['name'],
                'id' => $d['id'],
            ];
           }
        
        break;
        
        
        case 'registration-club': //клуб
           
           $query->select(['name'])->distinct()
            ->from('club')
            ->where('name LIKE "%' . $q .'%"')
            ->orderBy('name')
             ->limit(10);
            $command = $query->createCommand();
            $data = $command->queryAll();
       
          foreach ($data as $d) {
            $out[] = [
                'type' => 1,
                'name' => $d['name'],
                'id' => 0,
            ];
           }
           break;
        case 'registration-city': //город
           $query->select(['name'])->distinct()
            ->from('city')
            ->where('name LIKE "%' . $q .'%"')
            ->orderBy('name')
             ->limit(10);
            $command = $query->createCommand();
            $data = $command->queryAll();
       
          foreach ($data as $d) {
            $out[] = [
                'type' => 1,
                'name' => $d['name'],
                'id' => 0,
            ];
           }
           break; 
           
           case 'registration-d_trener1_sname'://фамилия тренера
           case 'registration-d_trener2_sname':
           case 'registration-d_trener3_sname':
           case 'registration-d_trener4_sname':
           case 'registration-d_trener5_sname':
           case 'registration-d_trener6_sname':
           
                      $query->select(['sname', 'name', 'id'])
            ->from('trener')
            ->where('sname LIKE "%' . $q .'%"')
            ->orderBy('sname')
            ->limit(10);
            $command = $query->createCommand();
            $data = $command->queryAll();
       
          foreach ($data as $d) {
            $out[] = [
                'type' => 1,
                'name' => $d['sname'] .' '.$d['name'],
                'id' => $d['id'],
            ];
           }
               
           break; 
           
     }
        
        
        echo Json::encode($out);
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
