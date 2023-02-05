<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_outlet".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $staff_id
 * @property string $title
 * @property string $invoice
 * @property integer $date_issued
 * @property integer $date_assembly
 * @property integer $billing_status
 * @property integer $assembly_type
 * @property string $month_period
 * @property string $claim
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
 * @property \backend\models\Customer $customer
 * @property \backend\models\Staff $staff
 * @property \backend\models\OutletDetail[] $outletDetails
 */
class Outlet extends \yii\db\ActiveRecord
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
            'customer',
            'staff',
            'outletDetails'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'staff_id', 'date_issued', 'date_assembly', 'billing_status', 'assembly_type', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['claim'], 'number'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 10],
            [['invoice'], 'string', 'max' => 12],
            [['month_period'], 'string', 'max' => 6],
            [['invoice'], 'unique'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_outlet';
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
            'customer_id' => 'Customer ID',
            'staff_id' => 'Staff ID',
            'title' => 'Title',
            'invoice' => 'Invoice',
            'date_issued' => 'Date Issued',
            'date_assembly' => 'Date Assembly',
            'billing_status' => 'Billing Status',
            'assembly_type' => 'Assembly Type',
            'month_period' => 'Month Period',
            'claim' => 'Claim',
            'description' => 'Description',
            'is_deleted' => 'Is Deleted',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(\backend\models\Customer::className(), ['id' => 'customer_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(\backend\models\Staff::className(), ['id' => 'staff_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutletDetails()
    {
        return $this->hasMany(\backend\models\OutletDetail::className(), ['outlet_id' => 'id']);
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
