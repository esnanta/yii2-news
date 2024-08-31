<?php
namespace common\service;

use common\models\AuthAssignment;
use common\models\Office;
use common\models\Staff;
use Yii;
use yii\db\ActiveRecord;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//SINGLETON CLASS
class CacheService {

    private static ?CacheService $instance = null;
    private string $cacheOfficeId;
    private string $cacheOfficeTitle;
    private string $cacheOfficeUniqueId;
    private string $cacheStaffId;
    private string $cacheStaffTitle;
    private string $cacheAuthItemName;
    private string $combineCache;
    
    private string $userId;

    function __construct()
    {
        $this->userId               = 'null';
        $this->cacheOfficeId        = 'office_id';
        $this->cacheOfficeTitle     = 'office_title';
        $this->cacheOfficeUniqueId  = 'office_unique_id';
        $this->cacheStaffId         = 'staff_id';
        $this->cacheStaffTitle      = 'staff_title';
        $this->cacheAuthItemName    = 'auth_item_name';
        $this->combineCache         = 'null';

        if(!empty(Yii::$app->user->identity->id)):
            $this->userId               = Yii::$app->user->identity->id;
            $this->combineCache         = Yii::$app->user->identity->id.Yii::$app->user->identity->username;
        endif;
    }

    public static function getInstance(): ?CacheService
    {
        if (self::$instance === null) {
            self::$instance = new CacheService();
        }
        return self::$instance;
    }

    public function Flush(): void
    {
        Yii::$app->cache->flush();
        Yii::$app->getSession()->setFlash('success', [
            'message' => Yii::t('app', 'Cache Flushed'),
        ]);
    }

    private function getDefaultOffice(): array|ActiveRecord|null
    {
        return Office::find()->where(['id'=>1])->one();
    }

    public function getOfficeId(){
        return Yii::$app->cache->getOrSet($this->cacheOfficeId.$this->combineCache, function () {
            if($this->userId=='null'){
                return self::getDefaultOffice()->id;
            } else {
                $model = Staff::find()->where(['user_id' => $this->userId])->one();
                return $model->office_id;
            }

        });
    }

    public function getOfficeTitle(){
        return Yii::$app->cache->getOrSet($this->cacheOfficeTitle.$this->combineCache, function () {
            if($this->userId=='null'){
                return self::getDefaultOffice()->title;
            } else {
                $model = Staff::find()->where(['user_id' => $this->userId])->one();
                return $model->office->title;
            }
        });
    }

    public function getOfficeUniqueId(){
        return Yii::$app->cache->getOrSet($this->cacheOfficeUniqueId.$this->combineCache, function () {
            if($this->userId=='null'){
                return self::getDefaultOffice()->unique_id;
            } else {
                $model = Staff::find()->where(['user_id' => $this->userId])->one();
                return $model->office->unique_id;
            }
        });
    }

    public function getStaffId(){
        return Yii::$app->cache->getOrSet($this->cacheStaffId.$this->combineCache, function () {
            $model = Staff::find()->where(['user_id' => $this->userId])->one();
            return $model->id;
        });
    }

    public function getStaffTitle(){
        return Yii::$app->cache->getOrSet($this->cacheStaffTitle.$this->combineCache, function () {
            $model = Staff::find()->where(['user_id' => $this->userId])->one();
            return $model->title;
        });
    }
    
    public function getAuthItemName(){
        return Yii::$app->cache->getOrSet($this->cacheAuthItemName.$this->combineCache, function () {
            $model = AuthAssignment::find()->where(['user_id' => $this->userId])->one();
            return $model->item_name;
        });
    }
}
