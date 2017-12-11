<?php

namespace app\controllers;

use yii\web\Controller;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class AppController extends Controller{

}

function debug($arr){
	echo '<pre>' . print_r($arr, true) . '</pre>';
}