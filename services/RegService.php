<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegService
 *
 * @author Михаилус
 */
class RegService {
    static function regCreate($model)
    {
        if (array_filter($model->turSolo_M)) {
            $d1 = $this->dancerSave($model, 1);
            
            $couple = new Couple();
            $couple->dancer_id_1 = $d1->id;
            $couple->dancer_id_2 = NULL;
            $couple->save();
            $this->inSave($in->turSolo_M, $couple->id);
        }

        if (array_filter($in->turSolo_W)) {
            if ($d2 = $this->dancerSave($in->dancer2, 0)) {
                $couple = new Couple();
                $couple->dancer_id_2 = $d2->id;
                $couple->dancer_id_1 = NULL;
                $couple->save();
                $this->inSave($in->turSolo_W, $couple->id);
            } else {
                Yii::$app->session->setFlash('error', "Укажите данные танцора W!");
    //                    return $this->redirect(['create']);
            }
        }

                if (array_filter($in->turPair)) {           // Проверяем наличие регистраций в парах
                    if (isset($d1) && isset($d2)) {                       // и наличие двух танцоров
                        $couple = new Couple();
                        $couple->dancer_id_2 = $d2->id;
                        $couple->dancer_id_1 = $d1->id;
                        $couple->save();
                        $this->inSave($in->turPair, $couple->id);
                    } else {
                        $d1 = $this->dancerSave($in->dancer1, 1);
                        $d2 = $this->dancerSave($in->dancer2, 0);
                        if ($d1 && $d2) {
                            $couple = new Couple();
                            $couple->dancer_id_1 = $d1->id;
                            $couple->dancer_id_2 = $d2->id;
                            $couple->save();
                            $this->inSave($in->turPair, $couple->id);
                        } else {
                            Yii::$app->session->setFlash('error', "Укажите второго танцора!");
    //                        return $this->redirect(['create']);
                        }   
                    }
                }
                if (isset($in->dancer_trener)) {
                    foreach ($in->dancer_trener as $t) {
                        if ($t['sname'] || $t['name']) {
                            $trener = new Trener();
                            $trener->sname = $t['sname'];
                            $trener->name = $t['name'];
                            $trener->save();
                            $dt = new \app\models\DancerTrener;
                            $dt->trener_id = $trener->id;
                            $dt->dancer_id = $d1->id;
                            $dt->save();
                            $dt = new \app\models\DancerTrener;
                            $dt->trener_id = $trener->id;
                            $dt->dancer_id = $d2->id;
                            $dt->save(); 
                        }
                    }
                }
                $country = $this->countrySave($in->common['country']);

                if ($country) {
                    $city = $this->citySave($in->common['city'], $country);
                } else {
                    $city = $this->citySave($in->common['city'], NULL);
                }

                if ($city) {
                    $club = $this->clubSave($in->common['club'], $city);
                } else {
                    $club = $this->clubSave($in->common['club'], NULL);
                }

                if ($club) {
                    if ($d1) {
                        $d1->club = $club;
                        $d1->update();
                    }
                    if ($d2) {
                        $d2->club = $club;
                        $d2->update();
                    }
                }
    }
}
