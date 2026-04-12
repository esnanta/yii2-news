<?php

use yii\db\Migration;

class m260412_100600_create_tags_and_add_article_tags extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
            'slug' => $this->string(100),
            'frequency' => $this->integer()->notNull()->defaultValue(0),
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

        $this->createIndex('idx-tags-title', '{{%tags}}', 'title');
        $this->createIndex('uq-tags-slug', '{{%tags}}', 'slug', true);

        $this->createTable('{{%article_tag}}', [
            'article_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-article_tag', '{{%article_tag}}', ['article_id', 'tag_id']);
        $this->createIndex('idx-article_tag-article_id', '{{%article_tag}}', 'article_id');
        $this->createIndex('idx-article_tag-tag_id', '{{%article_tag}}', 'tag_id');

        $this->addForeignKey(
            'fk-article_tag-article_id',
            '{{%article_tag}}',
            'article_id',
            '{{%article}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-article_tag-tag_id',
            '{{%article_tag}}',
            'tag_id',
            '{{%tags}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-article_tag-tag_id', '{{%article_tag}}');
        $this->dropForeignKey('fk-article_tag-article_id', '{{%article_tag}}');

        $this->dropIndex('idx-article_tag-tag_id', '{{%article_tag}}');
        $this->dropIndex('idx-article_tag-article_id', '{{%article_tag}}');
        $this->dropPrimaryKey('pk-article_tag', '{{%article_tag}}');
        $this->dropTable('{{%article_tag}}');

        $this->dropIndex('uq-tags-slug', '{{%tags}}');
        $this->dropIndex('idx-tags-title', '{{%tags}}');
        $this->dropTable('{{%tags}}');
    }
}

