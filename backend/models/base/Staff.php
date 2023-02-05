<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_staff".
 *
 * @property integer $id
 * @property integer $employment_id
 * @property string $title
 * @property string $identity_number
 * @property string $phone_number
 * @property integer $gender_status
 * @property integer $active_status
 * @property string $address
 * @property string $file_name
 * @property string $email
 * @property string $google_plus
 * @property string $instagram
 * @property string $facebook
 * @property string $twitter
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $is_deleted
 * @property integer $deleted_at
 * @property integer $deleted_by
 * @property integer $verlock
 *
 * @property \backend\models\Note[] $notes
 * @property \backend\models\Employment $employment
 * @property \backend\models\Lookup $genderStatus
 */
class Staff extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'notes',
            'employment',
            'genderStatus'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employment_id', 'gender_status', 'active_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['address', 'description'], 'string'],
            [['title', 'identity_number', 'email', 'google_plus', 'instagram', 'facebook', 'twitter'], 'string', 'max' => 100],
            [['phone_number'], 'string', 'max' => 50],
            [['file_name'], 'string', 'max' => 200],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_staff';
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock() {
        return 'verlock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employment_id' => 'Employment ID',
            'title' => 'Title',
            'identity_number' => 'Identity Number',
            'phone_number' => 'Phone Number',
            'gender_status' => 'Gender Status',
            'active_status' => 'Active Status',
            'address' => 'Address',
            'file_name' => 'File Name',
            'email' => 'Email',
            'google_plus' => 'Google Plus',
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'description' => 'Description',
            'is_deleted' => 'Is Deleted',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasMany(\backend\models\Note::className(), ['staff_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployment()
    {
        return $this->hasOne(\backend\models\Employment::className(), ['id' => 'employment_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenderStatus()
    {
        return $this->hasOne(\backend\models\Lookup::className(), ['id' => 'gender_status']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}
