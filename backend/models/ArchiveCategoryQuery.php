<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ArchiveCategory]].
 *
 * @see ArchiveCategory
 */
class ArchiveCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ArchiveCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ArchiveCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
