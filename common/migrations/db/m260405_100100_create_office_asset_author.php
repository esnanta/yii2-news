<?php

use yii\db\Migration;

class m260405_100100_create_office_asset_author extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        // Create/alter tables first; indexes and foreign keys are added in the next migration.
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
            'is_deleted' => $this->integer()->defaultValue(0),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        // `social_platform` is a global master table (no direct `office_id` ownership).
        $this->createTable('{{%social_platform}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(50)->notNull(),
            'name' => $this->string(100)->notNull(),
            'base_url' => $this->string(255),
            'is_active' => $this->tinyInteger()->defaultValue(1),
            'sequence' => $this->integer()->defaultValue(0),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%office_social_account}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'platform_id' => $this->integer(),
            'username' => $this->string(100),
            'profile_url' => $this->string(500),
            'is_primary' => $this->tinyInteger()->defaultValue(0),
            'is_visible' => $this->tinyInteger()->defaultValue(1),
            'sequence' => $this->integer()->defaultValue(0),
            'description' => 'longtext',
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%document_category}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'title' => $this->string(200),
            'sequence' => $this->integer(),
            'description' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%document}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'is_visible' => $this->integer(),
            'category_id' => $this->integer(),
            'title' => $this->string(200),
            'date_issued' => $this->date(),
            'base_url' => $this->string(255),
            'path' => $this->string(255),
            'name' => $this->string(255),
            'type' => $this->string(255),
            'size' => $this->integer(),
            'view_count' => $this->integer(),
            'download_count' => $this->integer(),
            'description' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'title' => $this->string(100),
            'phone_number' => $this->string(50),
            'email' => $this->string(100),
            'base_url' => $this->string(255),
            'path' => $this->string(255),
            'name' => $this->string(255),
            'type' => $this->string(255),
            'size' => $this->integer(),
            'address' => 'tinytext',
            'description' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%author_social_account}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'author_id' => $this->integer(),
            'platform_id' => $this->integer(),
            'username' => $this->string(100),
            'profile_url' => $this->string(500),
            'is_primary' => $this->tinyInteger()->defaultValue(0),
            'is_visible' => $this->tinyInteger()->defaultValue(1),
            'sequence' => $this->integer()->defaultValue(0),
            'description' => 'longtext',
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%employment}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'title' => $this->string(100),
            'description' => $this->text(),
            'sequence' => $this->tinyInteger(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%staff}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'employment_id' => $this->integer(),
            'title' => $this->string(100),
            'initial' => $this->string(10)->notNull(),
            'identity_number' => $this->string(100),
            'phone_number' => $this->string(50),
            'gender_status' => $this->integer(),
            'active_status' => $this->integer(),
            'address' => 'tinytext',
            'base_url' => $this->string(255),
            'path' => $this->string(255),
            'name' => $this->string(255),
            'type' => $this->string(255),
            'size' => $this->integer(),
            'email' => $this->string(100),
            'google_plus' => $this->string(100),
            'instagram' => $this->string(100),
            'facebook' => $this->string(100),
            'twitter' => $this->string(100),
            'description' => 'tinytext',
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ]);

        $this->createTable('{{%staff_social_account}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'staff_id' => $this->integer(),
            'platform_id' => $this->integer(),
            'username' => $this->string(100),
            'profile_url' => $this->string(500),
            'is_primary' => $this->tinyInteger()->defaultValue(0),
            'is_visible' => $this->tinyInteger()->defaultValue(1),
            'sequence' => $this->integer()->defaultValue(0),
            'description' => 'longtext',
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer()->defaultValue(0),
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
        // Drop in reverse dependency order.
        $this->dropTable('{{%staff_social_account}}');
        $this->dropTable('{{%staff}}');
        $this->dropTable('{{%employment}}');
        $this->dropTable('{{%author_social_account}}');
        $this->dropTable('{{%author}}');
        $this->dropTable('{{%document}}');
        $this->dropTable('{{%document_category}}');
        $this->dropTable('{{%office_social_account}}');
        $this->dropTable('{{%social_platform}}');
        $this->dropTable('{{%office}}');
    }
}
