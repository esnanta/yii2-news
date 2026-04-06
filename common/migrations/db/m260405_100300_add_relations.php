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

        $this->createIndex('idx-office_media-office_id', '{{%office_media}}', 'office_id');

        $this->createIndex('idx-asset-office_id', '{{%asset}}', 'office_id');
        $this->createIndex('idx-asset-asset_category_id', '{{%asset}}', 'asset_category_id');

        $this->createIndex('idx-asset_category-office_id', '{{%asset_category}}', 'office_id');

        $this->createIndex('idx-author-office_id', '{{%author}}', 'office_id');
        $this->createIndex('idx-author-user_id', '{{%author}}', 'user_id');

        $this->createIndex('idx-author_media-office_id', '{{%author_media}}', 'office_id');
        $this->createIndex('idx-author_media-author_id', '{{%author_media}}', 'author_id');

        $this->createIndex('idx-employment-office_id', '{{%employment}}', 'office_id');

        $this->createIndex('idx-staff-office_id', '{{%staff}}', 'office_id');
        $this->createIndex('idx-staff-user_id', '{{%staff}}', 'user_id');
        $this->createIndex(
            'idx-staff-employment_id',
            '{{%staff}}',
            'employment_id'
        );

        $this->createIndex('idx-staff_media-office_id', '{{%staff_media}}', 'office_id');
        $this->createIndex('idx-staff_media-staff_id', '{{%staff_media}}', 'staff_id');

        // Add foreign keys after all index artifacts are ready.
        $this->addForeignKey('fk-article-author_id', '{{%article}}', 'author_id', '{{%author}}', 'id');

        $this->addForeignKey('fk-office_media-office_id', '{{%office_media}}', 'office_id', '{{%office}}', 'id');

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

        $this->addForeignKey('fk-author_media-office_id', '{{%author_media}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-author_media-author_id', '{{%author_media}}', 'author_id', '{{%author}}', 'id');

        $this->addForeignKey('fk-employment-office_id', '{{%employment}}', 'office_id', '{{%office}}', 'id');

        $this->addForeignKey('fk-staff-office_id', '{{%staff}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-staff-user_id', '{{%staff}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk-staff-employment_id', '{{%staff}}', 'employment_id', '{{%employment}}', 'id');

        $this->addForeignKey('fk-staff_media-office_id', '{{%staff_media}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-staff_media-staff_id', '{{%staff_media}}', 'staff_id', '{{%staff}}', 'id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        // Roll back constraints first, then supporting indexes.
        $this->dropForeignKey('fk-article-author_id', '{{%article}}');

        $this->dropForeignKey('fk-staff_media-staff_id', '{{%staff_media}}');
        $this->dropForeignKey('fk-staff_media-office_id', '{{%staff_media}}');

        $this->dropForeignKey('fk-staff-employment_id', '{{%staff}}');
        $this->dropForeignKey('fk-staff-user_id', '{{%staff}}');
        $this->dropForeignKey('fk-staff-office_id', '{{%staff}}');

        $this->dropForeignKey('fk-employment-office_id', '{{%employment}}');

        $this->dropForeignKey('fk-author_media-author_id', '{{%author_media}}');
        $this->dropForeignKey('fk-author_media-office_id', '{{%author_media}}');

        $this->dropForeignKey('fk-author-user_id', '{{%author}}');
        $this->dropForeignKey('fk-author-office_id', '{{%author}}');

        $this->dropForeignKey('fk-asset_category-office_id', '{{%asset_category}}');

        $this->dropForeignKey('fk-asset-asset_category_id', '{{%asset}}');
        $this->dropForeignKey('fk-asset-office_id', '{{%asset}}');

        $this->dropForeignKey('fk-office_media-office_id', '{{%office_media}}');

        $this->dropIndex('idx-article-author_id', '{{%article}}');


        $this->dropIndex('idx-staff_media-staff_id', '{{%staff_media}}');
        $this->dropIndex('idx-staff_media-office_id', '{{%staff_media}}');

        $this->dropIndex('idx-staff-employment_id', '{{%staff}}');
        $this->dropIndex('idx-staff-user_id', '{{%staff}}');
        $this->dropIndex('idx-staff-office_id', '{{%staff}}');

        $this->dropIndex('idx-employment-office_id', '{{%employment}}');

        $this->dropIndex('idx-author_media-author_id', '{{%author_media}}');
        $this->dropIndex('idx-author_media-office_id', '{{%author_media}}');

        $this->dropIndex('idx-author-user_id', '{{%author}}');
        $this->dropIndex('idx-author-office_id', '{{%author}}');

        $this->dropIndex('idx-asset_category-office_id', '{{%asset_category}}');

        $this->dropIndex('idx-asset-asset_category_id', '{{%asset}}');
        $this->dropIndex('idx-asset-office_id', '{{%asset}}');

        $this->dropIndex('idx-office_media-office_id', '{{%office_media}}');
    }
}

