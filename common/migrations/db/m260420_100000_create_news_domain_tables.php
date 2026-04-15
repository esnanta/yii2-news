<?php

use yii\db\Migration;

class m260420_100000_create_news_domain_tables extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%office}}', array_merge([
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
        ], $this->auditColumns()));

        $this->createTable('{{%social_platform}}', array_merge([
            'id' => $this->primaryKey(),
            'code' => $this->string(50)->notNull(),
            'name' => $this->string(100)->notNull(),
            'base_url' => $this->string(255),
            'sequence' => $this->integer()->defaultValue(0),
        ], $this->auditColumns()));

        $this->createTable('{{%office_social_account}}', array_merge([
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'platform_id' => $this->integer(),
            'username' => $this->string(100),
            'profile_url' => $this->string(500),
            'is_primary' => $this->tinyInteger()->defaultValue(0),
            'is_visible' => $this->tinyInteger()->defaultValue(1),
            'sequence' => $this->integer()->defaultValue(0),
            'description' => 'longtext',
        ], $this->auditColumns()));

        $this->createTable('{{%document_category}}', array_merge([
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'title' => $this->string(200),
            'sequence' => $this->integer(),
            'description' => $this->text(),
        ], $this->auditColumns()));

        $this->createTable('{{%document}}', array_merge([
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'is_visible' => $this->integer(),
            'category_id' => $this->integer(),
            'document_type' => $this->integer(),
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
        ], $this->auditColumns()));

        $this->createTable('{{%author}}', array_merge([
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
        ], $this->auditColumns()));

        $this->createTable('{{%author_social_account}}', array_merge([
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
        ], $this->auditColumns()));

        $this->createTable('{{%job_title}}', array_merge([
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'title' => $this->string(100),
            'description' => 'tinytext',
            'sequence' => $this->tinyInteger(),
        ], $this->auditColumns()));

        $this->createTable('{{%staff}}', array_merge([
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'job_title_id' => $this->integer(),
            'title' => $this->string(100),
            'initial' => $this->string(10)->notNull(),
            'identity_number' => $this->string(100),
            'phone_number' => $this->string(50),
            'gender' => $this->integer(),
            'status' => $this->integer(),
            'address' => 'tinytext',
            'base_url' => $this->string(255),
            'path' => $this->string(255),
            'name' => $this->string(255),
            'type' => $this->string(255),
            'size' => $this->integer(),
            'email' => $this->string(100),
            'description' => 'tinytext',
        ], $this->auditColumns()));

        $this->createTable('{{%staff_social_account}}', array_merge([
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
        ], $this->auditColumns()));

        $this->createTable('{{%tag}}', array_merge([
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
            'slug' => $this->string(100),
            'frequency' => $this->integer()->notNull()->defaultValue(0),
        ], $this->auditColumns()));

        $this->createTable('{{%article_tag}}', [
            'article_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-article_tag', '{{%article_tag}}', ['article_id', 'tag_id']);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_tag}}');
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%staff_social_account}}');
        $this->dropTable('{{%staff}}');
        $this->dropTable('{{%job_title}}');
        $this->dropTable('{{%author_social_account}}');
        $this->dropTable('{{%author}}');
        $this->dropTable('{{%document}}');
        $this->dropTable('{{%document_category}}');
        $this->dropTable('{{%office_social_account}}');
        $this->dropTable('{{%social_platform}}');
        $this->dropTable('{{%office}}');
    }

    /**
     * Shared audit and soft-delete columns for news-domain tables.
     */
    private function auditColumns(): array
    {
        return [
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'deleted_at' => $this->dateTime(),
            'deleted_by' => $this->integer(),
            'verlock' => $this->bigInteger(),
            'uuid' => $this->string(36),
        ];
    }
}
