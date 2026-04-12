<?php

use yii\db\Migration;

class m260420_100200_add_news_relations_and_indexes extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->dropLegacySocialPlatformOfficeRelation();

        // Indexes first.
        $this->createIndex('idx-article-author_id', '{{%article}}', 'author_id');
        $this->createIndex('idx-article-visibility-published', '{{%article}}', ['is_deleted', 'status', 'published_at']);

        $this->createIndex('idx-social_platform-code', '{{%social_platform}}', 'code', true);

        $this->createIndex('idx-tag-title', '{{%tag}}', 'title');
        $this->createIndex('uq-tag-slug', '{{%tag}}', 'slug', true);

        $this->createIndex('idx-article_tag-article_id', '{{%article_tag}}', 'article_id');
        $this->createIndex('idx-article_tag-tag_id', '{{%article_tag}}', 'tag_id');

        $this->createIndex('idx-office_social_account-office_id', '{{%office_social_account}}', 'office_id');
        $this->createIndex('idx-office_social_account-platform_id', '{{%office_social_account}}', 'platform_id');
        $this->createIndex(
            'uq-office_social_account-office_id-platform_id',
            '{{%office_social_account}}',
            ['office_id', 'platform_id'],
            true
        );

        $this->createIndex('idx-document-office_id', '{{%document}}', 'office_id');
        $this->createIndex('idx-document-document_category_id', '{{%document}}', 'category_id');

        $this->createIndex('idx-document_category-office_id', '{{%document_category}}', 'office_id');

        $this->createIndex('idx-author-office_id', '{{%author}}', 'office_id');

        $this->createIndex('idx-author_social_account-office_id', '{{%author_social_account}}', 'office_id');
        $this->createIndex('idx-author_social_account-author_id', '{{%author_social_account}}', 'author_id');
        $this->createIndex('idx-author_social_account-platform_id', '{{%author_social_account}}', 'platform_id');
        $this->createIndex(
            'uq-author_social_account-author_id-platform_id',
            '{{%author_social_account}}',
            ['author_id', 'platform_id'],
            true
        );

        $this->createIndex('idx-job_title-office_id', '{{%job_title}}', 'office_id');

        $this->createIndex('idx-staff-office_id', '{{%staff}}', 'office_id');
        $this->createIndex('idx-staff-job_title_id', '{{%staff}}', 'job_title_id');

        $this->createIndex('idx-staff_social_account-office_id', '{{%staff_social_account}}', 'office_id');
        $this->createIndex('idx-staff_social_account-staff_id', '{{%staff_social_account}}', 'staff_id');
        $this->createIndex('idx-staff_social_account-platform_id', '{{%staff_social_account}}', 'platform_id');
        $this->createIndex(
            'uq-staff_social_account-staff_id-platform_id',
            '{{%staff_social_account}}',
            ['staff_id', 'platform_id'],
            true
        );

        // Foreign keys after indexes.
        $this->addForeignKey('fk-article-author_id', '{{%article}}', 'author_id', '{{%author}}', 'id');

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

        $this->addForeignKey('fk-office_social_account-office_id', '{{%office_social_account}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-office_social_account-platform_id', '{{%office_social_account}}', 'platform_id', '{{%social_platform}}', 'id');

        $this->addForeignKey('fk-document-office_id', '{{%document}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-document-document_category_id', '{{%document}}', 'category_id', '{{%document_category}}', 'id');

        $this->addForeignKey('fk-document_category-office_id', '{{%document_category}}', 'office_id', '{{%office}}', 'id');

        $this->addForeignKey('fk-author-office_id', '{{%author}}', 'office_id', '{{%office}}', 'id');

        $this->addForeignKey('fk-author_social_account-office_id', '{{%author_social_account}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-author_social_account-author_id', '{{%author_social_account}}', 'author_id', '{{%author}}', 'id');
        $this->addForeignKey('fk-author_social_account-platform_id', '{{%author_social_account}}', 'platform_id', '{{%social_platform}}', 'id');

        $this->addForeignKey('fk-job_title-office_id', '{{%job_title}}', 'office_id', '{{%office}}', 'id');

        $this->addForeignKey('fk-staff-office_id', '{{%staff}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-staff-job_title_id', '{{%staff}}', 'job_title_id', '{{%job_title}}', 'id');

        $this->addForeignKey('fk-staff_social_account-office_id', '{{%staff_social_account}}', 'office_id', '{{%office}}', 'id');
        $this->addForeignKey('fk-staff_social_account-staff_id', '{{%staff_social_account}}', 'staff_id', '{{%staff}}', 'id');
        $this->addForeignKey('fk-staff_social_account-platform_id', '{{%staff_social_account}}', 'platform_id', '{{%social_platform}}', 'id');
    }

    /**
     * Removes legacy office ownership from social_platform if it exists.
     */
    private function dropLegacySocialPlatformOfficeRelation(): void
    {
        $tableSchema = $this->db->schema->getTableSchema('{{%social_platform}}', true);
        if ($tableSchema === null || !isset($tableSchema->columns['office_id'])) {
            return;
        }

        foreach ($tableSchema->foreignKeys as $name => $foreignKey) {
            if (is_string($name) && is_array($foreignKey) && array_key_exists('office_id', $foreignKey)) {
                $this->dropForeignKey($name, '{{%social_platform}}');
            }
        }

        $this->dropColumn('{{%social_platform}}', 'office_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-article-author_id', '{{%article}}');

        $this->dropForeignKey('fk-article_tag-tag_id', '{{%article_tag}}');
        $this->dropForeignKey('fk-article_tag-article_id', '{{%article_tag}}');

        $this->dropForeignKey('fk-staff_social_account-platform_id', '{{%staff_social_account}}');
        $this->dropForeignKey('fk-staff_social_account-staff_id', '{{%staff_social_account}}');
        $this->dropForeignKey('fk-staff_social_account-office_id', '{{%staff_social_account}}');

        $this->dropForeignKey('fk-staff-job_title_id', '{{%staff}}');
        $this->dropForeignKey('fk-staff-office_id', '{{%staff}}');

        $this->dropForeignKey('fk-job_title-office_id', '{{%job_title}}');

        $this->dropForeignKey('fk-author_social_account-platform_id', '{{%author_social_account}}');
        $this->dropForeignKey('fk-author_social_account-author_id', '{{%author_social_account}}');
        $this->dropForeignKey('fk-author_social_account-office_id', '{{%author_social_account}}');

        $this->dropForeignKey('fk-author-office_id', '{{%author}}');

        $this->dropForeignKey('fk-document_category-office_id', '{{%document_category}}');

        $this->dropForeignKey('fk-document-document_category_id', '{{%document}}');
        $this->dropForeignKey('fk-document-office_id', '{{%document}}');

        $this->dropForeignKey('fk-office_social_account-platform_id', '{{%office_social_account}}');
        $this->dropForeignKey('fk-office_social_account-office_id', '{{%office_social_account}}');

        $this->dropIndex('idx-article-visibility-published', '{{%article}}');
        $this->dropIndex('idx-article-author_id', '{{%article}}');

        $this->dropIndex('idx-article_tag-tag_id', '{{%article_tag}}');
        $this->dropIndex('idx-article_tag-article_id', '{{%article_tag}}');

        $this->dropIndex('uq-tag-slug', '{{%tag}}');
        $this->dropIndex('idx-tag-title', '{{%tag}}');

        $this->dropIndex('uq-staff_social_account-staff_id-platform_id', '{{%staff_social_account}}');
        $this->dropIndex('idx-staff_social_account-platform_id', '{{%staff_social_account}}');
        $this->dropIndex('idx-staff_social_account-staff_id', '{{%staff_social_account}}');
        $this->dropIndex('idx-staff_social_account-office_id', '{{%staff_social_account}}');

        $this->dropIndex('idx-staff-job_title_id', '{{%staff}}');
        $this->dropIndex('idx-staff-office_id', '{{%staff}}');

        $this->dropIndex('idx-job_title-office_id', '{{%job_title}}');

        $this->dropIndex('uq-author_social_account-author_id-platform_id', '{{%author_social_account}}');
        $this->dropIndex('idx-author_social_account-platform_id', '{{%author_social_account}}');
        $this->dropIndex('idx-author_social_account-author_id', '{{%author_social_account}}');
        $this->dropIndex('idx-author_social_account-office_id', '{{%author_social_account}}');

        $this->dropIndex('idx-author-office_id', '{{%author}}');

        $this->dropIndex('idx-document_category-office_id', '{{%document_category}}');

        $this->dropIndex('idx-document-document_category_id', '{{%document}}');
        $this->dropIndex('idx-document-office_id', '{{%document}}');

        $this->dropIndex('uq-office_social_account-office_id-platform_id', '{{%office_social_account}}');
        $this->dropIndex('idx-office_social_account-platform_id', '{{%office_social_account}}');
        $this->dropIndex('idx-office_social_account-office_id', '{{%office_social_account}}');

        $this->dropIndex('idx-social_platform-code', '{{%social_platform}}');
    }
}

