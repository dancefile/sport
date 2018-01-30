<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * Description of ParssingController
 *
 * @author Михаилус
 */
class ParserController extends Controller
{
    public function actionIndex()
    {
        include '..\components\simple_html_dom.php';
//        ini_set("memory_limit","30M");
        if (Yii::$app->request->post()) {
            $start = Yii::$app->request->post('start');
            $end = Yii::$app->request->post('end');
            
            while($start <= $end){
                $html = file_get_html('http://www.danceleague.ru/db.php?id=e18073,c'.$start); // загружаем данные
                if (count($html->find('.DbTableCell'))){
                    foreach($html->find('p') as $a){
                        $www = str_get_html($a);
                        $www->find('td');
                        echo $www;
                    }
                }
                $html->clear(); // подчищаем за собой
                unset($html);
                $start++;
            }
        } else {
            return $this->render('index');
        }

        
    }
    
    
    
}

?>