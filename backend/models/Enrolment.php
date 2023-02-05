<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use backend\models\base\Enrolment as BaseEnrolment;
use backend\models\OutletDetail;
use backend\models\Area;
use backend\models\Village;
use backend\models\Network;

use common\helper\Helper as Helper;
/**
 * This is the model class for table "tx_enrolment".
 */
class Enrolment extends BaseEnrolment
{
    const ENROLMENT_STATUS_NotAvailable     = 0;
    const ENROLMENT_STATUS_ACTIVE           = 1;
    const ENROLMENT_STATUS_EXPIRED          = 2;

    const ENROLMENT_TYPE_ANALOG     = 1;
    const ENROLMENT_TYPE_DIGITAL    = 2;

    public $days_of_valid;
    public $days_of_expired;

    public $address;
    public $area_id;
    public $village_id;
    public $network_tags_title;

    
    
    const BILLING_CYCLE_LIST = [
            '01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05',
            '06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10',
            '11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15',
            '16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
            '21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25',
            '26'=>'26','27'=>'27','28'=>'28'];
    
    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'customer',
            'network',
            'outlets'//TAMBAHAN
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['network_tags_title','days_of_valid','days_of_expired'], 'safe'],

            [['network_id', 'customer_id', 'date_effective', 'enrolment_type', 
                'date_start', 'date_end', 'created_at', 'updated_at', 'created_by', 'updated_by',
                'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],

            [['description'], 'string'],
            [['title',], 'string', 'max' => 10],
            [['billing_cycle'], 'string', 'max' => 2],
            [['month_period'], 'string', 'max' => 6],
            [['customer_id'], 'unique'],
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

            'network_tags_title'    => 'Lokasi',
            'days_of_valid'         => 'Valid',
            'days_of_expired'       => 'Expired',
            
            'id'                => 'ID',

            'address'           => Yii::$app->params['Attribute_Address'],
            'area_id'           => Yii::$app->params['Attribute_Area'],
            'village_id'        => Yii::$app->params['Attribute_Village'],

            'network_id'        => 'Lokasi',
            'customer_id'       => Yii::$app->params['Attribute_Customer'],
            'title'             => 'Nomor',
            'date_effective'    => Yii::$app->params['Attribute_DateEffective'],
            'billing_cycle'     => Yii::$app->params['Attribute_BillingCycle'],
            'month_period'      => Yii::$app->params['Attribute_MonthPeriod'],

            'enrolment_type'    => Yii::$app->params['Attribute_Type'],
            'date_start'        => Yii::$app->params['Attribute_DateStart'],
            'date_end'          => Yii::$app->params['Attribute_DateEnd'],

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

    public static function getArrayEnrolmentType()
    {
        return [
            //MASTER
            self::ENROLMENT_TYPE_ANALOG   => 'Analog',
            self::ENROLMENT_TYPE_DIGITAL  => 'Digital',
        ];
    }

    public static function getOneEnrolmentType($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayEnrolmentType();
            $returnValue = 'Unset';

            switch ($_module) {
                case ($_module == self::ENROLMENT_TYPE_ANALOG):
                    $returnValue = '<span class="label label-default">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::ENROLMENT_TYPE_DIGITAL):
                    $returnValue = '<span class="label label-success">'.$arrayModule[$_module].'</span>';
                    break;
                default:
                    $returnValue = '<span class="label label-danger">'.$returnValue.'</span>';
            }

            return $returnValue;
        }
        else
            return;
    }

    public static function getArrayEnrolmentStatus()
    {
        return [
            //MASTER
            self::ENROLMENT_STATUS_NotAvailable => 'Analog',
            self::ENROLMENT_STATUS_ACTIVE       => 'On',
            self::ENROLMENT_STATUS_EXPIRED      => 'Expired',
        ];
    }

    public static function getOneEnrolmentStatus($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayEnrolmentStatus();
            $returnValue = 'Unset';

            switch ($_module) {
                case ($_module == self::ENROLMENT_STATUS_NotAvailable):
                    $returnValue = '<span class="label label-default">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::ENROLMENT_STATUS_ACTIVE):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::ENROLMENT_STATUS_EXPIRED):
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
     * @return \yii\db\ActiveQuery
     */
    public function getOutlets()
    {
        return $this->hasMany(\backend\models\Outlet::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * AREA
     */
    public function getArea(){
        $model = Area::find()->where(['id'=>$this->customer->area_id])->one();
        return (empty($model)) ? '' : $model->title;
    }

    /**
     * VILLAGE
     */
    public function getVillage(){
        $model = Village::find()->where(['id'=>$this->customer->village_id])->one();
        return (empty($model)) ? '' :  $model->title;
    }

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if(!empty($this->network_tags_title)){
            $this->network_id = Network::getDataId($this->network_tags_title);
        }

        if ($this->isNewRecord) {
            $this->title            = Counter::getCustomerNumber(Counter::COUNTER_OF_ENROLMENT);
        }

        $this->date_effective   = Helper::setDateToNoon($this->date_effective);
        $this->month_period     = Helper::getMonthPeriod($this->date_effective);

        return true;
    }

    /**
     *
     */
    public function getUrl(){
        return Yii::$app->getUrlManager()->createUrl(['customer/view', 'id' => $this->customer_id, 'title' => $this->title]);
    }

    public function countDeviceActive() {
        $query = OutletDetail::find()->where(['customer_id'=>$this->customer_id]);
        $query->andWhere(['device_status'=> OutletDetail::DEVICE_STATUS_ACTIVE]);
        $queryCount = $query->asArray()->count();
        return (!empty($queryCount)) ? $queryCount: 0 ;
    }

    public static function getBillingCycle($id){
        $enrolment = Enrolment::find()->where(['customer_id'=>$id])->asArray()->one();
        return $enrolment['billing_cycle'];
    }
    
    public static function setBillingCycle($date){
        $value = (in_array(date('d',$date), self::BILLING_CYCLE_LIST)) ? date('d',$date) : '01';
        return $value;
    }
    
    public static function countByDateEffective($year,$month){

        $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;

        $query  = Enrolment::find()
            ->where(['month_period'=>$monthPeriod.$year]);

        $queryCount = $query->asArray()->count();
        return (!empty($queryCount)) ? $queryCount: 0 ;

    }

    public function getDaysOfValid(){
        $datediff = $this->date_end - $this->date_start;
        return round($datediff / (60 * 60 * 24));
    }

    public function getDaysOfExpired(){
        $datediff   =  time() - $this->date_end;
        $value      = ($datediff < 0) ? '0' : round($datediff / (60 * 60 * 24));
        return $value;
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
