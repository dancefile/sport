<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use app\models\TimetableSearch;

//$this->registerJsFile('@web/js/jquery-ui.min.js',
//    ['depends' => [\yii\web\JqueryAsset::className()]]
//);
//$this->registerJsFile('@web/js/main.js',
//    ['depends' => [\yii\web\JqueryAsset::className()]]
//);
//$this->registerCssFile('@web/css/jquery-ui.css');

/* @var $this yii\web\View */
/* @var $searchModel app\models\TimetableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Timetables';
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= Html::encode($this->title) ?></h1>

<?php
    $otds = \app\models\Otd::find()->all();
    $searchModel = new TimetableSearch();
    $tabs=[];
    foreach ($otds as $otd) {
        $searchModel->otd_id =$otd['id'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $tabs[]=[
            'label'     =>  'Отделение '.$otd['name'],
            'content'   =>  $this->render(
                '_tab', 
                [
                    'dataProvider' =>  $dataProvider,
                    'otd_id' => $otd['id'],
                    'otd_name' => $otd['name'],
                ]
            ),
//          'active' => $active,
        ];
    }


    echo Tabs::widget([
        'items' => $tabs
    ]);
?>