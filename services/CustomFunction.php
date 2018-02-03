<?php
namespace app\services;

//use yii\helpers\Html;
//use yii\helpers\Url;


class CustomFunction
{
    public function mb_ucfirst($text) {
        mb_internal_encoding("UTF-8");
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }
    
    
    public function sexByName($text) {
        $male_sn = ['ых', 'ов', 'ев', 'ёв', 'ин'];
        $male_n = ['им', 'ир', 'ий', 'ён', 'ен', 'ей', 'др', 'еб', 'ан', 'ор', 'ис', 'тр', 'ел', 'ян', 'ья'];
        $fem_sn = ['на', 'ва', 'ая', 'ия'];
        $fem_n = ['ья', 'на', 'ия', 'ра', 'ва', 'га', 'да', 'та'];
        $name_exceptions = ['дарья'];
        
        $arr = self::wordsSeparate($text);
        $name_substr = mb_substr(trim($arr['name']), -2);
        $sname_substr = mb_substr(trim($arr['sname']), -2);
        
        if (in_array($name_substr, $male_n, TRUE) && !in_array($sname_substr, $fem_sn, TRUE)){
            return ['sname'=>$arr['sname'], 'name' => $arr['name'], 'sex' => 'm'];
        } else {
            return ['sname'=>$arr['sname'], 'name' => $arr['name'], 'sex' => 'f'];
        }
    }
    
    
    public function wordsSeparate($text) {
        $arr = explode(' ', $text, 2);
       
        if (!isset($arr[1])){
            $arr[1] = '';
        }
        return ['sname'=>$arr[0], 'name' => $arr[1]];
    }
    
    public function getReglament($site_url) {
        require_once "..\components\simple_html_dom.php";       // подгружаем компонент для работы с DOM
        $url = $site_url;
        $page = file_get_html($url);
        $tr = $page->find('td.MainPane table tr');
        if (count($tr)){
            $otd_i=-1;
            foreach ($tr as $row) {
                if ($otd=$row->find('span.separatorB',0)){
                    $otd_i++;
                    $result[$otd_i]['otd']= self::mb_ucfirst(trim($otd->plaintext));
                    $sub_otd_i=-1;
                }
                if ($otd=$row->find('span.separatorC',0)){
                    $sub_otd_i++;
                    $result[$otd_i]['sub_otd'][$sub_otd_i]['name']= self::mb_ucfirst(trim($otd->plaintext));
                    $result[$otd_i]['sub_otd'][$sub_otd_i]['start']=substr(trim($otd->plaintext),-1)=='0'?substr(trim($otd->plaintext),-5).':00':'';
                }
                if ($otd=$row->find('a',0)){
                    $result[$otd_i]['sub_otd'][$sub_otd_i]['category'][substr(trim($otd->href),-5)]['name']=self::mb_ucfirst(trim($otd->plaintext));
                    if (stristr($otd->plaintext, 'соло')|| stristr($otd->plaintext, 'Соло')){
                        $solo=0;
                    } else {
                        $solo=1;
                    }
                    $result[$otd_i]['sub_otd'][$sub_otd_i]['category'][substr(trim($otd->href),-5)]['solo']=$solo; 
                    
                }
            }
        }
        $page->clear();
        return $result;
    }
    
    public function getRegistration($result, $site_url) 
    {
        foreach ($result as &$otdd) {       //  разбираем полученный массив с категориями т дополняем инфой о регистрациях
            foreach ($otdd['sub_otd'] as &$sub) {
                foreach ($sub['category'] as $idx => &$cat) {
                    $url = $site_url.$idx;     // $idx  - окончание ссылки, оно же id массива категорий
                    $html = file_get_html($url);
                    if (count($html->find('p tr'))>1){
                        if ($html->find('p tr',0)->find('td',2)->plaintext=='город'){   // некоторые таблицы имеют разные колонки
                            $city = true; 
                        } else {
                            $city = false;
                        }
                        foreach($html->find('p tr') as $key_tr => $tr){                            
                            if ($key_tr != 0){
                                if (count($tr->find('td')) == 6){      // проверяем размер таблицы (соло - 6 колонок, пары -8)
                                    foreach ($tr->find('td') as $key_td=>$td) {     // записывает в массив
                                        $cat['in'][$key_tr-1]['class'] = '';        
                                        if ($city){
                                            switch ($key_td){
                                                case 1:
                                                    if ($td->plaintext){
                                                        $arr = self::sexByName($td->plaintext);       //  функция разбивает фразу на два слова и вычисляет пол
                                                    }   
                                                    if ($arr['sex'] == 'm'){
                                                        $cat['in'][$key_tr-1]['dancer1_name'] = $arr['name'];
                                                        $cat['in'][$key_tr-1]['dancer1_sname'] = $arr['sname'];
                                                        $cat['in'][$key_tr-1]['dancer2_name'] = '';
                                                        $cat['in'][$key_tr-1]['dancer2_sname'] = '';
                                                    } else {
                                                        $cat['in'][$key_tr-1]['dancer1_name'] = '';
                                                        $cat['in'][$key_tr-1]['dancer1_sname'] = '';
                                                        $cat['in'][$key_tr-1]['dancer2_name'] = $arr['name'];
                                                        $cat['in'][$key_tr-1]['dancer2_sname'] = $arr['sname'];
                                                    }
                                                    break;
                                                case 2:
                                                    $cat['in'][$key_tr-1]['country'] ='';
                                                    $cat['in'][$key_tr-1]['city'] = $td->plaintext;
                                                    break;
                                                case 3:
                                                    $cat['in'][$key_tr-1]['club'] = $td->plaintext;
                                                    break;    
                                                case 5:
                                                    if ($td->plaintext){
                                                        $arr = self::wordsSeparate($td->plaintext);
                                                    }
                                                    $cat['in'][$key_tr-1]['trener_name'] = $arr['name'];
                                                    $cat['in'][$key_tr-1]['trener_sname'] = $arr['sname'];
                                                    break;      
                                            }
                                        } else {
                                            switch ($key_td){
                                                case 1:
                                                    if ($td->plaintext){
                                                        $arr = self::sexByName($td->plaintext);
                                                    }
                                                    if ($arr['sex'] == 'm'){
                                                        $cat['in'][$key_tr-1]['dancer1_name'] = $arr['name'];
                                                        $cat['in'][$key_tr-1]['dancer1_sname'] = $arr['sname'];
                                                        $cat['in'][$key_tr-1]['dancer2_name'] = '';
                                                        $cat['in'][$key_tr-1]['dancer2_sname'] = '';
                                                    } else {
                                                        $cat['in'][$key_tr-1]['dancer1_name'] = '';
                                                        $cat['in'][$key_tr-1]['dancer1_sname'] = '';
                                                        $cat['in'][$key_tr-1]['dancer2_name'] = $arr['name'];
                                                        $cat['in'][$key_tr-1]['dancer2_sname'] = $arr['sname'];
                                                    }
                                                    break;
                                                case 2:
                                                    $cat['in'][$key_tr-1]['country'] = $td->plaintext;
                                                    break;
                                                case 3:
                                                    $cat['in'][$key_tr-1]['city'] = $td->plaintext;
                                                    break;
                                                case 4:
                                                    $cat['in'][$key_tr-1]['club'] = $td->plaintext;
                                                    break;    
                                                case 5:
                                                    if ($td->plaintext){
                                                        $arr = self::wordsSeparate($td->plaintext);
                                                    }
                                                    $cat['in'][$key_tr-1]['trener_name'] = $arr['name'];
                                                    $cat['in'][$key_tr-1]['trener_sname'] = $arr['sname'];
                                                    break;      
                                            }
                                        }
                                    }      
                                } elseif (count($tr->find('td')) == 8){      // проверяем размер таблицы (соло - 6 колонок, пары -8)
                                    foreach ($tr->find('td') as $key_td=>$td) {     // записывает в массив
                                        switch ($key_td){
                                            case 1:
                                                $cat['in'][$key_tr-1]['country'] ='';
                                                $cat['in'][$key_tr-1]['class'] = $td->plaintext;
                                                break;
                                            case 2:
                                                if ($td->plaintext){
                                                    $arr = self::wordsSeparate($td->plaintext);
                                                }
                                                $cat['in'][$key_tr-1]['dancer1_name'] = $arr['name'];
                                                $cat['in'][$key_tr-1]['dancer1_sname'] = $arr['sname'];
                                                break;
                                            case 3:
                                                if ($td->plaintext){
                                                    $arr = self::wordsSeparate($td->plaintext);
                                                }
                                                $cat['in'][$key_tr-1]['dancer2_name'] = $arr['name'];
                                                $cat['in'][$key_tr-1]['dancer2_sname'] = $arr['sname'];
                                                break;
                                            case 4:
                                                $cat['in'][$key_tr-1]['city'] = $td->plaintext;
                                                break;
                                            case 5:
                                                $cat['in'][$key_tr-1]['club'] = $td->plaintext;
                                                break;
                                            case 7:
                                                if ($td->plaintext){
                                                    $arr = self::wordsSeparate($td->plaintext);
                                                }
                                                $cat['in'][$key_tr-1]['trener_name'] = $arr['name'];
                                                $cat['in'][$key_tr-1]['trener_sname'] = $arr['sname'];
                                                break;      
                                        }
                                    } 
                                }
                            }
                        }
                    } 
                }
                unset($cat);
            }
            unset($sub);
        }
        unset($otdd);
        return $result;
    }
    
    
    public function arrayStrToImg($arr_str)
    {
        $paper = 570;
        $im = imagecreatetruecolor($paper, 1200);
        $black = imagecolorallocate($im, 0, 0, 0);
        $white = imagecolorallocate($im, 255, 255, 255);
        $font = 'fonts/arial.ttf';
        $y=0;
        imagefilledrectangle($im, 0, 0, $paper, 26182, $white);// установка белого фона

        foreach ($arr_str as $str){
            $bbox = imageftbbox($str['size'], 0, $font, $str['str']);
            $x =($paper-$bbox[2])/2;
            $y=$y+intval(($bbox[1]-$bbox[7])*1.3);
            imagefttext($im, $str['size'], 0, $x, $y, $black, $font, $str['str']);
            $y=$y+10;
        }
        
        imagejpeg($im,'tmp/1.jpg',100);
        imagedestroy($im);

       
       exec('C:\htdocs\sport\exe\print.exe C:\htdocs\sport\web\tmp\1.jpg "CITIZEN"');
    }

        

        



       



}
    

