<?php
use yii\helpers\Html;

?>
<div class="left-panel">
    <?php 
    
        $cat = array_filter($categories, function($item) use ($otd_id){
            return $item['otd_id']==$otd_id;
        });
        
        foreach ($cat as $category) {
            echo Html::a($category->name, ['index', 'category_id'=>$category['id']], ['class' => 'btn']);  
        }   
        echo Html::a('Показать все', ['index', 'category_id'=>null, 'otd_id' =>$otd_id], ['class' => 'btn']);
    ?>
    
</div>



