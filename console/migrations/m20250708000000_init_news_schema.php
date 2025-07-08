<?php

use yii\db\Migration;

/**
 * Class m20250708000000_init_news_schema
 */
class m20250708000000_init_news_schema extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Table `tx_article`
        $this->createTable('{{%tx_article}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'article_category_id' => $this->integer(),
            'author_id' => $this->integer(),
            'title' => $this->string(200),
            'cover' => $this->string(300),
            'url' => $this->string(300),
            'content' => $this->longText(),
            'description' => $this->longText(),
            'tags' => $this->text(),
            'publish_status' => $this->integer(),
            'pinned_status' => $this->integer(),
            'view_counter' => $this->integer(),
            'rating' => $this->float(),
            'date_issued' => $this->date(),
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

        // Table `tx_article_category`
        $this->createTable('{{%tx_article_category}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'title' => $this->string(100),
            'label' => $this->string(20),
            'sequence' => $this->integer(),
            'description' => $this->text(),
            'time_line' => $this->integer(),
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

        // Table `tx_asset`
        $this->createTable('{{%tx_asset}}', [
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

        // Table `tx_asset_category`
        $this->createTable('{{%tx_asset_category}}', [
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

        // Table `tx_author`
        $this->createTable('{{%tx_author}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'user_id' => $this->integer(),
            'title' => $this->string(100),
            'phone_number' => $this->string(50),
            'email' => $this->string(100),
            'file_name' => $this->string(100),
            'address' => $this->tinyText(),
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

        // Table `tx_author_media`
        $this->createTable('{{%tx_author_media}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'author_id' => $this->integer(),
            'media_type' => $this->integer(),
            'title' => $this->string(100),
            'description' => $this->longText(),
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

        // Table `tx_counter`
        $this->createTable('{{%tx_counter}}', [
            'id' => $this->string(8)->notNull(),
            'office_id' => $this->integer(),
            'counter' => $this->integer(),
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
        $this->addPrimaryKey('PK_tx_counter_id', '{{%tx_counter}}', 'id');


        // Table `tx_dashblock`
        $this->createTable('{{%tx_dashblock}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(255)->notNull()->defaultValue(''),
            'actions' => $this->text(),
            'weight' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(1),
        ]);

        // Table `tx_employment`
        $this->createTable('{{%tx_employment}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'title' => $this->string(100),
            'description' => $this->text(),
            'sequence' => $this->tinyInteger(),
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
        $this->createIndex('idx-tx_employment-title', '{{%tx_employment}}', 'title', true);


        // Table `tx_event`
        $this->createTable('{{%tx_event}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'title' => $this->string(200),
            'date_start' => $this->dateTime(),
            'date_end' => $this->dateTime(),
            'location' => $this->tinyText(),
            'content' => $this->text(),
            'view_counter' => $this->integer(),
            'description' => $this->text(),
            'is_active' => $this->tinyInteger(),
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

        // Table `tx_migration` (if not already handled by Yii2 basic/advanced template)
        // This table is usually created by Yii2's own migration system.
        // We'll include it for completeness if it's not expected to exist.
        $this->createTable('{{%tx_migration}}', [
            'version' => $this->string(180)->notNull(),
            'apply_time' => $this->integer(),
        ]);
        $this->addPrimaryKey('PK_tx_migration_version', '{{%tx_migration}}', 'version');


        // Table `tx_office`
        $this->createTable('{{%tx_office}}', [
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
            'description' => $this->tinyText(),
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

        // Table `tx_office_media`
        $this->createTable('{{%tx_office_media}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'media_type' => $this->integer(),
            'title' => $this->string(100),
            'description' => $this->longText(),
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

        // Table `tx_page`
        $this->createTable('{{%tx_page}}', [
            'id' => $this->primaryKey(),
            'page_type' => $this->integer(),
            'title' => $this->string(100),
            'content' => $this->longText(),
            'description' => $this->tinyText(),
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

        // Table `tx_profile` (assuming it's part of a user module, but creating it here for completeness)
        $this->createTable('{{%tx_profile}}', [
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(255),
            'public_email' => $this->string(255),
            'gravatar_email' => $this->string(255),
            'gravatar_id' => $this->string(32),
            'location' => $this->string(255),
            'website' => $this->string(255),
            'timezone' => $this->string(40),
            'bio' => $this->text(),
            'file_name' => $this->string(200),
        ]);
        $this->addPrimaryKey('PK_tx_profile_user_id', '{{%tx_profile}}', 'user_id');


        // Table `tx_quote`
        $this->createTable('{{%tx_quote}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100),
            'content' => $this->text(),
            'source' => $this->string(100),
            'file_name' => $this->string(200),
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

        // Table `tx_session`
        $this->createTable('{{%tx_session}}', [
            'id' => $this->char(32)->notNull(),
            'expire' => $this->integer(),
            'data' => $this->binary(),
        ]);
        $this->addPrimaryKey('PK_tx_session_id', '{{%tx_session}}', 'id');


        // Table `tx_social_account` (assuming it's part of a user module, but creating it here for completeness)
        $this->createTable('{{%tx_social_account}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'provider' => $this->string(255)->notNull(),
            'client_id' => $this->string(255)->notNull(),
            'code' => $this->string(32),
            'email' => $this->string(255),
            'username' => $this->string(255),
            'data' => $this->text(),
            'created_at' => $this->integer(),
        ]);
        $this->createIndex('idx_social_account_provider_client_id', '{{%tx_social_account}}', ['provider', 'client_id'], true);
        $this->createIndex('idx_social_account_code', '{{%tx_social_account}}', 'code', true);


        // Table `tx_staff`
        $this->createTable('{{%tx_staff}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'user_id' => $this->integer(),
            'employment_id' => $this->integer(),
            'title' => $this->string(100),
            'initial' => $this->string(10)->notNull(),
            'identity_number' => $this->string(100),
            'phone_number' => $this->string(50),
            'gender_status' => $this->integer(),
            'active_status' => $this->integer(),
            'address' => $this->tinyText(),
            'file_name' => $this->string(200),
            'email' => $this->string(100),
            'google_plus' => $this->string(100),
            'instagram' => $this->string(100),
            'facebook' => $this->string(100),
            'twitter' => $this->string(100),
            'description' => $this->tinyText(),
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

        // Table `tx_staff_media`
        $this->createTable('{{%tx_staff_media}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(),
            'staff_id' => $this->integer(),
            'media_type' => $this->integer(),
            'title' => $this->string(100),
            'description' => $this->longText(),
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

        // Table `tx_tag`
        $this->createTable('{{%tx_tag}}', [
            'id' => $this->primaryKey(),
            'tag_name' => $this->string(150)->notNull(),
            'frequency' => $this->integer(),
        ]);

        // Table `tx_token` (assuming it's part of a user module, but creating it here for completeness)
        $this->createTable('{{%tx_token}}', [
            'user_id' => $this->integer(),
            'code' => $this->string(32)->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx_token_user_id_code_type', '{{%tx_token}}', ['user_id', 'code', 'type'], true);


        // Table `tx_user` (assuming it's part of a user module, but creating it here for completeness)
        $this->createTable('{{%tx_user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull()->unique(),
            'email' => $this->string(255)->notNull()->unique(),
            'password_hash' => $this->string(60)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'unconfirmed_email' => $this->string(255),
            'registration_ip' => $this->string(45),
            'flags' => $this->integer()->notNull()->defaultValue(0),
            'confirmed_at' => $this->integer(),
            'blocked_at' => $this->integer(),
            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'last_login_at' => $this->integer(),
            'auth_tf_key' => $this->string(16),
            'auth_tf_enabled' => $this->tinyInteger()->defaultValue(0),
        ]);

        // Add foreign keys
        $this->addForeignKey(
            'FK_tx_article_author',
            '{{%tx_article}}',
            'author_id',
            '{{%tx_author}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'FK_tx_article_category',
            '{{%tx_article}}',
            'article_category_id',
            '{{%tx_article_category}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'FK_tx_article_office',
            '{{%tx_article}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_article_category_office',
            '{{%tx_article_category}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_asset_category',
            '{{%tx_asset}}',
            'asset_category_id',
            '{{%tx_asset_category}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'FK_tx_asset_office',
            '{{%tx_asset}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_asset_category_office',
            '{{%tx_asset_category}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_author_office',
            '{{%tx_author}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'FK_tx_author_user',
            '{{%tx_author}}',
            'user_id',
            '{{%tx_user}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_author_media_author',
            '{{%tx_author_media}}',
            'author_id',
            '{{%tx_author}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'FK_tx_author_media_office',
            '{{%tx_author_media}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_counter_office',
            '{{%tx_counter}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_employment_office',
            '{{%tx_employment}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_event_office',
            '{{%tx_event}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_office_media_office',
            '{{%tx_office_media}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk_profile_user',
            '{{%tx_profile}}',
            'user_id',
            '{{%tx_user}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk_social_account_user',
            '{{%tx_social_account}}',
            'user_id',
            '{{%tx_user}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_staff_employment',
            '{{%tx_staff}}',
            'employment_id',
            '{{%tx_employment}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'FK_tx_staff_office',
            '{{%tx_staff}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'FK_tx_staff_user',
            '{{%tx_staff}}',
            'user_id',
            '{{%tx_user}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_tx_staff_media_author', // Renamed from FK_tx_staff_media_author to avoid confusion with actual author
            '{{%tx_staff_media}}',
            'staff_id',
            '{{%tx_staff}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'FK_tx_staff_media_office',
            '{{%tx_staff_media}}',
            'office_id',
            '{{%tx_office}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk_token_user',
            '{{%tx_token}}',
            'user_id',
            '{{%tx_user}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        // Insert initial data for non-RBAC tables
        $this->batchInsert('{{%tx_asset}}', [
            'id', 'office_id', 'is_visible', 'asset_type', 'asset_group', 'asset_category_id', 'title', 'date_issued', 'asset_name', 'asset_url', 'size', 'mime_type', 'view_counter', 'download_counter', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock', 'uuid'
        ], [
            [4, 1, 2, 3, NULL, 1, 'Jalan Sunyi Seorang Seniman', '2025-01-08', 'Jalan_Sunyi_Seorang_Seniman_677df5729a145.png', '/app/yii2-news/admin/images/no-picture-available-icon-1.jpg', NULL, NULL, 0, 3, '', '2025-01-08 10:48:02', '2025-01-08 11:09:42', 1, NULL, NULL, NULL, NULL, 3, '5c5d4f93cd7311efaa70c858c0b7f92f'],
            [5, 1, 2, 1, NULL, 1, 'Gambar Article', '2025-01-08', 'Gambar_Article_677df58a659ef.pdf', '/app/yii2-news/admin/images/no-picture-available-icon-1.jpg', NULL, NULL, 0, 3, '', '2025-01-08 10:48:26', '2025-01-08 11:09:40', 1, NULL, NULL, NULL, NULL, 3, '6a8aab6ecd7311efaa70c858c0b7f92f'],
            [6, 1, 2, 2, NULL, 1, 'tes pdf', '2025-01-08', 'tes_pdf_677df82133b47.xlsx', '/app/yii2-news/admin/images/no-picture-available-icon-1.jpg', NULL, NULL, 0, 0, '-', '2025-01-08 10:59:29', '2025-01-08 10:59:29', 1, 1, NULL, NULL, NULL, 0, 'f5995e14cd7411efaa70c858c0b7f92f'],
        ]);

        $this->batchInsert('{{%tx_asset_category}}', [
            'id', 'office_id', 'title', 'sequence', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock', 'uuid'
        ], [
            [1, 1, 'test', 1, '', '2025-01-08 10:12:19', '2025-01-08 10:12:19', 1, 1, NULL, NULL, NULL, 0, '5ed0d057cd6e11efaa70c858c0b7f92f'],
        ]);

        $this->batchInsert('{{%tx_author}}', [
            'id', 'office_id', 'user_id', 'title', 'phone_number', 'email', 'file_name', 'address', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock', 'uuid'
        ], [
            [1, NULL, NULL, 'Admin', '', 'hubunganinternasional.id@gmail.com', 'qqWkyzDJaNIAC7uPjV4E4B12Ul0J9R7c.jpg', '', '', '2018-06-12 15:43:58', '2019-08-14 10:34:00', 1, 1, NULL, NULL, NULL, 3, ''],
        ]);

        $this->batchInsert('{{%tx_employment}}', [
            'id', 'office_id', 'title', 'description', 'sequence', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock', 'uuid'
        ], [
            [1, 1, 'Developer', '', 1, '2015-09-01 20:38:25', '2020-08-14 14:46:07', 1, 1, NULL, NULL, NULL, 4, ''],
        ]);

        $this->batchInsert('{{%tx_migration}}', [
            'version', 'apply_time'
        ], [
            ['Da\\User\\Migration\\m000000_000001_create_user_table', 1507740966],
            ['Da\\User\\Migration\\m000000_000002_create_profile_table', 1507740968],
            ['Da\\User\\Migration\\m000000_000003_create_social_account_table', 1507740970],
            ['Da\\User\\Migration\\m000000_000004_create_token_table', 1507740972],
            ['Da\\User\\Migration\\m000000_000005_add_last_login_at', 1507740973],
            ['Da\\User\\Migration\\m000000_000006_add_two_factor_fields', 1514392155],
            ['m140506_102106_rbac_init', 1507741269],
            ['m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1514392156],
        ]);

        $this->batchInsert('{{%tx_office}}', [
            'id', 'unique_id', 'title', 'phone_number', 'fax_number', 'email', 'web', 'address', 'latitude', 'longitude', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock', 'uuid'
        ], [
            [1, '66a1250c9bdb4', 'Hubungan Internasional', '081226993704', '45635345', 'hubunganinternasional.id@gmail.com', 'hubunganinternasional.id', 'Bantul, Yogyakarta', '', '', '-', '2015-05-02 10:17:07', '2024-07-24 23:02:59', 1, 1, 0, NULL, NULL, 14, ''],
        ]);

        $this->batchInsert('{{%tx_page}}', [
            'id', 'page_type', 'title', 'content', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock', 'uuid'
        ], [
            [1, 2, 'Logo 1', '<p><img style="width: 103px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGcAAAAnCAYAAAASGVaVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcDEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZCBGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6N2EyZDdmM2EtMTRkMS00Mjg0LWJmMGQtNDBlMWUyZDIzYzhmIiBzdFJlZjpkb2N1bWVudElEPXhtcC5kaWQ6N2EyZDdmM2EtMTRkMS00Mjg0LWJmMGQtNDBlMWUyZDIzYzhmIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+B69CrgAABgxJREFUeNrsW3tQVFUYv/uARRBw1+K1DBMLFQwk5iL4AJJiKzOH0VxyQmdwqKX0j8pplElrxgabxek5pcmmIzUV2ZqOQ/YAiiQjs10GjKlEWURYeQi78l4i2fbbcfHcu3f3XgTu3XXvN8MM59x7OOee3/l+5/d958Ar0S23YnNoKeL1+rjQpfrY0CXHAoTB1RhntI031+Cgtiys4HR2dOGzfJ7gEjf1HgYOmEQUaypM/DjXXxB4ho0PHhwaUu57f/9X8PvaxxXa9FR5Ht22VqtVfLW7R1VV+7Oq1XBZhj6DvxUtleqlkRGlXguOA6CipE/TmfYgmNzX9paa0LoXCguK6UzomMWSs/et99zScnbGippHVmUpZmu8fDZWr2m8TVLbefgQ0/1axsflt9NucnJSRgUM2FL5g5rZHK+QLT4921v+UEZk/sMiYdBPTPUZIBLpnev8zVTt2tqvqIh1O17clhcSHKx1lI1d3TvRstd6ztRHDzZsYHSD5fHMMKnoPrFQIqFc7XW/nVWi5S35G0uJQMzmXsO654A19n2jSJBkMtonTGrJ7mLedNoQN/+oyIgaJsbKqud0DDfEeLqchf2Grb5ZBedf64g/F83MEq0tFMVizyd/jqs72JyP9Y+3uW23+b6DWEzwolscbizHfukmp/rdJWormcyFFdzV06skxhgSsdj89Prc0sjwMC2fzzdQfQP698F2vfKSYl5AQA2Zx0B/R4+f3El8RqbcgCpPVJ7S6Zv+nFKE8pQH9OvWrkmlM7fv7C8zmcxmsaNs+yZNXTqfRKLeBY1dCHx0uV5PKctsH3XmphuzUFm/yaR694CmbLrtslYu19jAmWoHQOWuWS2jWjQQQ6HAgMXLYrV8Twbnale3rLXtstoVMESD92Bi2RqvzYu14MloHXgfVbtLhjbcO3GyewzgzR7tObDyHDQB0feKZWmlKAWRedQnFVr19m1FMwoGQV5baErjoLfX39zXSocKQaorsrO0NiqcWiBAw1ue2ejWm2tr63DgPJq9SsO6IKBrwL+QFiFOCFDYy1tVRUSag/wZW2NNuDdeQ5ThExMTLjMTMFYipcH+6RXgAE0kJyYUu1vlRCoZGh5hTf76+fnpQQigdVc6jS4XS3tHZw5aBoZw7FEeD87K9NQaoAt376QkJeImw2KxiNkcMwgDtHzy2x9I90FIxBIpbfGiZK1HxDl0DNLwVO+Ehd2NU0OjY2Nilr0dJwxcUe3Q8DBOpUEbaOs14ATPDzJgXmYOYYDW/X2hxQkcYh20QVnC48GxcbgZ80IjCoNff9flAI2hlAZ1xNjGY9I3d7IRhQHQl+2HiZRxKs0R2zAOTqh/uE8CRBQGjeeblUjgmUMW2zAOToBgvk+CQxQGtWfq7dQGP5XfVyvJYhscOAv8ogdmNvGhbp9LAxdjImGQT4JDJgzgggioNFexDQ6c8MBEI93ORv+77lQnC0lz24bq+Z1uRGEAyVyiSkNjGxw4yZKc03Q7GrthxnpG8ADfvyDLrddkSQs4YYAIA0jm3tVyUe4qtsGBExuy5Nh0OrtwvQ5XDg+S2c9rAAiHzROIscwIFVaQeICTbQRhAIlc9DyKGNugJoTbL3ATE27D0OlId02Lpdy1GgsV3VJgcJDmCoiB8R6sqe87n/agm8JATUxwksU2TmoNrsjSFQZAbScMe+yTTmVAgRUXt2OGwXM+7TngGblPPOYklcliGydw4Oblc0nlT8JNTDqdGUcbsQ+b19mPm1vM9U7Pz/dVYVXtH2CH/tlkP8KG933dYqKlTh5CFtvgQLVp7qnCpPVG/I8dZUfOXfssg6lB75LX83wBHDjT2VP6tg6te+PVHXHujrBxJ6HgQYqYrZmZUZsVbQMNG1oH/pA3mY/LMc5mbL19/bRiG5eew9nc2ZEvvmxFVRqc4FLdNuUSnwwYnOUQr3O5im04cBg0yKN9XXkKdwkF7tlRne5y4DDgMeUVR3Wo14B8jooIp3U7SMhN4ewZ1T9YAZ1tUj6VR8drOHAYNPAYAAZybXTbcODMogkFAiePgKRnWqpcezvXhP8XYAA+X5r2Quf1LQAAAABJRU5ErkJggg==" data-filename="logo-1.png"><br></p>', 'Logo 1 - Bagian Atas Kiri', '2018-01-08 21:47:15', '2024-08-18 15:55:56', 1, 1, NULL, NULL, NULL, 0, ''],
            [2, 2, 'Logo 2', '<p><img style="width: 200px;" src="data:image/png;base64,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" data-filename="logo-14.png"><br></p>', 'Logo 2 - Bagian Bawah Kiri', '2018-01-08 21:47:15', '2024-08-18 15:55:41', 1, 1, NULL, NULL, NULL, 0, ''],
            [3, 2, 'Logo Report 1', 'b3MYTwJeYCkb4IUmLrPkjcePntzALUBi.png', 'Logo 1 - Bagian Atas Kiri', '2018-01-08 21:47:15', '2018-01-08 21:47:15', 1, 1, NULL, NULL, NULL, 0, ''],
            [4, 2, 'Logo Report 2', 'q8Z7e_TqQrBwU8URdcZ4I7t62u3-EHCm.png', 'NA', '2018-01-08 21:47:15', '2018-01-08 21:47:15', 1, 1, NULL, NULL, NULL, 0, ''],
            [11, 1, 'SEO Description', '<p>seo description here testing<br></p>', 'SEO Description', '2018-01-08 21:47:15', '2024-08-18 16:11:04', 1, 1, NULL, NULL, NULL, 1, ''],
            [12, 1, 'SEO Keyword', '<p>seo, keyword, for, my, site<br></p>', 'SEO Keyword', '2018-01-08 21:47:15', '2024-08-18 16:11:20', 1, 1, NULL, NULL, NULL, 1, ''],
            [21, 1, 'About', 'VD6pJHgk7ikBhHW6gmW59mfrWLQhjpFx.png', 'Donec id elit y DESCRIPTION.', '2017-12-02 22:33:55', '2017-12-02 22:39:25', 1, 1, NULL, NULL, NULL, 0, ''],
        ]);

        $this->batchInsert('{{%tx_profile}}', [
            'user_id', 'name', 'public_email', 'gravatar_email', 'gravatar_id', 'location', 'website', 'timezone', 'bio', 'file_name'
        ], [
            [1, 'Nanta Es', 'ombakrinai@gmail.com', '', 'd41d8cd98f00b204e9800998ecf8427e', 'Lhokseumawe', 'https://escyber.com/', NULL, '-', ''],
        ]);

        $this->batchInsert('{{%tx_session}}', [
            'id', 'expire', 'data'
        ], [
            ['0qmlr3iph45nl8cst2fmtvmfm2', 1723382163, hex2bin('5f5f666c6173687c613a303a7b7d5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b')],
            ['0vonnia33auapusrtms0of5c8m', 1723478368, hex2bin('5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f6170702f796969322d6573637962657231332f61646d696e2f223b5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b')],
            ['662d476bmi69a6s47pjp9ebel4', 1736312877, hex2bin('5f5f666c6173687c613a303a7b7d')],
            ['cr4nm3fap25lutl3rjuoqdko9d', 1724051742, hex2bin('5f5f666c6173687c613a303a7b7d5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b')],
            ['et40u8ui35oc136spej8od45as', 1723369406, hex2bin('5f5f666c6173687c613a303a7b7d')],
            ['jhvvp186f0vk7q0s3vevsb1ssk', 1736338102, hex2bin('5f5f666c6173687c613a303a7b7d5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b')],
            ['jp4b5af75rblmogi4628tmv1fp', 1736313726, hex2bin('5f5f666c6173687c613a313a7b733a363a2264616e676572223b693a313b7d5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b64616e6765727c613a313a7b733a373a226d657373616765223b733a31363a224173736574206e6f7420666f756e642e223b7d')],
            ['k700usv8eg5hrv06tik88mesgf', 1736309447, hex2bin('5f5f666c6173687c613a303a7b7d')],
            ['lq9fhof7mbjrnvcefcep1rob1b', 1723994741, hex2bin('5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f6170702f796969322d6573637962657231332f61646d696e2f223b5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b')],
            ['lvumj24ubqe65hpbigesvfcm6u', 1736571592, hex2bin('5f5f666c6173687c613a303a7b7d5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b')],
            ['mvaottor80ksredf6utp9n7d6q', 1736341778, hex2bin('5f5f666c6173687c613a303a7b7d')],
            ['qterljtbj60pp5j8hih5voegje', 1724338235, hex2bin('5f5f666c6173687c613a303a7b7d')],
            ['trqbv5ofg5gt1kbfhr0pv2mgt1', 1736482724, hex2bin('5f5f666c6173687c613a313a7b733a363a2264616e676572223b693a313b7d64616e6765727c613a313a7b733a373a226d657373616765223b733a31363a224173736574206e6f7420666f756e642e223b7d')],
            ['vb3si0k0h73bh7h57inkkr0qk4', 1736307582, hex2bin('5f5f666c6173687c613a303a7b7d')],
        ]);

        $this->batchInsert('{{%tx_staff}}', [
            'id', 'office_id', 'user_id', 'employment_id', 'title', 'initial', 'identity_number', 'phone_number', 'gender_status', 'active_status', 'address', 'file_name', 'email', 'google_plus', 'instagram', 'facebook', 'twitter', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock', 'uuid'
        ], [
            [1, 1, 1, 1, 'Randhi Satria, S.IP., M.A', 'R.S', '', '324234', 1, 1, '', '6781f4cc05f48.jpg', 'ransatriastaff.uns.ac.id', '', '', '', '', 'Dosen Hubungan Internasional Fakultas Ilmu Sosial dan Ilmu Politik Universitas Sebelas Maret Surakarta', '2020-08-14 14:43:54', '2025-01-11 11:34:21', 1, 1, 0, NULL, NULL, 15, ''],
        ]);

        $this->batchInsert('{{%tx_staff_media}}', [
            'id', 'office_id', 'staff_id', 'media_type', 'title', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock', 'uuid'
        ], [
            [1, 1, 1, 11, 'fab fa-instagram', 'ig', '2025-01-11 11:35:16', '2025-01-11 11:35:16', 1, 1, NULL, NULL, NULL, 0, '74cdc5f7cfd511ef8d58c858c0b7f92f'],
        ]);

        $this->batchInsert('{{%tx_tag}}', [
            'id', 'tag_name', 'frequency'
        ], [
            [1, 'Berita', NULL],
            [2, 'Pengumuman', NULL],
            [3, 'Event', NULL],
            [4, 'Artikel', NULL],
        ]);

        $this->batchInsert('{{%tx_token}}', [
            'user_id', 'code', 'type', 'created_at'
        ], [
            [1, 'XxnfcSJhSl93g2OskP24qV-XBKvNS9bj', 0, 1507741399],
        ]);

        $this->batchInsert('{{%tx_user}}', [
            'id', 'username', 'email', 'password_hash', 'auth_key', 'unconfirmed_email', 'registration_ip', 'flags', 'confirmed_at', 'blocked_at', 'updated_at', 'created_at', 'last_login_at', 'auth_tf_key', 'auth_tf_enabled'
        ], [
            [1, 'admin', 'ombakrinai@gmail.com', '$2y$10$oD129/e5PjrTkIV1yiR3AuOc2/XAOXLWgKPfb8svo8BdBA4PUsw3G', 'e0ee8dwDplLVaGlKGZteMSqPp1ikJFQm', NULL, '::1', 0, 1598256482, NULL, 1507741399, 1507741399, 1736565555, NULL, 0],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign keys first to avoid dependency issues
        $this->dropForeignKey('FK_tx_article_author', '{{%tx_article}}');
        $this->dropForeignKey('FK_tx_article_category', '{{%tx_article}}');
        $this->dropForeignKey('FK_tx_article_office', '{{%tx_article}}');
        $this->dropForeignKey('FK_tx_article_category_office', '{{%tx_article_category}}');
        $this->dropForeignKey('FK_tx_asset_category', '{{%tx_asset}}');
        $this->dropForeignKey('FK_tx_asset_office', '{{%tx_asset}}');
        $this->dropForeignKey('FK_tx_asset_category_office', '{{%tx_asset_category}}');
        $this->dropForeignKey('FK_tx_author_office', '{{%tx_author}}');
        $this->dropForeignKey('FK_tx_author_user', '{{%tx_author}}');
        $this->dropForeignKey('FK_tx_author_media_author', '{{%tx_author_media}}');
        $this->dropForeignKey('FK_tx_author_media_office', '{{%tx_author_media}}');
        $this->dropForeignKey('FK_tx_counter_office', '{{%tx_counter}}');
        $this->dropForeignKey('FK_tx_employment_office', '{{%tx_employment}}');
        $this->dropForeignKey('FK_tx_event_office', '{{%tx_event}}');
        $this->dropForeignKey('FK_tx_office_media_office', '{{%tx_office_media}}');
        $this->dropForeignKey('fk_profile_user', '{{%tx_profile}}');
        $this->dropForeignKey('fk_social_account_user', '{{%tx_social_account}}');
        $this->dropForeignKey('FK_tx_staff_employment', '{{%tx_staff}}');
        $this->dropForeignKey('FK_tx_staff_office', '{{%tx_staff}}');
        $this->dropForeignKey('FK_tx_staff_user', '{{%tx_staff}}');
        $this->dropForeignKey('FK_tx_staff_media_author', '{{%tx_staff_media}}');
        $this->dropForeignKey('FK_tx_staff_media_office', '{{%tx_staff_media}}');
        $this->dropForeignKey('fk_token_user', '{{%tx_token}}');

        // Drop tables in reverse order of creation
        $this->dropTable('{{%tx_tag}}');
        $this->dropTable('{{%tx_staff_media}}');
        $this->dropTable('{{%tx_staff}}');
        $this->dropTable('{{%tx_social_account}}');
        $this->dropTable('{{%tx_session}}');
        $this->dropTable('{{%tx_quote}}');
        $this->dropTable('{{%tx_profile}}');
        $this->dropTable('{{%tx_page}}');
        $this->dropTable('{{%tx_office_media}}');
        $this->dropTable('{{%tx_office}}');
        $this->dropTable('{{%tx_migration}}');
        $this->dropTable('{{%tx_event}}');
        $this->dropTable('{{%tx_employment}}');
        $this->dropTable('{{%tx_dashblock}}');
        $this->dropTable('{{%tx_counter}}');
        $this->dropTable('{{%tx_author_media}}');
        $this->dropTable('{{%tx_author}}');
        $this->dropTable('{{%tx_asset_category}}');
        $this->dropTable('{{%tx_asset}}');
        $this->dropTable('{{%tx_article_category}}');
        $this->dropTable('{{%tx_article}}');
        $this->dropTable('{{%tx_user}}'); // Drop user table last if it's the base for other FKs
    }
}
