<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;


class TestController extends \yii\web\Controller
{
    public $defaultAction = 'index';
	
    public function actionIndex() 
    {
$key = 'идентификатор магазина';
$secret = 'секретный ключ';
// PSR-совместимый логгер (опциональный параметр)
$logger = null;
$client = new \app\komtet\kassasdk\client($key, $secret, $logger);
$manager = new QueueManager($client);
    }	
}        