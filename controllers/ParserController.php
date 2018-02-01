<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\services\CustomFunction;

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
            $site_url = 'http://www.danceleague.ru/db.php?id=e18073,c';
            
            $result = CustomFunction::getReglament($site_url);
            
            $result = CustomFunction::getRegistration($result, $site_url);
            
            foreach ($result as $i=>$section) {
                $otd = new \app\models\Otd;
                $otd->name = strval($i+1).'.0';
                $otd->full_name = strval($i+1).'.0';
                $otd->save();
                
                foreach ($section['sub_otd'] as $y=>$sub) {
                    $otd = new \app\models\Otd;
                    $otd->name = strval($i+1).'.'.strval($y+1);
                    $otd->full_name = $sub['name'];
                    $otd->startTime = $sub['start'];
                    $otd->save();
                    $otd_id = $otd->id;
                    
                    foreach ($sub['category'] as $cat) {
                        $category = new \app\models\Category();
                        $category->name = $cat['name'];
                        $category->otd_id = $otd_id;
                        $category->solo = $cat['solo'];
                        $category->save();
                        $category_id = $category->id;
                        
                        $tur = new \app\models\Tur();
                        $tur->name = '1';
                        $tur->nomer = 1;
                        $tur->category_id = $category_id;
                        $tur->save();
                        $tur_id = $tur->id;
                        if (isset($cat['in'])){
                            foreach ($cat['in'] as $in) {
                                $reg = new \app\models\PreRegistration();
                                $reg->tur_id = $tur_id;
                                $reg->class = $in['class'];
                                $reg->dancer1_name = $in['dancer1_name'];
                                $reg->dancer1_sname = $in['dancer1_sname'];
                                $reg->dancer2_name = $in['dancer2_name'];
                                $reg->dancer2_sname = $in['dancer2_sname'];
                                $reg->country = $in['country'];
                                $reg->city = $in['city'];
                                $reg->club = $in['club'];
                                $reg->trener_name = $in['trener_name'];
                                $reg->trener_sname = $in['trener_sname']; 
                                $reg->save();
                            }
                        }
                    }
                }   
            }

            return $this->render('index');
        } else {
            return $this->render('index');
        }
    }
}

?>