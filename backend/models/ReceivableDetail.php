<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use \backend\models\base\ReceivableDetail as BaseReceivableDetail;
use backend\models\Billing as Billing;
use common\helper\Helper as Helper;

/**
 * This is the model class for table "tx_receivable_detail".
 */
class ReceivableDetail extends BaseReceivableDetail
{

    public $description;//UNTUK NAMPILIN DESKRIPSI WAKTU BUAT TAGIHAN

    const ACCURACY_STATUS_ON_TIME = 1; //42 ONTIME
    const ACCURACY_STATUS_OVERDUE = 2; //41 OVERDUE

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'billing',
            'customer',
            'overdueStatus',
            'receivable',
            'enrolment' //TAMBAH
        ];
    }

    public static function getArrayAccuracyStatus()
    {
        return [
            //MASTER
            self::ACCURACY_STATUS_ON_TIME         => 'On Time',
            self::ACCURACY_STATUS_OVERDUE         => 'Telat',
        ];
    }

    public static function getOneAccuracyStatus($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayAccuracyStatus();
            $returnValue = 'Unset';

            switch ($_module) {
                case ($_module == self::ACCURACY_STATUS_ON_TIME):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::ACCURACY_STATUS_OVERDUE):
                    $returnValue = '<span class="label label-danger">'.$arrayModule[$_module].'</span>';
                    break;
                default:
                    $returnValue = '<span class="label label-default">'.$returnValue.'</span>';
            }

            return $returnValue;
        }
        else
            return;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receivable_id', 'customer_id', 'billing_id', 'date_due', 'overdue', 'accuracy_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['penalty', 'claim', 'total', 'payment', 'balance'], 'safe'],
            [['title'], 'string', 'max' => 10],
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
            'receivable_id'     => Yii::$app->params['Attribute_Receivable'],
            'customer_id'       => Yii::$app->params['Attribute_Customer'],
            'billing_id'        => Yii::$app->params['Attribute_Billing'],
            'title'             => Yii::$app->params['Attribute_Title'],
            'date_due'          => Yii::$app->params['Attribute_DateDue'],
            'overdue'           => Yii::$app->params['Attribute_Overdue'],
            'accuracy_status'   => Yii::$app->params['Attribute_AccuracyStatus'],
            'penalty'           => Yii::$app->params['Attribute_Penalty'],
            'claim'             => Yii::$app->params['Attribute_Claim'],
            'total'             => Yii::$app->params['Attribute_Total'],
            'payment'           => Yii::$app->params['Attribute_Payment'],
            'balance'           => Yii::$app->params['Attribute_Balance'],
            
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

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }


        //TANGGAL BAYAR DIKURANGI TANGGAL TEMPO
        //KALAU TELAT = HASILNYA LEBIH BESAR DARI 0
        //KALAU AKURAT = HASILNYA MINUS, KARENA TANGGAL BAYAR
        //LEBIH KECIL DARI TANGGAL JATUH TEMPO

        $datediff = Helper::getOverdue($this->receivable->date_issued, $this->date_due);

        if($datediff<=0){
            $this->accuracy_status = self::ACCURACY_STATUS_ON_TIME;
            $this->overdue = 0;
            if($this->payment == 0 || $this->payment==null){
                $this->accuracy_status = self::ACCURACY_STATUS_OVERDUE;
            }
        }
        else{
            $this->accuracy_status = self::ACCURACY_STATUS_OVERDUE;
            $this->overdue = $datediff;
        }

        $this->customer_id      = $this->receivable->customer_id;
        $this->title            = $this->receivable->invoice;

        $this->claim            = Helper::removeNumberSeparator($this->claim);
        $this->penalty          = Helper::removeNumberSeparator($this->penalty);
        $this->total            = Helper::removeNumberSeparator($this->total);
        $this->payment          = Helper::removeNumberSeparator($this->payment);
        $this->balance          = Helper::removeNumberSeparator($this->balance);

        return true;
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {

            $receivableDetails = ReceivableDetail::find()->where(['billing_id'=>$this->billing_id])->all();
            $count = count($receivableDetails);

            $billing = Billing::find()->where(['id'=>$this->billing_id])->one();
            $billing->payment_status = Billing::PAYMENT_STATUS_CREDIT;
            if ($count > 1) {
                $billing->payment_status = Billing::PAYMENT_STATUS_INSTALLMENT;
            }

            $billing->save();

            return true;
        } else {
            return false;
        }
    }

    public static function countByAccuracyStatus($monthPeriod,$attribute,$status){


        $query  = ReceivableDetail::find()
            ->where(['tx_receivable.month_period'=>$monthPeriod]);
        $query->andWhere([$attribute=>$status]);
        $query->joinWith('receivable');

        $queryCount = $query->asArray()->count();
        return (!empty($queryCount)) ? $queryCount: 0 ;

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolment()
    {
        return $this->hasOne(\backend\models\Enrolment::className(), ['customer_id' => 'customer_id']);
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
