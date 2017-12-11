<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[InDance]].
 *
 * @see InDance
 */
class InDanceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return InDance[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InDance|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
