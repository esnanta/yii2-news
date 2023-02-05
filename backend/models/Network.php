<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use backend\models\base\Network as BaseNetwork;

/**
 * This is the model class for table "tx_network".
 */
class Network extends BaseNetwork
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['description'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
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
        return Yii::$app->getUrlManager()->createUrl(['network/view', 'id' => $this->id, 'title' => $this->title]);
    }

    public static function getDataId($title){
        $model = Network::find()->where(['title'=>$title])->one();
        if(empty($model)){
            $model = new Network;
            $model->title = $title;
            $model->save();
        }
        return $model->id;
    }

    public static function getArrayList(){
        return ArrayHelper::map(Network::find()->asArray()->all(), 'id','title');
    }

    public static function getArrayTitleList(){
        return ArrayHelper::map(Network::find()->asArray()->all(), 'title','title');
    }

    public static function getTitle($id){
        $model= Network::find()->where(['id'=>$id])->one();
        return $model->title;
    }
    
    public function behaviors() {
        return [             
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }         
}
