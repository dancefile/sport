<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Judge]].
 *
 * @see Judge
 */
class JudgeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Judge[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Judge|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
