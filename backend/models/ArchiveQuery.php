<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Archive]].
 *
 * @see Archive
 */
class ArchiveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Archive[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Archive|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
