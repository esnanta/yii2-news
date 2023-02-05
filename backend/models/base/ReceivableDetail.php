<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_receivable_detail".
 *
 * @property integer $id
 * @property integer $receivable_id
 * @property integer $customer_id
 * @property integer $billing_id
 * @property string $title
 * @property integer $date_due
 * @property integer $overdue
 * @property integer $accuracy_status
 * @property string $penalty
 * @property string $claim
 * @property string $total
 * @property string $payment
 * @property string $balance
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $is_deleted
 * @property integer $deleted_at
 * @property integer $deleted_by
 * @property integer $verlock
 *
 * @property \backend\models\Billing $billing
 * @property \backend\models\Customer $customer
 * @property \backend\models\Receivable $receivable
 */
class ReceivableDetail extends \yii\db\ActiveRecord
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
            'billing',
            'customer',
            'receivable'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receivable_id', 'customer_id', 'billing_id', 'date_due', 'overdue', 'accuracy_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['penalty', 'claim', 'total', 'payment', 'balance'], 'number'],
            [['title'], 'string', 'max' => 10],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_receivable_detail';
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
            'receivable_id' => 'Receivable ID',
            'customer_id' => 'Customer ID',
            'billing_id' => 'Billing ID',
            'title' => 'Title',
            'date_due' => 'Date Due',
            'overdue' => 'Overdue',
            'accuracy_status' => 'Accuracy Status',
            'penalty' => 'Penalty',
            'claim' => 'Claim',
            'total' => 'Total',
            'payment' => 'Payment',
            'balance' => 'Balance',
            'is_deleted' => 'Is Deleted',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBilling()
    {
        return $this->hasOne(\backend\models\Billing::className(), ['id' => 'billing_id']);
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
    public function getReceivable()
    {
        return $this->hasOne(\backend\models\Receivable::className(), ['id' => 'receivable_id']);
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
