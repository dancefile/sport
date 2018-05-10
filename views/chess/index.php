<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;
   

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chesses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chess-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <h4>Отделения</h4>
    
    <?php     
        foreach ($otd_list as $otd) {
            if ($otd_id == $otd->id){
                $active = TRUE;
            } else {
                $active = FALSE;
            }
            $items[] =  [
                            'label'     =>  $otd->name,
                            'content'   =>  $this->render('_tab', 
                                                [
                                                    'dataProvider' =>  $dataProvider,
                                                    'searchModel' => $searchModel,
                                                    'otd_id' => $otd->id,
                                                ]
                                            ),
                            'active'    =>  $active,
                        ];
        }
    ?>
    
    
    
    <?php \yii\widgets\Pjax::begin()?>

    
    <?=
        Tabs::widget([
            'items' => $items,
        ]);
    ?>
    
    <?php \yii\widgets\Pjax::end()?>
    
    <?php $form = ActiveForm::begin(['action' => ['save-chess'],'options' => ['method' => 'post']]); ?>
    <?php $this->registerJs(
            "$('input[type=checkbox]').click(function(){
                var keys = [];
                $('input[type=checkbox]:checked').each(function(){keys.push($(this).val());});
                $('#keys').val(keys);
            });"      
    );?>

    <div class="form-group">
        <input id="keys" type="hidden" name="keys" value="" />       
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>  
<?php $form = ActiveForm::end() ?>
              
</div>
