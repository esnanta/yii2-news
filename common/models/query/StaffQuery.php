<?php

namespace common\models\query;

use common\models\Staff;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [Staff].
 *
 * @see Staff
 */
class StaffQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @return array|Staff[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @return null|ActiveRecord|array
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
