<?php

namespace common\models\query;

use common\models\StaffSocialAccount;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [StaffSocialAccount].
 *
 * @see StaffSocialAccount
 */
class StaffSocialAccountQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return StaffSocialAccount[]|array
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
