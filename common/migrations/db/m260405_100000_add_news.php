<?php

use yii\db\Migration;

class m260405_100000_add_news extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%office}}', [
            'id' => $this->primaryKey(),
            'unique_id' => $this->string(15),
            'title' => $this->string(100),
            'phone_number' => $this->string(100),
            'fax_number' => $this->string(100),
            'email' => $this->string(100),
            'web' => $this->string(100),
            'address' => $this->string(100),
            'latitude' => $this->string(100),
            'longitude' => $this->string(100),
            'description' => 'tinytext',
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer(),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%office_media}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'media_type' => $this->integer(),
            'title' => $this->string(100),
            'description' => 'longtext',
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer(),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%asset_category}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'title' => $this->string(200),
            'sequence' => $this->integer(),
            'description' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer(),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%asset}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'is_visible' => $this->integer(),
            'asset_type' => $this->integer(),
            'asset_group' => $this->integer(),
            'asset_category_id' => $this->integer(),
            'title' => $this->string(200),
            'date_issued' => $this->date(),
            'asset_name' => $this->string(100),
            'asset_url' => $this->string(500),
            'size' => $this->integer(),
            'mime_type' => $this->string(100),
            'view_counter' => $this->integer(),
            'download_counter' => $this->integer(),
            'description' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer(),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'user_id' => $this->integer(),
            'title' => $this->string(100),
            'phone_number' => $this->string(50),
            'email' => $this->string(100),
            'file_name' => $this->string(100),
            'address' => 'tinytext',
            'description' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer(),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%author_media}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'author_id' => $this->integer(),
            'media_type' => $this->integer(),
            'title' => $this->string(100),
            'description' => 'longtext',
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer(),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable('{{%author_media}}');
        $this->dropTable('{{%author}}');
        $this->dropTable('{{%asset}}');
        $this->dropTable('{{%asset_category}}');
        $this->dropTable('{{%office_media}}');
        $this->dropTable('{{%office}}');
    }
}

