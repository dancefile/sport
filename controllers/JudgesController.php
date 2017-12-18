<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;


class JudgesController extends \yii\web\Controller
{
	public $defaultAction = 'list';

	public function actionList()
	{
	 		
		return $this->render('list', ['message' => '<pre></pre>']);
}}