<?php

use yii\db\Migration;

class m260412_100600_create_tag_and_add_article_tag extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        // Compatibility path:
        // - fresh install: artifacts already created by older timestamped migrations
        // - incremental install: create missing artifacts only
        if ($this->db->schema->getTableSchema('{{%tag}}', true) === null) {
            $this->createTable('{{%tag}}', [
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
        }

        if ($this->db->schema->getTableSchema('{{%article_tag}}', true) !== null) {
            return;
        }

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
            '{{%tag}}',
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
        // No-op rollback: tag and article_tag are now owned by earlier core news migrations.
    }
}

