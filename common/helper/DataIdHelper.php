<?php

namespace common\helper;

use common\service\CacheService;

class DataIdHelper
{
    public static function getOfficeId(){
        return CacheService::getInstance()->getOfficeId();
    }
}