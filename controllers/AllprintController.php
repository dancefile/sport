<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;


class AllprintController extends \yii\web\Controller
{
	public $defaultAction = 'index';
	
        
        
	
	public function actionIndex() //отбражаем заходы тура
	{
            

            $this->enableCsrfValidation = false;
            $id='';
            $post=Yii::$app->request->post();
            foreach ($post as $name=>$value)
            {  
                if (substr($name, 0,3)=='tur') {$id.= substr($name, 3).',';}
                
            }  http://sport/
if (isset($post['zahod'])) return $this->redirect('heats?ved=1&idT='.substr($id,0,-1));
if (isset($post['begun'])) return $this->redirect('print/list?idT='.substr($id,0,-1));
if (isset($post['newheat'])) return $this->redirect('heats/new?idT='.substr($id,0,-1));

            
	}//actionIndex
	
	
	
}