<?php

use yii\db\Migration;

/**
 * Class m250111_053600_create_all_news_tables
 * This migration creates all tables based on the provided yii2-news.sql dump.
 * RBAC tables are ignored as per the request.
 *
 * Fixes:
 * - Removed 'tx_' table prefix, assuming it's handled by db config.
 * - Replaced invalid tinyText() method with text().
 * - Removed per-column CHARACTER SET definitions to fix SQL syntax errors and standardized table options.
 */
class m250111_053600_create_all_news_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //-- Table: office
        $this->createTable('{{%office}}', [
            'id' => $this->primaryKey(),
            'unique_id' => $this->string(15)->null(),
            'title' => $this->string(100)->null(),
            'phone_number' => $this->string(100)->null(),
            'fax_number' => $this->string(100)->null(),
            'email' => $this->string(100)->null(),
            'web' => $this->string(100)->null(),
            'address' => $this->string(100)->null(),
            'latitude' => $this->string(100)->null(),
            'longitude' => $this->string(100)->null(),
            'description' => $this->text()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: user
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'password_hash' => $this->string(60)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'unconfirmed_email' => $this->string(255)->null(),
            'registration_ip' => $this->string(45)->null(),
            'flags' => $this->integer()->notNull()->defaultValue(0),
            'confirmed_at' => $this->integer()->null(),
            'blocked_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'last_login_at' => $this->integer()->null(),
            'auth_tf_key' => $this->string(16)->null(),
            'auth_tf_enabled' => $this->tinyInteger(1)->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('idx_user_username', '{{%user}}', 'username', true);
        $this->createIndex('idx_user_email', '{{%user}}', 'email', true);

        //-- Table: employment
        $this->createTable('{{%employment}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'title' => $this->string(100)->null(),
            'description' => $this->text()->null(),
            'sequence' => $this->tinyInteger(4)->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);
        $this->createIndex('job_title_name_UNIQUE', '{{%employment}}', 'title', true);

        //-- Table: staff
        $this->createTable('{{%staff}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'user_id' => $this->integer()->null(),
            'employment_id' => $this->integer()->null(),
            'title' => $this->string(100)->null(),
            'initial' => $this->string(10)->notNull(),
            'identity_number' => $this->string(100)->null(),
            'phone_number' => $this->string(50)->null(),
            'gender_status' => $this->integer()->null(),
            'active_status' => $this->integer()->null(),
            'address' => $this->text()->null(),
            'file_name' => $this->string(200)->null(),
            'email' => $this->string(100)->null(),
            'google_plus' => $this->string(100)->null(),
            'instagram' => $this->string(100)->null(),
            'facebook' => $this->string(100)->null(),
            'twitter' => $this->string(100)->null(),
            'description' => $this->text()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: staff_media
        $this->createTable('{{%staff_media}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'staff_id' => $this->integer()->null(),
            'media_type' => $this->integer()->null(),
            'title' => $this->string(100)->null(),
            'description' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: profile
        $this->createTable('{{%profile}}', [
            'user_id' => $this->primaryKey(),
            'name' => $this->string(255)->null(),
            'public_email' => $this->string(255)->null(),
            'gravatar_email' => $this->string(255)->null(),
            'gravatar_id' => $this->string(32)->null(),
            'location' => $this->string(255)->null(),
            'website' => $this->string(255)->null(),
            'timezone' => $this->string(40)->null(),
            'bio' => $this->text()->null(),
            'file_name' => $this->string(200)->null(),
        ], $tableOptions);

        //-- Table: author
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'user_id' => $this->integer()->null(),
            'title' => $this->string(100)->null(),
            'phone_number' => $this->string(50)->null(),
            'email' => $this->string(100)->null(),
            'file_name' => $this->string(100)->null(),
            'address' => $this->text()->null(),
            'description' => $this->text()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: article_category
        $this->createTable('{{%article_category}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'title' => $this->string(100)->null(),
            'label' => $this->string(20)->null(),
            'sequence' => $this->integer()->null(),
            'description' => $this->text()->null(),
            'time_line' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: article
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'article_category_id' => $this->integer()->null(),
            'author_id' => $this->integer()->null(),
            'title' => $this->string(200)->null(),
            'cover' => $this->string(300)->null(),
            'url' => $this->string(300)->null(),
            'content' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'description' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'tags' => $this->text()->null(),
            'publish_status' => $this->integer()->null(),
            'pinned_status' => $this->integer()->null(),
            'view_counter' => $this->integer()->null(),
            'rating' => $this->float()->null(),
            'date_issued' => $this->date()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: asset_category
        $this->createTable('{{%asset_category}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'title' => $this->string(200)->null(),
            'sequence' => $this->integer()->null(),
            'description' => $this->text()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: asset
        $this->createTable('{{%asset}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'is_visible' => $this->integer()->null(),
            'asset_type' => $this->integer()->null(),
            'asset_group' => $this->integer()->null(),
            'asset_category_id' => $this->integer()->null(),
            'title' => $this->string(200)->null(),
            'date_issued' => $this->date()->null(),
            'asset_name' => $this->string(100)->null(),
            'asset_url' => $this->string(500)->null(),
            'size' => $this->integer()->null(),
            'mime_type' => $this->string(100)->null(),
            'view_counter' => $this->integer()->null(),
            'download_counter' => $this->integer()->null(),
            'description' => $this->text()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: author_media
        $this->createTable('{{%author_media}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'author_id' => $this->integer()->null(),
            'media_type' => $this->integer()->null(),
            'title' => $this->string(100)->null(),
            'description' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: counter
        $this->createTable('{{%counter}}', [
            'id' => $this->string(8)->notNull(),
            'office_id' => $this->integer()->null(),
            'counter' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);
        $this->addPrimaryKey('PK_counter', '{{%counter}}', 'id');

        //-- Table: dashblock
        $this->createTable('{{%dashblock}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(255)->notNull()->defaultValue(''),
            'actions' => $this->text()->null(),
            'weight' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'status' => $this->tinyInteger(4)->unsigned()->notNull()->defaultValue(1),
        ], $tableOptions);

        //-- Table: event
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'title' => $this->string(200)->null(),
            'date_start' => $this->dateTime()->null(),
            'date_end' => $this->dateTime()->null(),
            'location' => $this->text()->null(),
            'content' => $this->text()->null(),
            'view_counter' => $this->integer()->null(),
            'description' => $this->text()->null(),
            'is_active' => $this->tinyInteger(1)->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: office_media
        $this->createTable('{{%office_media}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->null(),
            'media_type' => $this->integer()->null(),
            'title' => $this->string(100)->null(),
            'description' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: page
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'page_type' => $this->integer()->null(),
            'title' => $this->string(100)->null(),
            'content' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'description' => $this->text()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: quote
        $this->createTable('{{%quote}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->null(),
            'content' => $this->text()->null(),
            'source' => $this->string(100)->null(),
            'file_name' => $this->string(200)->null(),
            'description' => $this->text()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'is_deleted' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
            'deleted_by' => $this->integer()->null(),
            'verlock' => $this->bigInteger()->null(),
            'uuid' => $this->string(36)->null(),
        ], $tableOptions);

        //-- Table: session
        $this->createTable('{{%session}}', [
            'id' => $this->char(32)->notNull(),
            'expire' => $this->integer()->null(),
            'data' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longblob'),
        ], $tableOptions);
        $this->addPrimaryKey('PK_session', '{{%session}}', 'id');

        //-- Table: social_account
        $this->createTable('{{%social_account}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'provider' => $this->string(255)->notNull(),
            'client_id' => $this->string(255)->notNull(),
            'code' => $this->string(32)->null(),
            'email' => $this->string(255)->null(),
            'username' => $this->string(255)->null(),
            'data' => $this->text()->null(),
            'created_at' => $this->integer()->null(),
        ], $tableOptions);
        $this->createIndex('idx_social_account_provider_client_id', '{{%social_account}}', ['provider', 'client_id'], true);
        $this->createIndex('idx_social_account_code', '{{%social_account}}', 'code', true);

        //-- Table: tag
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'tag_name' => $this->string(150)->notNull(),
            'frequency' => $this->integer()->null(),
        ], $tableOptions);

        //-- Table: token
        $this->createTable('{{%token}}', [
            'user_id' => $this->integer()->null(),
            'code' => $this->string(32)->notNull(),
            'type' => $this->smallInteger(6)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('idx_token_user_id_code_type', '{{%token}}', ['user_id', 'code', 'type'], true);

        //======================================================================
        // FOREIGN KEYS & INDEXES
        //======================================================================

        //-- FKs for employment
        $this->addForeignKey('FK_employment_office', '{{%employment}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for staff
        $this->addForeignKey('FK_staff_office', '{{%staff}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_staff_user', '{{%staff}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_staff_employment', '{{%staff}}', 'employment_id', '{{%employment}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('FK_staff_gender', '{{%staff}}', 'gender_status');

        //-- FKs for staff_media
        $this->addForeignKey('FK_staff_media_office', '{{%staff_media}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_staff_media_author', '{{%staff_media}}', 'staff_id', '{{%staff}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for profile
        $this->addForeignKey('fk_profile_user', '{{%profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for author
        $this->addForeignKey('FK_author_office', '{{%author}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_author_user', '{{%author}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for article_category
        $this->addForeignKey('FK_article_category_office', '{{%article_category}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for article
        $this->addForeignKey('FK_article_office', '{{%article}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_article_category', '{{%article}}', 'article_category_id', '{{%article_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_article_author', '{{%article}}', 'author_id', '{{%author}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for asset_category
        $this->addForeignKey('FK_asset_category_office', '{{%asset_category}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for asset
        $this->addForeignKey('FK_asset_office', '{{%asset}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_asset_category', '{{%asset}}', 'asset_category_id', '{{%asset_category}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for author_media
        $this->addForeignKey('FK_author_media_office', '{{%author_media}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_author_media_author', '{{%author_media}}', 'author_id', '{{%author}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for counter
        $this->addForeignKey('FK_counter_office', '{{%counter}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for event
        $this->addForeignKey('FK_event_office', '{{%event}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for office_media
        $this->addForeignKey('FK_office_media_office', '{{%office_media}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for social_account
        $this->addForeignKey('fk_social_account_user', '{{%social_account}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        //-- FKs for token
        $this->addForeignKey('fk_token_user', '{{%token}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        //======================================================================
        // INSERTING DATA
        //======================================================================

        //-- Data for office
        $this->insert('{{%office}}', [
            'id' => 1,
            'unique_id' => '66a1250c9bdb4',
            'title' => 'Hubungan Internasional',
            'phone_number' => '081226993704',
            'fax_number' => '45635345',
            'email' => 'hubunganinternasional.id@gmail.com',
            'web' => 'hubunganinternasional.id',
            'address' => 'Bantul, Yogyakarta',
            'latitude' => '',
            'longitude' => '',
            'description' => '-',
            'created_at' => '2015-05-02 10:17:07',
            'updated_at' => '2024-07-24 23:02:59',
            'created_by' => 1,
            'updated_by' => 1,
            'is_deleted' => 0,
            'verlock' => 14,
            'uuid' => ''
        ]);

        //-- Data for user
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'email' => 'ombakrinai@gmail.com',
            'password_hash' => '$2y$10$oD129/e5PjrTkIV1yiR3AuOc2/XAOXLWgKPfb8svo8BdBA4PUsw3G',
            'auth_key' => 'e0ee8dwDplLVaGlKGZteMSqPp1ikJFQm',
            'registration_ip' => '::1',
            'confirmed_at' => 1598256482,
            'updated_at' => 1507741399,
            'created_at' => 1507741399,
            'last_login_at' => 1736565555,
        ]);

        //-- Data for profile
        $this->insert('{{%profile}}', [
            'user_id' => 1,
            'name' => 'Nanta Es',
            'public_email' => 'ombakrinai@gmail.com',
            'gravatar_email' => '',
            'gravatar_id' => 'd41d8cd98f00b204e9800998ecf8427e',
            'location' => 'Lhokseumawe',
            'website' => 'https://escyber.com/',
            'bio' => '-',
            'file_name' => ''
        ]);

        //-- Data for employment
        $this->insert('{{%employment}}', [
            'id' => 1,
            'office_id' => 1,
            'title' => 'Developer',
            'description' => '',
            'sequence' => 1,
            'created_at' => '2015-09-01 20:38:25',
            'updated_at' => '2020-08-14 14:46:07',
            'created_by' => 1,
            'updated_by' => 1,
            'verlock' => 4,
            'uuid' => ''
        ]);

        //-- Data for staff
        $this->insert('{{%staff}}', [
            'id' => 1,
            'office_id' => 1,
            'user_id' => 1,
            'employment_id' => 1,
            'title' => 'Name Here',
            'initial' => 'R.S',
            'identity_number' => '',
            'phone_number' => '324234',
            'gender_status' => 1,
            'active_status' => 1,
            'address' => '',
            'file_name' => '6781f4cc05f48.jpg',
            'email' => '',
            'google_plus' => '',
            'instagram' => '',
            'facebook' => '',
            'twitter' => '',
            'description' => '',
            'created_at' => '2020-08-14 14:43:54',
            'updated_at' => '2025-01-11 11:34:21',
            'created_by' => 1,
            'updated_by' => 1,
            'is_deleted' => 0,
            'verlock' => 15,
            'uuid' => ''
        ]);

        //-- Data for staff_media
        $this->insert('{{%staff_media}}', [
            'id' => 1,
            'office_id' => 1,
            'staff_id' => 1,
            'media_type' => 11,
            'title' => 'fab fa-instagram',
            'description' => 'ig',
            'created_at' => '2025-01-11 11:35:16',
            'updated_at' => '2025-01-11 11:35:16',
            'created_by' => 1,
            'updated_by' => 1,
            'verlock' => 0,
            'uuid' => '74cdc5f7cfd511ef8d58c858c0b7f92f'
        ]);

        //-- Data for author
        $this->insert('{{%author}}', [
            'id' => 1,
            'title' => 'Admin',
            'email' => 'hubunganinternasional.id@gmail.com',
            'file_name' => 'qqWkyzDJaNIAC7uPjV4E4B12Ul0J9R7c.jpg',
            'created_at' => '2018-06-12 15:43:58',
            'updated_at' => '2019-08-14 10:34:00',
            'created_by' => 1,
            'updated_by' => 1,
            'verlock' => 3,
            'uuid' => ''
        ]);

        //-- Data for asset_category
        $this->insert('{{%asset_category}}', [
            'id' => 1,
            'office_id' => 1,
            'title' => 'test',
            'sequence' => 1,
            'description' => '',
            'created_at' => '2025-01-08 10:12:19',
            'updated_at' => '2025-01-08 10:12:19',
            'created_by' => 1,
            'updated_by' => 1,
            'verlock' => 0,
            'uuid' => '5ed0d057cd6e11efaa70c858c0b7f92f'
        ]);

        //-- Data for asset
        $this->batchInsert('{{%asset}}',
            ['id', 'office_id', 'is_visible', 'asset_type', 'asset_category_id', 'title', 'date_issued', 'asset_name', 'asset_url', 'view_counter', 'download_counter', 'description', 'created_at', 'updated_at', 'created_by', 'verlock', 'uuid'],
            [
                [4, 1, 2, 3, 1, 'Jalan Sunyi Seorang Seniman', '2025-01-08', 'Jalan_Sunyi_Seorang_Seniman_677df5729a145.png', '/app/yii2-news/admin/images/no-picture-available-icon-1.jpg', 0, 3, '', '2025-01-08 10:48:02', '2025-01-08 11:09:42', 1, 3, '5c5d4f93cd7311efaa70c858c0b7f92f'],
                [5, 1, 2, 1, 1, 'Gambar Article', '2025-01-08', 'Gambar_Article_677df58a659ef.pdf', '/app/yii2-news/admin/images/no-picture-available-icon-1.jpg', 0, 3, '', '2025-01-08 10:48:26', '2025-01-08 11:09:40', 1, 3, '6a8aab6ecd7311efaa70c858c0b7f92f'],
                [6, 1, 2, 2, 1, 'tes pdf', '2025-01-08', 'tes_pdf_677df82133b47.xlsx', '/app/yii2-news/admin/images/no-picture-available-icon-1.jpg', 0, 0, '-', '2025-01-08 10:59:29', '2025-01-08 10:59:29', 1, 0, 'f5995e14cd7411efaa70c858c0b7f92f'],
            ]
        );

        //-- Data for page
        $this->batchInsert('{{%page}}',
            ['id', 'page_type', 'title', 'content', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by', 'verlock', 'uuid'],
            [
                [1, 2, 'Logo 1', '<p><img style=\"width: 103px;\" src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGcAAAAnCAYAAAASGVaVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3YTJkN2YzYS0xNGQxLTQyODQtYmYwZC00MGUxZTJkMjNjOGYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6ODcxNjQ4RjBEMDI5MTFFNjhFOUZCNTlCN0ZERTdEREIiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ODcxNjQ4RUZEMDI5MTFFNjhFOUZCNTlCN0ZERTdEREIiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo3YTJkN2YzYS0xNGQxLTQyODQtYmYwZC00MGUxZTJkMjNjOGYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6N2EyZDdmM2EtMTRkMS00Mjg0LWJmMGQtNDBlMWUyZDIzYzhm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\" data-filename=\"logo-1.png\"><br></p>', 'Logo 1 - Bagian Atas Kiri', '2018-01-08 21:47:15', '2024-08-18 15:55:56', 1, 1, 0, ''],
                [2, 2, 'Logo 2', '<p><img style=\"width: 200px;\" src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAAAnCAYAAABKSgfJAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDE0IDc5LjE1Njc5NywgMjAxNC8wOC8yMC0wOTo1MzowMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MERFMUI5RERGNTlGMTFFNDk4QTZDQjA2OEIzQTJBRUUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MERFMUI5REVGNTlGMTFFNDk4QTZDQjA2OEIzQTJBRUUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDowREUxQjlEQkY1OUYxMUU0OThBNkNCMDY4QjNBMkFFRSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDowREUxQjlEQ0Y1OUYxMUU0OThBNkNCMDY4QjNBMkFFRSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PoaoddcAAA6SSURBVHja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\" data-filename=\"logo-14.png\"><br></p>', 'Logo 2 - Bagian Bawah Kiri', '2018-01-08 21:47:15', '2024-08-18 15:55:41', 1, 1, 0, ''],
                [3, 2, 'Logo Report 1', 'b3MYTwJeYCkb4IUmLrPkjcePntzALUBi.png', 'Logo 1 - Bagian Atas Kiri', '2018-01-08 21:47:15', '2018-01-08 21:47:15', 1, 1, 0, ''],
                [4, 2, 'Logo Report 2', 'q8Z7e_TqQrBwU8URdcZ4I7t62u3-EHCm.png', 'NA', '2018-01-08 21:47:15', '2018-01-08 21:47:15', 1, 1, 0, ''],
                [11, 1, 'SEO Description', '<p>seo description here testing<br></p>', 'SEO Description', '2018-01-08 21:47:15', '2024-08-18 16:11:04', 1, 1, 1, ''],
                [12, 1, 'SEO Keyword', '<p>seo, keyword, for, my, site<br></p>', 'SEO Keyword', '2018-01-08 21:47:15', '2024-08-18 16:11:20', 1, 1, 1, ''],
                [21, 1, 'About', 'VD6pJHgk7ikBhHW6gmW59mfrWLQhjpFx.png', 'Donec id elit y DESCRIPTION.', '2017-12-02 22:33:55', '2017-12-02 22:39:25', 1, 1, 0, '']
            ]
        );

        //-- Data for token
        $this->insert('{{%token}}', [
            'user_id' => 1,
            'code' => 'XxnfcSJhSl93g2OskP24qV-XBKvNS9bj',
            'type' => 0,
            'created_at' => 1507741399
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop in reverse order of creation due to foreign key constraints.

        // Drop FKs first
        $this->dropForeignKey('fk_token_user', '{{%token}}');
        $this->dropForeignKey('fk_social_account_user', '{{%social_account}}');
        $this->dropForeignKey('FK_office_media_office', '{{%office_media}}');
        $this->dropForeignKey('FK_event_office', '{{%event}}');
        $this->dropForeignKey('FK_counter_office', '{{%counter}}');
        $this->dropForeignKey('FK_author_media_office', '{{%author_media}}');
        $this->dropForeignKey('FK_author_media_author', '{{%author_media}}');
        $this->dropForeignKey('FK_asset_office', '{{%asset}}');
        $this->dropForeignKey('FK_asset_category', '{{%asset}}');
        $this->dropForeignKey('FK_asset_category_office', '{{%asset_category}}');
        $this->dropForeignKey('FK_article_office', '{{%article}}');
        $this->dropForeignKey('FK_article_category', '{{%article}}');
        $this->dropForeignKey('FK_article_author', '{{%article}}');
        $this->dropForeignKey('FK_article_category_office', '{{%article_category}}');
        $this->dropForeignKey('FK_author_office', '{{%author}}');
        $this->dropForeignKey('FK_author_user', '{{%author}}');
        $this->dropForeignKey('fk_profile_user', '{{%profile}}');
        $this->dropForeignKey('FK_staff_media_office', '{{%staff_media}}');
        $this->dropForeignKey('FK_staff_media_author', '{{%staff_media}}');
        $this->dropForeignKey('FK_staff_office', '{{%staff}}');
        $this->dropForeignKey('FK_staff_user', '{{%staff}}');
        $this->dropForeignKey('FK_staff_employment', '{{%staff}}');
        $this->dropForeignKey('FK_employment_office', '{{%employment}}');

        // Drop tables
        $this->dropTable('{{%token}}');
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%social_account}}');
        $this->dropTable('{{%session}}');
        $this->dropTable('{{%quote}}');
        $this->dropTable('{{%page}}');
        $this->dropTable('{{%office_media}}');
        $this->dropTable('{{%event}}');
        $this->dropTable('{{%dashblock}}');
        $this->dropTable('{{%counter}}');
        $this->dropTable('{{%author_media}}');
        $this->dropTable('{{%asset}}');
        $this->dropTable('{{%asset_category}}');
        $this->dropTable('{{%article}}');
        $this->dropTable('{{%article_category}}');
        $this->dropTable('{{%author}}');
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%staff_media}}');
        $this->dropTable('{{%staff}}');
        $this->dropTable('{{%employment}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%office}}');
    }
}