<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use \backend\models\base\Validity as BaseValidity;
use backend\models\ValidityDetail;
use backend\models\Enrolment;

use common\helper\Helper;

/**
 * This is the model class for table "tx_validity".
 */
class Validity extends BaseValidity
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['counter', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['title'], 'string', 'max' => 6],
            [['title'], 'unique'],
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
            'counter'           => 'Counter',
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

    public static function getMonthPeriod(){

        $yearStart  = Yii::$app->params['Year-Start'];
        $yearEnd    = Yii::$app->params['Year-End'];

        $monthPeriods=[];

        for($y = $yearStart; $y <= $yearEnd; ++$y){
            for($m=1; $m<=12; ++$m){
                $m = ($m<10) ? '0'.$m : $m;
                $monthPeriods[] = $m.$y;
            }
        }

        $newValue = [];

        foreach($monthPeriods as $key => $monthPeriodValue) {
            $newValue[$monthPeriodValue]=$monthPeriodValue;
        }

        return $newValue;
    }


    /**
     *
     */
    public function getUrl(){
        return Yii::$app->getUrlManager()->createUrl(['validity/view', 'id' => $this->id, 'title' => $this->title]);
    }

    public function countByDeviceStatus($status) {
        return ValidityDetail::find()->where([
            'validity_id'   => $this->id,
            'device_status' => $status])
        ->asArray()->count();
    }

    public function countByBillingStatus($statusParam) {

        //TAGIHAN YANG DIHITUNG ADALAH YANG DEVICE NYA AKTIF
        return ValidityDetail::find()->where([
            'validity_id'       => $this->id,
            'device_status'     => ValidityDetail::DEVICE_STATUS_ACTIVE,
            'billing_status'    => $statusParam])
        ->asArray()->count();
    }
    
    public static function getUnsavedValidity($id){
        $validityList       = [];
        $enrolment          = Enrolment::find()->where(['customer_id'=>$id])->one();

        $billingCycle       = $enrolment->billing_cycle;
        $dateDue            = Helper::getFirstDateBilling($enrolment->date_effective, $billingCycle);
        $monthPeriod        = Helper::getMonthPeriod($dateDue);

        $counter = 0;

        $validityExists     = ValidityDetail::find()->select('id')->where(['customer_id'=>$id])->all();
        $unsavedValidities  = Validity::find()
                                ->where(['not in','id',$validityExists])
                                ->orderBy(['id'=>SORT_DESC])
                                ->all();

        
       foreach ($unsavedValidities as $validityModel) {

           $checkDetail    = ValidityDetail::find()
                                ->where(['validity_id'=>$validityModel->id,'customer_id'=>$id])->one();

            if(empty($checkDetail)){
                $validityList[]     =    [
                    'id'    => $validityModel->id,
                    'title' => $validityModel->title
                ];
                $counter=$counter+1;
            }

            $dateDue        = Helper::getNextDue($dateDue, $billingCycle);
            $monthPeriod    = Helper::getMonthPeriod($dateDue);
       }
       
        return $validityList;
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
