<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Tur;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1 id="caption"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    
    
    

    
     
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
    //        'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'category',
                    'value' => function ($model){
                        return $model->category->name;
                    }
                ],
                'name',
                [
                    'attribute' => 'pair_count',
                    'value' => function ($model){
                        return count($model->ins);
                    }
                ],


                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);    
    ?>





