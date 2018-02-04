<?php
use yii\helpers\Html;

?>
<div class="left-panel">
    
    <?php 
        foreach ($categories as $category) {
            echo Html::a('<span> ('. app\models\Category::getCatRegPairs($category->id).') </span>'.$category->name, ['index', 'category_id'=>$category['id'], 'otd_id' =>$otd_id], ['class' => 'btn']);  
        }    
        echo Html::a('Показать все', ['index', 'category_id'=>null, 'otd_id' =>$otd_id], ['class' => 'btn']);
    ?>
    
</div>



