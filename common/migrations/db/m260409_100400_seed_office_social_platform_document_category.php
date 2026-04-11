<?php

use yii\db\Migration;
use yii\db\Query;

class m260409_100400_seed_office_social_platform_document_category extends Migration
{
    private const DEFAULT_OFFICE_ID = 1;
    private const DEFAULT_OFFICE_UNIQUE_ID = 'moi';
    private const DEFAULT_SOCIAL_PLATFORMS = [
        ['code' => 'facebook', 'name' => 'Facebook', 'base_url' => 'https://www.facebook.com/', 'sequence' => 10],
        ['code' => 'instagram', 'name' => 'Instagram', 'base_url' => 'https://www.instagram.com/', 'sequence' => 20],
        ['code' => 'twitter', 'name' => 'X (Twitter)', 'base_url' => 'https://x.com/', 'sequence' => 30],
        ['code' => 'youtube', 'name' => 'YouTube', 'base_url' => 'https://www.youtube.com/', 'sequence' => 40],
        ['code' => 'linkedin', 'name' => 'LinkedIn', 'base_url' => 'https://www.linkedin.com/', 'sequence' => 50],
    ];
    private const DEFAULT_DOCUMENT_CATEGORIES = [
        ['title' => 'Regulasi', 'sequence' => 10, 'description' => 'Kumpulan peraturan dan pedoman resmi.'],
        ['title' => 'Laporan', 'sequence' => 20, 'description' => 'Laporan kegiatan dan kinerja kantor.'],
        ['title' => 'Publikasi', 'sequence' => 30, 'description' => 'Materi publikasi dan informasi umum.'],
    ];

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $now = date('Y-m-d H:i:s');

        $this->seedDefaultOffice($now);
        $this->seedSocialPlatforms($now);
        $this->seedDocumentCategories($now);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->delete('{{%document_category}}', [
            'office_id' => self::DEFAULT_OFFICE_ID,
            'title' => array_column(self::DEFAULT_DOCUMENT_CATEGORIES, 'title'),
        ]);

        $this->delete('{{%social_platform}}', [
            'code' => array_column(self::DEFAULT_SOCIAL_PLATFORMS, 'code'),
        ]);

        $this->delete('{{%office}}', [
            'id' => self::DEFAULT_OFFICE_ID,
            'unique_id' => self::DEFAULT_OFFICE_UNIQUE_ID,
        ]);
    }

    private function seedDefaultOffice(string $now): void
    {
        $exists = (new Query())
            ->from('{{%office}}')
            ->where([
                'id' => self::DEFAULT_OFFICE_ID,
                'unique_id' => self::DEFAULT_OFFICE_UNIQUE_ID,
            ])
            ->exists($this->db);

        if ($exists) {
            return;
        }

        $this->insert('{{%office}}', [
            'id' => self::DEFAULT_OFFICE_ID,
            'unique_id' => self::DEFAULT_OFFICE_UNIQUE_ID,
            'title' => 'Main Office',
            'is_deleted' => 0,
            'deleted_by' => 0,
            'verlock' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    private function seedSocialPlatforms(string $now): void
    {
        foreach (self::DEFAULT_SOCIAL_PLATFORMS as $platform) {
            $exists = (new Query())
                ->from('{{%social_platform}}')
                ->where(['code' => $platform['code']])
                ->exists($this->db);

            if ($exists) {
                continue;
            }

            $this->insert('{{%social_platform}}', [
                'code' => $platform['code'],
                'name' => $platform['name'],
                'base_url' => $platform['base_url'],
                'is_active' => 1,
                'sequence' => $platform['sequence'],
                'is_deleted' => 0,
                'deleted_by' => 0,
                'verlock' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function seedDocumentCategories(string $now): void
    {
        foreach (self::DEFAULT_DOCUMENT_CATEGORIES as $category) {
            $exists = (new Query())
                ->from('{{%document_category}}')
                ->where([
                    'office_id' => self::DEFAULT_OFFICE_ID,
                    'title' => $category['title'],
                ])
                ->exists($this->db);

            if ($exists) {
                continue;
            }

            $this->insert('{{%document_category}}', [
                'office_id' => self::DEFAULT_OFFICE_ID,
                'title' => $category['title'],
                'sequence' => $category['sequence'],
                'description' => $category['description'],
                'is_deleted' => 0,
                'deleted_by' => 0,
                'verlock' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}

