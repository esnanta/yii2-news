<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_account_receivable_detail".
 *
 * @property integer $id
 * @property integer $account_receivable_id
 * @property integer $account_id
 * @property string $invoice
 * @property string $amount
 * @property string $commentary
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $is_deleted
 * @property integer $deleted_at
 * @property integer $deleted_by
 * @property integer $verlock
 *
 * @property \backend\models\Account $account
 * @property \backend\models\AccountReceivable $accountReceivable
 */
class AccountReceivableDetail extends \yii\db\ActiveRecord
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
            'account',
            'accountReceivable'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_receivable_id', 'account_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['amount'], 'number'],
            [['commentary'], 'string'],
            [['invoice'], 'string', 'max' => 20],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_account_receivable_detail';
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
            'account_receivable_id' => 'Account Receivable ID',
            'account_id' => 'Account ID',
            'invoice' => 'Invoice',
            'amount' => 'Amount',
            'commentary' => 'Commentary',
            'is_deleted' => 'Is Deleted',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(\backend\models\Account::className(), ['id' => 'account_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountReceivable()
    {
        return $this->hasOne(\backend\models\AccountReceivable::className(), ['id' => 'account_receivable_id']);
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
