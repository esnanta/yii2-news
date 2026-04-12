<?php

use yii\db\Migration;

class m260410_110000_backfill_article_category_deleted_by extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $tableSchema = $this->db->schema->getTableSchema('{{%article_category}}', true);
        if ($tableSchema === null) {
            return;
        }

        $requiredColumns = ['deleted_by', 'is_deleted', 'deleted_at'];
        foreach ($requiredColumns as $column) {
            if (!isset($tableSchema->columns[$column])) {
                return;
            }
        }

        $this->update('{{%article_category}}', ['deleted_by' => 0], [
            'and',
            ['deleted_by' => null],
            ['is_deleted' => 0],
            ['deleted_at' => null],
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        // Data backfill migration is intentionally irreversible.
    }
}

