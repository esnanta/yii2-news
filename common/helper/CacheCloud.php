<?php
namespace common\helper;

use backend\models\Lookup;
use backend\models\Profile;
use backend\models\Staff;
use backend\models\Area;
use backend\models\Collector;
use backend\models\Network;
use backend\models\Village;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Yii;

class CacheCloud {
    
    private $cache;
    private $cacheVillage;
    private $cacheArea;
    private $cacheCollector;
    private $cacheNetwork;
    
    private $cacheStaff;
    private $cacheCustomer;
    private $cacheEnrolment;
    private $cacheAccount;
    private $cacheService;
    private $cacheEmployment;
    
    private $cacheModel;
    private $cacheLookupId;
    private $cacheLookupLabel;
    private $cacheLookupToken;

    private $param;
    
    function __construct()
    {
        $this->cache            = Yii::$app->cache;

        $this->cacheVillage     = 'vil';
        $this->cacheArea        = 'are';
        $this->cacheCollector   = 'col';
        $this->cacheNetwork     = 'net';
        
        $this->cacheStaff       = 'stf';
        $this->cacheStaffInitial= 'ini';
        $this->cacheCustomer    = 'cst';
        $this->cacheEnrolment   = 'enr';
        $this->cacheAccount     = 'acc';
        $this->cacheService     = 'ser';
        $this->cacheEmployment  = 'emp';
        
        $this->cacheModel       = 'mdl';
        $this->cacheLookupTitle = 'lte';
        $this->cacheLookupToken = 'tkn';
        $this->cacheLookupLabel = 'lkl';

    }
    
    
    public function Flush(){
        
        Yii::$app->cache->flush();
           
       
        Yii::$app->getSession()->setFlash('success', [
            'message' => Yii::t('app', 'Cache Flushed'),
        ]);        
        
    }
    
    public function getAreaTitle($_param){
        $this->param = $_param;
        return $this->cache->getOrSet($this->cacheArea.$this->param, function () { 
                return Area::find()->where(['id'=>$this->param])->one()->title;
        });
    }  

    public function getCollectorTitle($_param){
        //param = area_id
        $this->param = $_param; 
        return $this->cache->getOrSet($this->cacheCollector.$this->param, function () { 
                return Collector::getListByArea($this->param);
        });
    }      
    
    public function getNetworkTitle($_param){
        $this->param = $_param;
        return $this->cache->getOrSet($this->cacheNetwork.$this->param, function () { 
                return Network::find()->where(['id'=>$this->param])->one()->title;
        });
    }      
    
    public function getVillageTitle($_param){
        $this->param = $_param;
        return $this->cache->getOrSet($this->cacheVillage.$this->param, function () { 
                return Village::find()->where(['id'=>$this->param])->one()->title;
        });
    }       
    
    public function getStaffTitle($_param){
        $this->param = $_param;
        return $this->cache->getOrSet($this->cacheStaff.$this->param, function () { 
                return Staff::find()->where(['id'=>$this->param])->one()->title;
        });
    }    
    public function getStaffInitial($_param){
        $this->param = $_param;
        return $this->cache->getOrSet($this->cacheStaffInitial.$this->param, function () { 
                return Staff::find()->where(['id'=>$this->param])->one()->initial;
        });
    }        
    
    public function getModel($_param){
        $this->param = $_param;
        return $this->cache->getOrSet($this->cacheModel.$this->param, function () { 
                return Profile::find()->where(['user_id' => $this->param])->one();
        });
    }    
    
    public function getLookupTitle($_param){
        $this->param = $_param;
        return $this->cache->getOrSet($this->cacheLookupTitle.$this->param, function () { 
                return Lookup::getTitleById($this->param);
        });
    }
    
    public function getLookupToken($_param){
        $this->param = $_param;
        return Yii::$app->cache->getOrSet($this->cacheLookupToken.$this->param, function () { 
                return Lookup::getIdByToken($this->param);
        });
    }
    
    public function getLookupLabel($_param){
        $this->param = $_param;
        return $this->cache->getOrSet($this->cacheLookupLabel.$this->param, function () { 
                return Lookup::getId($this->param);
        });
    }  
    
}
    