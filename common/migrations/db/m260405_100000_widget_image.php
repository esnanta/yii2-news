<?php

use yii\db\Migration;

class m260405_100000_widget_image extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%widget_image}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(100)->notNull(),
            'title' => $this->string(100),
            'base_url' => $this->string(1024),
            'path' => $this->string(1024),
            'mime_type' => $this->string(100),
            'size' => $this->integer(),
            'link_url' => $this->string(500),
            'alt_text' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('idx-widget_image-key', '{{%widget_image}}', 'key');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropIndex('idx-widget_image-key', '{{%widget_image}}');
        $this->dropTable('{{%widget_image}}');
    }
}
