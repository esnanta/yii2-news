<?php

use yii\db\Migration;

class m260412_130700_add_article_visibility_index extends Migration
{
    public function safeUp()
    {
        if ($this->indexExists('{{%article}}', 'idx-article-visibility-published')) {
            return;
        }

        $this->createIndex(
            'idx-article-visibility-published',
            '{{%article}}',
            ['is_deleted', 'status', 'published_at']
        );
    }

    public function safeDown()
    {
        if (!$this->indexExists('{{%article}}', 'idx-article-visibility-published')) {
            return;
        }

        $this->dropIndex('idx-article-visibility-published', '{{%article}}');
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $tableName = $this->db->schema->getRawTableName($table);
        $schemaName = $this->db->schema->defaultSchema;

        $index = (new \yii\db\Query())
            ->from('information_schema.statistics')
            ->where([
                'table_schema' => $schemaName,
                'table_name' => $tableName,
                'index_name' => $indexName,
            ])
            ->one($this->db);

        return $index !== false;
    }
}

