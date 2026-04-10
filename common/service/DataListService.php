<?php

namespace common\service;

use common\models\Document;
use common\models\Employment;
use common\models\Office;
use common\models\Page;
use common\models\Staff;
use yii\helpers\ArrayHelper;

class DataListService
{
    public static function getOffice(): array
    {
        return ArrayHelper::map(Office::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getDocument(): array
    {
        return ArrayHelper::map(Document::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getEmployment(): array
    {
        return ArrayHelper::map(Employment::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getStaff(): array
    {
        return ArrayHelper::map(Staff::find()
            ->asArray()->all(), 'id', 'title');
    }

    public static function getPage(): array
    {
        return ArrayHelper::map(Page::find()
            ->asArray()->all(), 'id', 'title');
    }
}
