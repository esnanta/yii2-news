<?php

use yii\db\Migration;

class m260412_130700_add_article_visibility_index extends Migration
{
    public function safeUp()
    {
        $this->createIndex(
            'idx-article-visibility-published',
            '{{%article}}',
            ['is_deleted', 'status', 'published_at']
        );
    }

    public function safeDown()
    {
        $this->dropIndex('idx-article-visibility-published', '{{%article}}');
    }
}

