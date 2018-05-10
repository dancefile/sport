<?php

namespace app\controllers;

use Yii;
use app\models\Chess;
use app\models\ChessSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ChessController implements the CRUD actions for Chess model.
 */
class ChessController extends Controller
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
     * Lists all Chess models.
     * @return mixed
     */
    public function actionIndex($category_id=null, $otd_id=null)
    {
        $searchModel = new ChessSearch();
        $otd_list = \app\models\Otd::find()->all();
        
        $searchModel->otd_id = $otd_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        
        return $this->render('index', 
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'otd_list' =>$otd_list,
                'otd_id' => $otd_id,
            ]
        );
    }

    /**
     * Displays a single Chess model.
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
     * Creates a new Chess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Chess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Chess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Chess model.
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
    
    public function actionSaveChess() {
        $keys_name = [
            0 => 'judge_id',
            1 => 'category_id',
            2 => 'nomer',
            3 => 'chief',
        ];
        
        $keys = explode(',', Yii::$app->request->post('keys'));
        if (count($keys)>1){
            $new_chess = [];
            foreach ($keys as $key) {
                $new_chess[] = array_combine($keys_name, explode('_',$key));
            }

            $old_chess = Chess::find()->all();

            foreach ($new_chess as $new_item) {        
                $save_success = FALSE;
                if ($new_item['nomer'] === '0'){
                    $max_number = Chess::find()->where(['category_id' => $new_item['category_id']])->max('nomer');
                    $new_item['nomer'] = $max_number +1;
                }
                foreach ($old_chess as $old_item) {
                    if (($new_item['judge_id']===$old_item->judge_id) && 
                        ($new_item['category_id']===$old_item->category_id)){
                           $chess_item->attributes = $new_item;
                           $chess_item->save();
                           $save_success = TRUE;
                           unset($old_chess[$old_item]);
                           break;
                    }
                }
                if (!$save_success){
                    $new_chess = new Chess();
                    $new_chess->attributes = $new_item;
                    $new_chess->save();
                }
            }
            Chess::deleteAll(['id' => ArrayHelper::map($old_chess,'id','id')]);
        }
        return $this->redirect('index');
    }

    /**
     * Finds the Chess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chess::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
