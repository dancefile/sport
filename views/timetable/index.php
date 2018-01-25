<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use app\models\TimetableSearch;

$this->title = 'Расписание';
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= Html::encode($this->title) ?></h1>

<?php
    $otds = \app\models\Otd::find()->all();
    $searchModel = new TimetableSearch();
    $tabs=[];
    foreach ($otds as $otd) {
        if (isset($otd_id)){
            if($otd_id==$otd['id']){
                $active = true;
            } else {
                $active = false;
            }
        } else {
            $active = null;
        }
        
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
            'active' => $active,
        ];
    }


    echo Tabs::widget([
        'items' => $tabs
    ]);
?>