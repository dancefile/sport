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


use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;


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
    public function actionIndex()
    {
        $searchModel = new InSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $dataProvider = new ActiveDataProvider([
        //     'query' => In::find(),
        // ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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
        // $regNumberType = Setings::
        
        $query = Tur::find()
            ->joinWith('category')
            ->select(['tur.id', 'tur.nomer', 'tur.category_id', 'category.otd_id'])
            ->groupBy('tur.category_id')
            ->where(min(['tur.nomer']))
            ->orderBy(['category.otd_id' => SORT_ASC, 'tur.category_id' => SORT_ASC]);

        $turDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        

        if ($in->load(Yii::$app->request->post()) ) 
        {   
            

            if (!$in->dancer1['sname'] && !$in->dancer2['sname']){
                Yii::$app->session->setFlash('error', "Укажите хотя бы одного танцора!");
                return $this->redirect(['create']);
            }
            
            $turList = Yii::$app->request->post('selection');
            if (!$turList){
                Yii::$app->session->setFlash('error', "Укажите хотя бы одну категорию!");
                return $this->redirect(['create']);
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

            $d1 = $this->dancerSave($in->dancer1);
            $d2 = $this->dancerSave($in->dancer2);

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
                   
            $couple->dancer_id_1 = $d1 ? $d1->id : NULL;
            $couple->dancer_id_2 = $d2 ? $d2->id : NULL;
            $couple->save();
            
            
            foreach ($turList as $t) {
                $in = new In();
                // $number = In::find()->max('nomer');
                $in->couple_id = $couple->id;
                $in->nomer = '55';
                $in->tur_id = $t;
                $in->save();
            }
  
            return $this->redirect(['index']);

        } else {
            return $this->render('create', [
                'in' => $in,
                'couple' => $couple,
                'dataProvider' => $turDataProvider,

            ]);
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

    private function dancerSave($dancer)
    {
        if ($dancer['sname']) {
            $d = new Dancer;
            $d->attributes = $dancer;
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

        $query = Tur::find()
            ->joinWith('category')
            ->select(['tur.id', 'tur.nomer', 'tur.category_id', 'category.otd_id'])
            ->groupBy('tur.category_id')
            ->where(min(['tur.nomer']))
            ->orderBy(['category.otd_id' => SORT_ASC, 'tur.category_id' => SORT_ASC]);

        $turDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($in->load(Yii::$app->request->post()) && $in->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'in' => $in,
                'dataProvider' => $turDataProvider,
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
