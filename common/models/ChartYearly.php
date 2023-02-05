<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ChartYearly extends Model
{


    public $option_year;
    
    public $january;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['option_year'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'option_year'    => 'Tahun',
        ];
    }
}
