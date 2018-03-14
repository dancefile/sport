<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Volod\TurInfo;
use kartik\grid\EditableColumnAction;

class KpkController extends \yii\web\Controller
{
    public $defaultAction = 'index';
	
    public function actionIndex() 
    {
        $kpk = new \app\models\Volod\kpk;
        return $this->renderPartial('json', [
            'arr' => $kpk->getArray(),
        ]);
    }	
}        