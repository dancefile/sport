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
    public function actionIndex($category_id=null)
    {
        $otds = \app\models\Otd::find()->all();
        $searchModel = new InSearch();
        $searchModel->category_id =$category_id;
//        if ($category_id){
//            $searchModel->category_id =$category_id;
//        } else {
//            $searchModel->defaultOrder = ['tur_id' => SORT_ASC];
//        }
        return $this->render('index', [
            'otds' => $otds,
            'searchModel' => $searchModel,
            'category_id' => $category_id,
        ]);
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
    

    /**
     * Creates a new In model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $in = new In();
        $couple = new Couple();        

        if ($in->load(Yii::$app->request->post()) ) 
        {   
            if ($in->validate()) {                

                if (array_filter($in->turSolo_M)) {
                    if ($d1 = $this->dancerSave($in->dancer1, 1)) {
                        $couple = new Couple();
                        $couple->dancer_id_1 = $d1->id;
                        $couple->dancer_id_2 = NULL;
                        $couple->save();
                        $this->inSave($in->turSolo_M, $couple->id);
                    } else {
                        Yii::$app->session->setFlash('error', "Укажите данные танцора M!");
    //                    return $this->redirect(['create']);
                    }
                }

                if (array_filter($in->turSolo_W)) {
                    if ($d2 = $this->dancerSave($in->dancer2, 0)) {
                        $couple = new Couple();
                        $couple->dancer_id_2 = $d2->id;
                        $couple->dancer_id_1 = NULL;
                        $couple->save();
                        $this->inSave($in->turSolo_W, $couple->id);
                    } else {
                        Yii::$app->session->setFlash('error', "Укажите данные танцора W!");
    //                    return $this->redirect(['create']);
                    }
                }

                if (array_filter($in->turPair)) {           // Проверяем наличие регистраций в парах
                    if (isset($d1) && isset($d2)) {                       // и наличие двух танцоров
                        $couple = new Couple();
                        $couple->dancer_id_2 = $d2->id;
                        $couple->dancer_id_1 = $d1->id;
                        $couple->save();
                        $this->inSave($in->turPair, $couple->id);
                    } else {
                        $d1 = $this->dancerSave($in->dancer1, 1);
                        $d2 = $this->dancerSave($in->dancer2, 0);
                        if ($d1 && $d2) {
                            $couple = new Couple();
                            $couple->dancer_id_1 = $d1->id;
                            $couple->dancer_id_2 = $d2->id;
                            $couple->save();
                            $this->inSave($in->turPair, $couple->id);
                        } else {
                            Yii::$app->session->setFlash('error', "Укажите второго танцора!");
    //                        return $this->redirect(['create']);
                        }   
                    }
                }
                if (isset($in->dancer_trener)) {
                    foreach ($in->dancer_trener as $t) {
                        if ($t['sname'] || $t['name']) {
                            $trener = new Trener();
                            $trener->sname = $t['sname'];
                            $trener->name = $t['name'];
                            $trener->save();
                            $dt = new \app\models\DancerTrener;
                            $dt->trener_id = $trener->id;
                            $dt->dancer_id = $d1->id;
                            $dt->save();
                            $dt = new \app\models\DancerTrener;
                            $dt->trener_id = $trener->id;
                            $dt->dancer_id = $d2->id;
                            $dt->save(); 
                        }
                    }
                }
                $country = $this->countrySave($in->common['country']);

                if ($country) {
                    $city = $this->citySave($in->common['city'], $country);
                } else {
                    $city = $this->citySave($in->common['city'], NULL);
                }

                if ($city) {
                    $club = $this->clubSave($in->common['club'], $city);
                } else {
                    $club = $this->clubSave($in->common['club'], NULL);
                }

                if ($club) {
                    if ($d1) {
                        $d1->club = $club;
                        $d1->update();
                    }
                    if ($d2) {
                        $d2->club = $club;
                        $d2->update();
                    }
                }

                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', "Ошибка в форме!");
                return $this->render('create', [
                    'in' => $in,
                    'couple' => $couple,
                ]);
            }
        } else {
            return $this->render('create', [
                'in' => $in,
                'couple' => $couple,
            ]);
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
