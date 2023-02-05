<?php

namespace backend\models;

use Yii;
use \backend\models\base\Village as BaseVillage;

/**
 * This is the model class for table "tx_village".
 */
class Village extends BaseVillage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['area_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
    
    /**
     *
     */
    public function getUrl(){
        return Yii::$app->getUrlManager()->createUrl(['village/view', 'id' => $this->id, 'title' => $this->title]);
    }     
	
    public static function getTitle($id){
        $model = Village::find()->where(['id'=>$id])->one();
        return $model->title;
    }    
    
    public function getCustomersCount()
    {
        return $this->hasMany(Customer::className(), ['village_id' => 'id'])->count('id');
    }  
}
