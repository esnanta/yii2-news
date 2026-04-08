<?php

namespace common\models\query;

use common\models\Office;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [Office].
 *
 * @see Office
 */
class OfficeQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Office[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return array|ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
