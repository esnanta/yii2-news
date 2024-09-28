<?php
namespace common\service;

use common\helper\MediaTypeHelper;
use common\models\OfficeMedia;

class OfficeMediaService
{
    public function getSiteLinks(int $limit = 6): array
    {
        return OfficeMedia::find()->limit($limit)
            ->where(['media_type'=>MediaTypeHelper::getLink()])
            ->orderBy(['id'=>SORT_ASC])->all();
    }
}
