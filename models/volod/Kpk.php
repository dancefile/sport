<?php 
namespace app\models\volod;
/* модель kpk - вывод и сохранения данных при обмене с кпк
 * Автор: Volod, vladimir.kupriyanov@gmail.com
 * 
 * Методы:
 * getArray() вывод массива информации по турам со статусом  
 * 
 */
use yii\base\Model;

class kpk extends Model
{

    public function getArray() {

	$tur = (new \yii\db\Query()) 
            ->select(['tur.category_id','turname'=>'tur.name', 'tur.dances', 'tur.id' ,'tur.ParNextTur','tur.nomer','category.name','tur.typeSkating'])
	    ->from('tur')
            ->innerJoin('category','tur.category_id=category.id')
            ->where(['tur.status'=>'1']);
        $allDance=[];
        $judgesArr=[];
	foreach ($tur->each() as $turRow) {
            $dancesArr = explode(',',str_replace(' ','',$turRow['dances']));
            foreach (array_diff ($dancesArr, $allDance) as $dance)//сохраняем все id танцев
            {
               $allDance[]=$dance;
            }
            $arr['kat'][$turRow['id']]['dances']=implode(',',$dancesArr);
            $arr['kat'][$turRow['id']]['namet']=$turRow['turname'];
            $arr['kat'][$turRow['id']]['namek']=$turRow['name'];
            $arr['kat'][$turRow['id']]['Type']=$turRow['typeSkating'];
            $str='';
            if (!$turRow['ParNextTur']) $turRow['ParNextTur']='6';
            for ($i=0;$i<count($dancesArr);$i++){$str.=$turRow['ParNextTur'].',';}
            $str=substr($str, 0, -1);
            $arr['kat'][$turRow['id']]['ParNextTur'] = $str; 
            
            $inArr=[];
            $in = (new \yii\db\Query()) //получаем список пар  за текущей тур
                ->select(['id','nomer'])
    		->from('in')
    		->where(['tur_id' => $turRow['id']]);	
            foreach ($in->each() as $rowIn) {
                $inArr[$rowIn['id']]=$rowIn['nomer'];	
            }
            
        $heatsArr=[];
        $heats = (new \yii\db\Query()) //получаем заходы для пар в текущем туре
                ->from('in_dance')
                ->where(['in', 'id_in',array_keys($inArr)]);
        // создаем массив $heatsArr[idтанца][номер пары]=заход
        foreach ($heats->each() as $rowHeat) {
            if ($rowHeat['dance_id'])
                $heatsArr[$rowHeat['dance_id']][$inArr[$rowHeat['id_in']]]=$rowHeat['zahod'];	
            else 
                foreach ($dancesArr as $value) {
                  $heatsArr[$value][$inArr[$rowHeat['id_in']]]=$rowHeat['zahod'];	  
                };
        }
        
         foreach ($heatsArr as $key => $value) {
             ksort($value);
             asort($value);
             $str='';
             foreach ($value as $nomer => $zahod) {
                $str.=$nomer.'-'.$zahod.';';    
             }
             $str=substr($str, 0, -1);
             $arr['kat'][$turRow['id']]['coupls'][$key]=$str;     	  
            };
        
            
            $judges = (new \yii\db\Query()) //получаем список судей данной категории
	    ->select(['judge_id','nomer'])
	    ->from('chess')
	    ->where(['category_id' => $turRow['id']]);
            foreach ($judges->each() as $row) {
                    if (isset($judgesArr[$row['judge_id']]['rounds']))
                        $judgesArr[$row['judge_id']]['rounds'].=$turRow['id'].'-'.$row['nomer'].',';
                    else $judgesArr[$row['judge_id']]['rounds']=$turRow['id'].'-'.$row['nomer'].',';
            }
            
        }

        foreach ($judgesArr as  &$value) {//удаляем лишнию запитую в конце строчки
            $value['rounds']=substr($value['rounds'], 0, -1);
        }
        
	$judges = (new \yii\db\Query()) //получаем список судей 
	    ->select(['id','name','sname'])
	    ->from('judge')
            ->where(['in', 'id',array_keys($judgesArr)]);
		foreach ($judges->each() as $row) {
                    $judgesArr[$row['id']]['name']=$row['sname'].' '.$row['name'];
                    $judgesArr[$row['id']]['lang']='R';
		}
        $arr['j']=$judgesArr;
        
        
        $dances = (new \yii\db\Query()) //получаем список танцев 
	    ->select(['id','name'])
	    ->from('dance')
            ->where(['in', 'id',$allDance]);
	foreach ($dances->each() as $row) {
            $arr['d'][$row['id']]=$row['name'];
		}
        
        
        
        /*
                $row1['id']=1;
                
        $arr['kat'][$row1['id']]['dances']='8,2';
	$arr['kat'][$row1['id']]['namet']='tur1';
	$arr['kat'][$row1['id']]['namek']='kat1';
	$arr['kat'][$row1['id']]['Type']='3';
	$arr['kat'][$row1['id']]['ParNextTur']='6,3';
        $arr['kat'][$row1['id']]['coupls']=["8"=>"81-1;91-1;329-1;335-1;387-1;129-2;135-2;181-2;187-2;191-2","2"=>"81-1;91-1;329-1;335-1;387-1"];
        
        
        $arr['j']['4']['name']='J1';
	$arr['j']['4']['lang']='R';
        $arr['j']['4']['rounds']='1-1';
        
        $arr['j']['5']['name']='J1';
	$arr['j']['5']['lang']='R';
        $arr['j']['5']['rounds']='1-2';
        
        $arr['d']['2']='T';
        $arr['d']['8']='W';

        $arr['ver']='6';
         * 
         * 
         */
                $arr['ver']='7';
    return $arr;
    }
    
}

