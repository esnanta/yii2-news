<?php

namespace backend\models;

use \backend\models\Event as Event;


/**
 * This is the model class for table "tx_event".
 */
class EventChart extends Event
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        
        return [
            [['id','date_start', 'date_end', 'view_counter', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['location', 'content', 'description'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['is_active'], 'string', 'max' => 4],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']       
        ];  
        
    }

}
