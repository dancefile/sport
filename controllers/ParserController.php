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
                }   
            }

            return $this->render('index');
        } else {
            return $this->render('index');
        }
    }
}

?>