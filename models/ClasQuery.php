<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Clas]].
 *
 * @see Clas
 */
class ClasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Clas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Clas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
