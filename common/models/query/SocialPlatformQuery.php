<?php

namespace common\models\query;

use common\models\SocialPlatform;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [SocialPlatform].
 *
 * @see SocialPlatform
 */
class SocialPlatformQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SocialPlatform[]|array
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
