<?php

namespace tests\backend\unit;

use yii\base\BaseObject;
use yii\web\IdentityInterface;

class TestLoginIdentity extends BaseObject implements IdentityInterface
{
    public ?string $touchedAttribute = null;
    public ?bool $lastSaveRunValidation = null;

    public function touch($attribute)
    {
        $this->touchedAttribute = $attribute;
    }

    public function save($runValidation = true, $attributeNames = null): bool
    {
        $this->lastSaveRunValidation = (bool) $runValidation;

        return true;
    }

    public static function findIdentity($id)
    {
        return null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return null;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }
}
