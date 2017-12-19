<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\JudgeSearch;

class JudgesController extends \yii\web\Controller
{
	public $defaultAction = 'list';

	public function actionList()
	{
	 	
		        $searchModel = new JudgeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);	

}}