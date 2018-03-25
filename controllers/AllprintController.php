<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;


class AllprintController extends \yii\web\Controller
{
	public $defaultAction = 'index';
	
        
        
	
	public function actionIndex() //отбражаем заходы тура
	{
            

            $post=Yii::$app->request->post();
            if (isset($post['selection'])) {
if (isset($post['zahod'])) return $this->redirect('/heats?ved=1&idT='.implode(",", $post['selection']));
if (isset($post['begun'])) return $this->redirect('/print/list?idT='.implode(",", $post['selection']));
if (isset($post['newheat'])) return $this->redirect('/heats/new?idT='.implode(",", $post['selection']));

            }        
	}//actionIndex
	
	
	
}