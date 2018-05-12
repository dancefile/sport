<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use app\models\TimetableSearch;

//$this->title = 'Расписание отделения № 1';
//$this->params['breadcrumbs'][] = $this->title;
?>




<?php $this->registerJs(
   " $('#w5 li a').click(function(){
        $('#caption').html('Расписание отделения № '+$(this).html().slice(10));
    });"
);
?>

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
        $dataProvider->pagination = false;

        $tabs[]=[
            'label'     =>  $otd['name'],
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