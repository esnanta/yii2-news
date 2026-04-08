<?php

use yii\db\Migration;

class m260405_100300_add_relations extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        // Add indexes first to support foreign-key creation.
        $this->createIndex('idx-article-author_id', '{{%article}}', 'author_id');

        $this->createIndex('idx-social_platform-code', '{{%social_platform}}', 'code', true);

        $this->createIndex('idx-office_social_account-office_id', '{{%office_social_account}}', 'office_id');
        $this->createIndex('idx-office_social_account-platform_id', '{{%office_social_account}}', 'platform_id');
        $this->createIndex(
            'uq-office_social_account-office_id-platform_id',
            '{{%office_social_account}}',
            ['office_id', 'platform_id'],
            true
        );

        $this->createIndex('idx-asset-office_id', '{{%asset}}', 'office_id');
        $this->createIndex('idx-asset-asset_category_id', '{{%asset}}', 'asset_category_id');

        $this->createIndex('idx-asset_category-office_id', '{{%asset_category}}', 'office_id');

        $this->createIndex('idx-author-office_id', '{{%author}}', 'office_id');
        $this->createIndex('idx-author-user_id', '{{%author}}', 'user_id');

        $this->createIndex('idx-author_social_account-office_id', '{{%author_social_account}}', 'office_id');
        $this->createIndex('idx-author_social_account-author_id', '{{%author_social_account}}', 'author_id');
        $this->createIndex('idx-author_social_account-platform_id', '{{%author_social_account}}', 'platform_id');
        $this->createIndex(
            'uq-author_social_account-author_id-platform_id',
            '{{%author_social_account}}',
            ['author_id', 'platform_id'],
            true
        );

        $this->createIndex('idx-employment-office_id', '{{%employment}}', 'office_id');

        $this->createIndex('idx-staff-office_id', '{{%staff}}', 'office_id');
        $this->createIndex('idx-staff-user_id', '{{%staff}}', 'user_id');
        $this->createIndex(
            'idx-staff-employment_id',
            '{{%staff}}',
            'employment_id'
        );

        $this->createIndex('idx-staff_social_account-office_id', '{{%staff_social_account}}', 'office_id');
        $this->createIndex('idx-staff_social_account-staff_id', '{{%staff_social_account}}', 'staff_id');
        $this->createIndex('idx-staff_social_account-platform_id', '{{%staff_social_account}}', 'platform_id');
        $this->createIndex(
            'uq-staff_social_account-staff_id-platform_id',
            '{{%staff_social_account}}',
            ['staff_id', 'platform_id'],
            true
        );

        // Add foreign keys after all index artifacts are ready.
        $this->addForeignKey('fk-article-author_id', '{{%article}}', 'author_id', '{{%author}}', 'id');

        $this->addForeignKey('fk-office_social_account-office_id', '{{%office_social_account}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey(
            'fk-office_social_account-platform_id',
            '{{%office_social_account}}',
            'platform_id',
            '{{%social_platform}}',
            'id'
        );

        $this->addForeignKey('fk-asset-office_id', '{{%asset}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey(
            'fk-asset-asset_category_id',
            '{{%asset}}',
            'asset_category_id',
            '{{%asset_category}}',
            'id'
        );

        $this->addForeignKey('fk-asset_category-office_id', '{{%asset_category}}', 'office_id', '{{%office}}', 'id');

        $this->addForeignKey('fk-author-office_id', '{{%author}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-author-user_id', '{{%author}}', 'user_id', '{{%user}}', 'id');

        $this->addForeignKey('fk-author_social_account-office_id', '{{%author_social_account}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-author_social_account-author_id', '{{%author_social_account}}', 'author_id', '{{%author}}', 'id');
        $this->addForeignKey(
            'fk-author_social_account-platform_id',
            '{{%author_social_account}}',
            'platform_id',
            '{{%social_platform}}',
            'id'
        );

        $this->addForeignKey('fk-employment-office_id', '{{%employment}}', 'office_id', '{{%office}}', 'id');

        $this->addForeignKey('fk-staff-office_id', '{{%staff}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-staff-user_id', '{{%staff}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk-staff-employment_id', '{{%staff}}', 'employment_id', '{{%employment}}', 'id');

        $this->addForeignKey('fk-staff_social_account-office_id', '{{%staff_social_account}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-staff_social_account-staff_id', '{{%staff_social_account}}', 'staff_id', '{{%staff}}', 'id');
        $this->addForeignKey(
            'fk-staff_social_account-platform_id',
            '{{%staff_social_account}}',
            'platform_id',
            '{{%social_platform}}',
            'id'
        );
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        // Roll back constraints first, then supporting indexes.
        $this->dropForeignKey('fk-article-author_id', '{{%article}}');

        $this->dropForeignKey('fk-staff_social_account-platform_id', '{{%staff_social_account}}');
        $this->dropForeignKey('fk-staff_social_account-staff_id', '{{%staff_social_account}}');
        $this->dropForeignKey('fk-staff_social_account-office_id', '{{%staff_social_account}}');

        $this->dropForeignKey('fk-staff-employment_id', '{{%staff}}');
        $this->dropForeignKey('fk-staff-user_id', '{{%staff}}');
        $this->dropForeignKey('fk-staff-office_id', '{{%staff}}');

        $this->dropForeignKey('fk-employment-office_id', '{{%employment}}');

        $this->dropForeignKey('fk-author_social_account-platform_id', '{{%author_social_account}}');
        $this->dropForeignKey('fk-author_social_account-author_id', '{{%author_social_account}}');
        $this->dropForeignKey('fk-author_social_account-office_id', '{{%author_social_account}}');

        $this->dropForeignKey('fk-author-user_id', '{{%author}}');
        $this->dropForeignKey('fk-author-office_id', '{{%author}}');

        $this->dropForeignKey('fk-asset_category-office_id', '{{%asset_category}}');

        $this->dropForeignKey('fk-asset-asset_category_id', '{{%asset}}');
        $this->dropForeignKey('fk-asset-office_id', '{{%asset}}');

        $this->dropForeignKey('fk-office_social_account-platform_id', '{{%office_social_account}}');
        $this->dropForeignKey('fk-office_social_account-office_id', '{{%office_social_account}}');

        $this->dropIndex('idx-article-author_id', '{{%article}}');


        $this->dropIndex('uq-staff_social_account-staff_id-platform_id', '{{%staff_social_account}}');
        $this->dropIndex('idx-staff_social_account-platform_id', '{{%staff_social_account}}');
        $this->dropIndex('idx-staff_social_account-staff_id', '{{%staff_social_account}}');
        $this->dropIndex('idx-staff_social_account-office_id', '{{%staff_social_account}}');

        $this->dropIndex('idx-staff-employment_id', '{{%staff}}');
        $this->dropIndex('idx-staff-user_id', '{{%staff}}');
        $this->dropIndex('idx-staff-office_id', '{{%staff}}');

        $this->dropIndex('idx-employment-office_id', '{{%employment}}');

        $this->dropIndex('uq-author_social_account-author_id-platform_id', '{{%author_social_account}}');
        $this->dropIndex('idx-author_social_account-platform_id', '{{%author_social_account}}');
        $this->dropIndex('idx-author_social_account-author_id', '{{%author_social_account}}');
        $this->dropIndex('idx-author_social_account-office_id', '{{%author_social_account}}');

        $this->dropIndex('idx-author-user_id', '{{%author}}');
        $this->dropIndex('idx-author-office_id', '{{%author}}');

        $this->dropIndex('idx-asset_category-office_id', '{{%asset_category}}');

        $this->dropIndex('idx-asset-asset_category_id', '{{%asset}}');
        $this->dropIndex('idx-asset-office_id', '{{%asset}}');

        $this->dropIndex('uq-office_social_account-office_id-platform_id', '{{%office_social_account}}');
        $this->dropIndex('idx-office_social_account-platform_id', '{{%office_social_account}}');
        $this->dropIndex('idx-office_social_account-office_id', '{{%office_social_account}}');
        $this->dropIndex('idx-social_platform-code', '{{%social_platform}}');
    }
}

