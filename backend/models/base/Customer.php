<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_customer".
 *
 * @property integer $id
 * @property integer $area_id
 * @property integer $village_id
 * @property string $customer_number
 * @property string $identity_number
 * @property string $title
 * @property integer $gender_status
 * @property string $address
 * @property string $phone_number
 * @property integer $date_issued
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
 * @property \backend\models\Billing[] $billings
 * @property \backend\models\Area $area
 * @property \backend\models\Village $village
 * @property \backend\models\Enrolment $enrolment
 * @property \backend\models\Gmap[] $gmaps
 * @property \backend\models\Outlet[] $outlets
 * @property \backend\models\OutletDetail[] $outletDetails
 * @property \backend\models\Receivable[] $receivables
 * @property \backend\models\ReceivableDetail[] $receivableDetails
 * @property \backend\models\Service[] $services
 * @property \backend\models\ValidityDetail[] $validityDetails
 * @property \backend\models\WorkRequest[] $workRequests
 * @property \backend\models\WorkRequestDetail[] $workRequestDetails
 */
class Customer extends \yii\db\ActiveRecord
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
            'billings',
            'area',
            'village',
            'enrolment',
            'gmaps',
            'outlets',
            'outletDetails',
            'receivables',
            'receivableDetails',
            'services',
            'validityDetails',
            'workRequests',
            'workRequestDetails'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'village_id', 'gender_status', 'date_issued', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['address', 'description'], 'string'],
            [['customer_number'], 'string', 'max' => 10],
            [['identity_number', 'title', 'phone_number'], 'string', 'max' => 50],
            [['customer_number'], 'unique'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_customer';
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
            'area_id' => 'Area ID',
            'village_id' => 'Village ID',
            'customer_number' => 'Customer Number',
            'identity_number' => 'Identity Number',
            'title' => 'Title',
            'gender_status' => 'Gender Status',
            'address' => 'Address',
            'phone_number' => 'Phone Number',
            'date_issued' => 'Date Issued',
            'description' => 'Description',
            'is_deleted' => 'Is Deleted',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillings()
    {
        return $this->hasMany(\backend\models\Billing::className(), ['customer_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(\backend\models\Area::className(), ['id' => 'area_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(\backend\models\Village::className(), ['id' => 'village_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolment()
    {
        return $this->hasOne(\backend\models\Enrolment::className(), ['customer_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGmaps()
    {
        return $this->hasMany(\backend\models\Gmap::className(), ['customer_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutlets()
    {
        return $this->hasMany(\backend\models\Outlet::className(), ['customer_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutletDetails()
    {
        return $this->hasMany(\backend\models\OutletDetail::className(), ['customer_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivables()
    {
        return $this->hasMany(\backend\models\Receivable::className(), ['customer_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivableDetails()
    {
        return $this->hasMany(\backend\models\ReceivableDetail::className(), ['customer_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(\backend\models\Service::className(), ['customer_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidityDetails()
    {
        return $this->hasMany(\backend\models\ValidityDetail::className(), ['customer_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkRequests()
    {
        return $this->hasMany(\backend\models\WorkRequest::className(), ['customer_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkRequestDetails()
    {
        return $this->hasMany(\backend\models\WorkRequestDetail::className(), ['customer_id' => 'id']);
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
