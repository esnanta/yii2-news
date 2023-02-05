<?php

namespace backend\models;

use Yii;
use \backend\models\base\Area as BaseArea;
use backend\models\Billing;

/**
 * This is the model class for table "tx_area".
 */
class Area extends BaseArea
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']          
        ];        
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'title'             => Yii::$app->params['Attribute_Title'],
            'description'       => Yii::$app->params['Attribute_Description'],
            
            'created_at'        => Yii::$app->params['Attribute_CreatedAt'],
            'updated_at'        => Yii::$app->params['Attribute_UpdatedAt'],
            'created_by'        => Yii::$app->params['Attribute_CreatedBy'],
            'updated_by'        => Yii::$app->params['Attribute_UpdatedBy'],
            
            'is_deleted'        => 'Deleted',
            'deleted_at'        => Yii::$app->params['Attribute_DeletedAt'],
            'deleted_by'        => Yii::$app->params['Attribute_DeletedBy'],
                       
            'verlock'           => 'Verlock',
        ];
    }    
    
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['area/view', 'id' => $this->id, 'title' => $this->title]);
    } 
    
    public static function getTitle($id){
        $model = Area::find()->where(['id'=>$id])->one();
        return $model->title;
    }
     
    public function countBillingCompletion($status=null){
        
        $currMonth      = date('m',time());
        $currYear       = date('Y',time());

        $query  = Billing::find()
            ->where(['month_period'=>$currMonth.$currYear])
            ->andWhere(['area_id'=>$this->id]);
        
        if(!empty($status)){
            $query->andWhere(['payment_status'=>$status]);
        }
        
        $queryCount = $query->asArray()->count();
        return (!empty($queryCount)) ? $queryCount: 0 ;        
    }
}
