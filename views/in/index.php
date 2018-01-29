<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;


$this->registerJsFile('@web/js/jquery-ui.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile('@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerCssFile('@web/css/jquery-ui.css');


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список участников';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="in-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php   
        $tabs=[];
        $categories = \app\models\In::getCategories('');
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
            $searchModel->category_id =$category_id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination = false;
            $tabs[]=[
                'label'     =>  'Отделение '.$otd['name'],
                'content'   =>  $this->render(
                                    '_tab', 
                                    [
                                        'dataProvider' =>  $dataProvider,
                                        'searchModel' => $searchModel,
                                        'otd_id' => $otd['id'],
                                        'category_id' => $category_id,
                                        'categories' => $categories,
                                    ]
                                ),
                'active' => $active,
            ];
        }

        echo Tabs::widget([
            'items' => $tabs
        ]);
    ?>           
</div>
