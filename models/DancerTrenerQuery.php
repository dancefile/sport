<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DancerTrener]].
 *
 * @see DancerTrener
 */
class DancerTrenerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DancerTrener[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DancerTrener|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
