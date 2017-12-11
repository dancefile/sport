<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Dance]].
 *
 * @see Dance
 */
class DanceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Dance[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Dance|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
