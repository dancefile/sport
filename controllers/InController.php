<?php

namespace app\controllers;

use Yii;
use app\models\In;
use app\models\InSearch;
use app\models\Dancer;
use app\models\Couple;
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
        // $category_list = Category::find()->joinWith(['otd', 'turs'])
        $couple = new Couple();
        $number = In::find()->max('nomer');

        

       if ($in->load(Yii::$app->request->post()) ) 
       {    
            $dancer = new Dancer;
            $dancer->attributes = $in->dancer1;
            $dancer->save();
            
            $couple->dancer_id_1 = $dancer->id;

            $dancer = new Dancer;
            $dancer->attributes = $in->dancer2;
            $dancer->save();
            
            $couple->dancer_id_2 = $dancer->id;

            $couple->save();

            $in->couple_id = $couple->id;
            $in->nomer = ++$number;
            $in->tur_id = 7;
            $in->save();

            return $this->redirect(['index']);

        } else {
            return $this->render('create', [
                'in' => $in,
                'couple' => $couple,

            ]);
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

        if ($in->load(Yii::$app->request->post()) && $in->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'in' => $in,
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
