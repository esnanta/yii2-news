<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ChartUser extends Model
{

    public $data;
    public $option_user_id;
    public $option_year;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['option_user_id', 'option_year'], 'required'],
            [['data','option_user_id', 'option_year',], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'option_user_id' => 'User',
            'option_year'    => 'Tahun',
        ];
    }
}
