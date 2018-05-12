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
    <h4>Отделения</h4>
   
    <?php     
        foreach ($otd_list as $otd) {
            echo Html::a($otd->name, ['index', 'otd_id'=>$otd->id], ['class' => $otd_id==$otd->id ? 'active btn':'btn']);
        }
    ?>
     <?= Html::a('Регистрация', ['/registration/create'], ['class'=>'btn btn-success'])?>
    
    
    <?php \yii\widgets\Pjax::begin()?>

    
    <?=
        $this->render('_tab', 
            [
                'dataProvider' =>  $dataProvider,
                'searchModel' => $searchModel,
                'otd_id' => $otd_id,
                'class_list' => $class_list,
            ]
        );
    ?>
    
    <?php \yii\widgets\Pjax::end()?>
              
</div>
