<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_event".
 *
 * @property integer $id
 * @property string $title
 * @property integer $date_start
 * @property integer $date_end
 * @property string $location
 * @property string $content
 * @property integer $view_counter
 * @property string $description
 * @property integer $is_open_registration
 * @property integer $is_using_comingsoon
 * @property integer $is_active
 * @property integer $days_for_comingsoon
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $is_deleted
 * @property integer $deleted_at
 * @property integer $deleted_by
 * @property integer $verlock
 *
 * @property \backend\models\Applicant[] $applicants
 * @property \backend\models\ApplicantAlmamater[] $applicantAlmamaters
 * @property \backend\models\ApplicantDocument[] $applicantDocuments
 * @property \backend\models\ApplicantFamily[] $applicantFamilies
 * @property \backend\models\ApplicantGrade[] $applicantGrades
 */
class Event extends \yii\db\ActiveRecord
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
            'applicants',
            'applicantAlmamaters',
            'applicantDocuments',
            'applicantFamilies',
            'applicantGrades'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_start', 'date_end', 'view_counter', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['location', 'content', 'description'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['is_open_registration', 'is_using_comingsoon', 'is_active'], 'string', 'max' => 1],
            [['days_for_comingsoon'], 'string', 'max' => 2],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_event';
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
            'title' => 'Title',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'location' => 'Location',
            'content' => 'Content',
            'view_counter' => 'View Counter',
            'description' => 'Description',
            'is_open_registration' => 'Is Open Registration',
            'is_using_comingsoon' => 'Is Using Comingsoon',
            'is_active' => 'Is Active',
            'days_for_comingsoon' => 'Days For Comingsoon',
            'is_deleted' => 'Is Deleted',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicants()
    {
        return $this->hasMany(\backend\models\Applicant::className(), ['event_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantAlmamaters()
    {
        return $this->hasMany(\backend\models\ApplicantAlmamater::className(), ['event_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantDocuments()
    {
        return $this->hasMany(\backend\models\ApplicantDocument::className(), ['event_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantFamilies()
    {
        return $this->hasMany(\backend\models\ApplicantFamily::className(), ['event_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantGrades()
    {
        return $this->hasMany(\backend\models\ApplicantGrade::className(), ['event_id' => 'id']);
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
