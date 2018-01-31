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
        if (Yii::$app->request->post()) {
            $start = Yii::$app->request->post('start');
            $end = Yii::$app->request->post('end');
            
            require_once "..\components\simple_html_dom.php";       // подгружаем компонент для работы с DOM
            $url = 'http://www.danceleague.ru/db.php?id=e18073,c';
            $page = file_get_html($url);
            $tr = $page->find('td.MainPane table tr');
            if (count($tr)){
                foreach ($tr as $row) {
                    $td = $row->find('td.dataCell');
                    
                    
                    $k=0;
                    foreach ($td as $cell) {
//                        if (!$cell->find('i',0) && trim($cell->plaintext)){
                            print_r($k);
//                            $result[$k] = ucfirst(trim($cell->plaintext));
//                        }
//                        if ($otd=$cell->find('span.separatorC',$key)){
//                            $sub_otd_id=$key;
//                            $result[$otd_id][$sub_otd_id]=$otd->plaintext;
//                        }
                        $k++;
                    }
                }
            }
            $page->clear();
            echo '<pre>', print_r($result), '</pre>';
            exit;
            
            
//            while($start <= $end){
//                $url = 'http://www.danceleague.ru/db.php?id=e18073,c'.$start;
//                $html = file_get_html($url);
//                
//                
//                
//                if (count($html->find('p tr'))>1){
//                    foreach($html->find('p tr') as $key_tr=>$tr){
//                        if ($key_tr!=0){
//                            if (count($tr->find('td'))<7){      // проверяем размер таблицы (соло - 5 колонок, пары -7)
//                                foreach ($tr->find('td') as $key_td=>$td) {
//                                    switch ($key_td){
//                                        case 0:
//                                            $category = $html->find('.dataCellRed.dottedRed');
//                                            echo '<pre>', print_r($category), '</pre>';
//                                            exit;
//                                            $result[$start][$key_tr]['category'] = $category->plaintext;       // записываем название категории
//                                            $result[$start][$key_tr]['class'] = $td->plaintext;
//                                            break;
//                                        case 1:
//                                            
//                                            $result[$start][$key_tr]['dancer1_name'] = $td->plaintext;
//                                            break;
//                                        case 2:
//                                            $result[$start][$key_tr]['City'] = $td->plaintext;
//                                            break;
//                                        case 3:
//                                            $result[$start][$key_tr]['club'] = $td->plaintext;
//                                            break;
//                                        case 4:
//                                            $result[$start][$key_tr]['trener'] = $td->plaintext;
//                                            break;      
//                                    }
//                                }       
//                            } else {
//                                
//                            }
//                            
//                        }
//                    }
//                } 
//                $start++;
//            }
//            echo '<pre>', print_r($result), '</pre>';
//            exit;
        } else {
            return $this->render('index');
        }
    }
}

?>