<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ReportForm extends Model
{

    const OPTION_DATE_ISSUED    = 'date_issued';

    public $data_first;
    public $data_last;
    public $option_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['data_first', 'data_last', 'option_date'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'data_first'    => 'First',
            'data_last'     => 'Last',
            'option_date'   => 'Date',
        ];
    }
}
