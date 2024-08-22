<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class AssetReport extends Model
{
    public $date_first;
    public $date_last;
    public $option_date;
    
    public $archive_category_id;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['date_first', 'date_last', 'option_date'], 'required'],
            [['archive_category_id'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'date_first'    => 'Awal',
            'date_last'     => 'Akhir',
            'option_date'   => 'Tgl',
            
            'archive_category_id'      => 'Kategori',
        ];
    }
}
