<?php
    use yii\grid\GridView;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
?>


<?php
    $j = app\models\Judge::find()->all();
    
    $columns = ['full_name'];
    $categories = app\models\Category::find()->where(['otd_id' => $otd_id])->all();
    foreach ($categories as $category):
        $columns[] = [
            'header' => '<div  class="vertical-text">' . $category->name . '</div>',
            'options' => ['class' => 'vertical-text'],
            'class' => 'yii\grid\CheckboxColumn',
            'checkboxOptions' => function($model) use ($category){
                                    return [
                                        'checked' => $model[$category->id],
                                        'value' =>  $model['judge_id'].'_'
                                                    .$category->id.'_'
                                                    .$model[$category->id].'_'
                                                    .$model['c'.$category->id],
                                    ];
                                },
        ];
    endforeach;
?>

<?= GridView::widget([
        'id' => 'chess_tab',
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]); 
?>




