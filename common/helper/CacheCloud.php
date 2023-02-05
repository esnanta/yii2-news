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
    private $cacheModel;
    private $cacheLookupLabel;
    private $cacheLookupToken;

    private $param;
    
    function __construct()
    {
        $this->cache            = Yii::$app->cache;

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
    