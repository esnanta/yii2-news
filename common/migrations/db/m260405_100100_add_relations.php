<?php

use yii\db\Migration;

class m260405_100100_add_relations extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createIndex('idx-office_media-office_id', '{{%office_media}}', 'office_id');

        $this->createIndex('idx-asset-office_id', '{{%asset}}', 'office_id');
        $this->createIndex('idx-asset-asset_category_id', '{{%asset}}', 'asset_category_id');

        $this->createIndex('idx-asset_category-office_id', '{{%asset_category}}', 'office_id');

        $this->createIndex('idx-author-office_id', '{{%author}}', 'office_id');
        $this->createIndex('idx-author-user_id', '{{%author}}', 'user_id');

        $this->createIndex('idx-author_media-office_id', '{{%author_media}}', 'office_id');
        $this->createIndex('idx-author_media-author_id', '{{%author_media}}', 'author_id');

        $this->addForeignKey('fk-office_media-office_id', '{{%office_media}}', 'office_id', '{{%office}}', 'id');

        $this->addForeignKey('fk-asset-office_id', '{{%asset}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-asset-asset_category_id', '{{%asset}}', 'asset_category_id', '{{%asset_category}}', 'id');

        $this->addForeignKey('fk-asset_category-office_id', '{{%asset_category}}', 'office_id', '{{%office}}', 'id');

        $this->addForeignKey('fk-author-office_id', '{{%author}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-author-user_id', '{{%author}}', 'user_id', '{{%user}}', 'id');

        $this->addForeignKey('fk-author_media-office_id', '{{%author_media}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-author_media-author_id', '{{%author_media}}', 'author_id', '{{%author}}', 'id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-author_media-author_id', '{{%author_media}}');
        $this->dropForeignKey('fk-author_media-office_id', '{{%author_media}}');

        $this->dropForeignKey('fk-author-user_id', '{{%author}}');
        $this->dropForeignKey('fk-author-office_id', '{{%author}}');

        $this->dropForeignKey('fk-asset_category-office_id', '{{%asset_category}}');

        $this->dropForeignKey('fk-asset-asset_category_id', '{{%asset}}');
        $this->dropForeignKey('fk-asset-office_id', '{{%asset}}');

        $this->dropForeignKey('fk-office_media-office_id', '{{%office_media}}');

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

