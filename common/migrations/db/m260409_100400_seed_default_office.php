<?php

use yii\db\Migration;
use yii\db\Query;

class m260409_100400_seed_default_office extends Migration
{
    private const DEFAULT_OFFICE_ID = 1;
    private const DEFAULT_OFFICE_UNIQUE_ID = 'OFFICE-DEFAULT';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $exists = (new Query())
            ->from('{{%office}}')
            ->where([
                'id' => self::DEFAULT_OFFICE_ID,
                'unique_id' => self::DEFAULT_OFFICE_UNIQUE_ID,
            ])
            ->exists($this->db)
        ;

        if ($exists) {
            return;
        }

        $now = date('Y-m-d H:i:s');

        $this->insert('{{%office}}', [
            'id' => self::DEFAULT_OFFICE_ID,
            'unique_id' => self::DEFAULT_OFFICE_UNIQUE_ID,
            'title' => 'Main Office',
            'is_deleted' => 0,
            'deleted_by' => 0,
            'verlock' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->delete('{{%office}}', [
            'id' => self::DEFAULT_OFFICE_ID,
            'unique_id' => self::DEFAULT_OFFICE_UNIQUE_ID,
        ]);
    }
}
