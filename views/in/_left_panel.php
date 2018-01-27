<?php
use yii\helpers\Html;

?>
<div class="left-panel">
    <?php 
    
        $Categories = \app\models\In::getCategories($otd_id);
        foreach ($Categories as $category) {
            echo Html::a($category->name.'<span> ('. app\models\Category::getCatRegPairs($category->id).')</span>', ['index', 'category_id'=>$category['id']], ['class' => 'btn']);  
        }   
        echo Html::a('Показать все', ['index', 'category_id'=>null], ['class' => 'btn']);
    ?>
    
</div>



