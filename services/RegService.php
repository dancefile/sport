<?php
namespace app\services;

use app\models\Dancer;
use app\models\Couple;
use app\models\Trener;
use app\models\City;
use app\models\Country;
use app\models\Club;
use app\models\In;
/**
 * Description of RegService
 *
 * @author Михаилус
 */
class RegService 
{
    public static function regSave($model, $update)
    {
        $ds = self::dancerSave($model, $update);
        $existInPairRecors = $model->turInPair($model->coupleId);
        $existInSoloRecors = $model->turInSolo($model->coupleId);
        
        if(!$update){
            $cp = self::coupleSave($ds[0], $ds[1]);
        } else {
            $cp = $model->coupleId;
        }
        
        if (array_filter($model->turSolo_M)) {
            self::inSave($model->turSolo_M, $cp, 1);
        }
        if ($update){
            self::deleteInSaveRecord($existInSoloRecors, $model->turSolo_M, 1);
        }
        
        if (array_filter($model->turSolo_W)) {
            self::inSave($model->turSolo_W, $cp, 2);
        }
        if ($update){
            self::deleteInSaveRecord($existInSoloRecors, $model->turSolo_W, 2);
        }

        if (array_filter($model->turPair)) {
            self::inSave($model->turPair, $cp, 3);
        }
        if ($update){
            self::deleteInSaveRecord($existInPairRecors, $model->turPair, 3);
        }
        
        if ($update){
            if ($ds[0]){
                $to_delete[] = $ds[0]->id;
            }
            if ($ds[1]){
                $to_delete[] = $ds[1]->id;
            }
            
            \app\models\DancerTrener::deleteAll(['dancer_id'=>$to_delete]);
        }
        
        for ($i=1; $i<=6; $i++) {
            $name = $model->{'d_trener'.$i.'_name'};
            $sname = $model->{'d_trener'.$i.'_sname'};
            if ($sname || $name) {
                $trener = new \app\models\Trener();
                $trener->sname = $sname;
                $trener->name = $name;
                $trener->save(false);
                
                if ($ds[0]){
                    $dt = new \app\models\DancerTrener();
                    $dt->trener_id = $trener->id;
                    $dt->dancer_id = $ds[0]->id;
                    $dt->save();
                }
                if ($ds[1]){
                    $dt = new \app\models\DancerTrener();
                    $dt->trener_id = $trener->id;
                    $dt->dancer_id = $ds[1]->id;
                    $dt->save();
                }
            }
        }
        
        $country = self::countrySave($model->country);

        if ($country) {
            $city = self::citySave($model->city, $country);
        } else {
            $city = self::citySave($model->city, NULL);
        }

        if ($city) {
            $club = self::clubSave($model->club, $city);
        } else {
            $club = self::clubSave($model->club, NULL);
        }

        if ($club) {
            if ($ds[0]) {
                $ds[0]->club = $club;
                $ds[0]->update();
            }
            if ($ds[1]) {
                $ds[1]->club = $club;
                $ds[1]->update();
            }
        }
    }

    private function countrySave($country)
    {
        if (!$country){
            return false;
        } elseif (is_numeric($country)) {
            return $country;
        } else {
            $c = new Country();
            $c->name = $country;
            $c->save();
            return $c->id;
        } 
    }

    private function citySave($city, $country)
    {   
        $c = new City();

        if (!$city){
            $c->name = NULL;
        } elseif (is_numeric($city)) {
            return $city;
        } else {
            $c->name = $city;
        } 
        $c->country_id = $country;
        $c->save();
        return $c->id;
    }

    private function clubSave($club, $city)
    {
        $c = new Club();

        if (!$club && !$city) {
            return NULL;
        } elseif (!$club) {
            $c->name = NULL;
        } elseif (is_numeric($club)) {
            return $club;
        } else { 
            $c->name = $club;
        }
        $c->city_id = $city;
        $c->save();
        return $c->id;
    }

    private function dancerSave($model, $update)
    {
        if ($model['d1_sname']) {
            if (!$update){
                $d1 = new Dancer;
            } else {
                $d1 = Dancer::findOne($model->d1_id);
            }
            $d1->sname = $model['d1_sname'];
            $d1->name = $model['d1_name'];
            $d1->date = $model['d1_date'];
            $d1->clas_id_st = $model['d1_class_st'];
            $d1->clas_id_la = $model['d1_class_la'];
            $d1->booknumber = $model['d1_booknumber'];
            $d1->gender = 1;
            $d1->save(false);
        } else {
            $d1 = NULL;
        }
        if ($model['d2_sname']) {
            if (!$update){
                $d2 = new Dancer;
            } else {
                $d2 = Dancer::findOne($model->d2_id);
            }
            $d2->sname = $model['d2_sname'];
            $d2->name = $model['d2_name'];
            $d2->date = $model['d2_date'];
            $d2->clas_id_st = $model['d2_class_st'];
            $d2->clas_id_la = $model['d2_class_la'];
            $d2->booknumber = $model['d2_booknumber'];
            $d2->gender = 0;
            $d2->save(false);
        } else {
            $d2 = NULL;
        }
        
        return [$d1, $d2];
    }
    
    private function coupleSave($d1, $d2)
    {
        $couple = new Couple;
        $couple->dancer_id_1 = $d1? $d1->id:NULL;
        $couple->dancer_id_2 = $d2? $d2->id:NULL;
        $couple->save(false);
        
        return $couple->id;
    }

    private function inSave($tur, $coupleId, $who)
    {
        foreach ($tur as $key => $value) {
            if ($value) {
                if ($i = In::find()->where(['couple_id' => $coupleId, 'tur_id'=> $key, 'who'=>$who])->one()){
                    $i->nomer = $value;
                } else {
                    $i = new In();
                    $i->couple_id = $coupleId;
                    $i->nomer = $value;
                    $i->who = $who;
                    $i->tur_id = $key;
                }
                $i->save(false);  
            } 
        }
    }
    
    private static function deleteInSaveRecord($existRecors, $newRecors, $who)
    {
        foreach ($newRecors as $tur => $nomer){
            foreach ($existRecors as $oldRecord) {
                if ($oldRecord['tur_id'] == $tur && !$nomer && $oldRecord['who'] == $who){
                    In::deleteAll(['id'=>$oldRecord['id']]);
                }
            }
        }
    } 
    
    
    
    
    
}
