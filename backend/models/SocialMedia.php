<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use \backend\models\base\SocialMedia as BaseSocialMedia;

/**
 * This is the model class for table "tx_social_media".
 */
class SocialMedia extends BaseSocialMedia
{
    
    const SOCMED_ICONS_1 = '<i class="fa fa-facebook"></i>';
    const SOCMED_ICONS_2 = '<i class="fa fa-twitter"></i>';
    const SOCMED_ICONS_3 = '<i class="fa fa-youtube"></i>';
    const SOCMED_ICONS_4 = '<i class="fa fa-instagram"></i>';
    const SOCMED_ICONS_5 = '<i class="fa fa-github"></i>';
    
    public function relationNames()
    {
        return [
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['description'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['title','url'], 'string', 'max' => 100],
            [['icon'], 'string', 'max' => 50],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'icon' => 'Icon',
            'url' => 'Url',
            'description' => 'Description',
            'is_deleted' => 'Is Deleted',
            'verlock' => 'Verlock',
        ];
    }
    
    public static function getArraySocMed()
    {
        return [
            //MASTER
            self::SOCMED_ICONS_1 => self::SOCMED_ICONS_1,
            self::SOCMED_ICONS_2 => self::SOCMED_ICONS_2,
            self::SOCMED_ICONS_3 => self::SOCMED_ICONS_3,
            self::SOCMED_ICONS_4 => self::SOCMED_ICONS_4,
            self::SOCMED_ICONS_5 => self::SOCMED_ICONS_5,
        ];
    }
    
    public static function getOneSocMed($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArraySocMed();
            $returnValue = '<span class="label label-success">'.$arrayModule[$_module].'</span>';

            return $returnValue;

        }
        else
            return;
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
