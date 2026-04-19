<?php

use yii\db\Migration;
use yii\db\Query;

class m260420_100300_seed_news_domain_defaults extends Migration
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

    private const DEFAULT_JOB_TITLES = [
        ['title' => 'Manager', 'sequence' => 10, 'description' => 'Manajerial.'],
        ['title' => 'Supervisor', 'sequence' => 20, 'description' => 'Pengawas.'],
        ['title' => 'Staff', 'sequence' => 30, 'description' => 'Staf Pelaksana.'],
    ];

    private const DEFAULT_AUTHORS = [
        ['title' => 'John Doe', 'email' => 'john.doe@example.com', 'phone_number' => '123456789'],
    ];

    private const DEFAULT_STAFF = [
        ['title' => 'Jane Smith', 'initial' => 'JS', 'identity_number' => '12345', 'job_title' => 'Staff'],
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
        $this->seedJobTitles($now);
        $this->seedAuthors($now);
        $this->seedStaff($now);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->delete('{{%staff}}', [
            'office_id' => self::DEFAULT_OFFICE_ID,
            'title' => array_column(self::DEFAULT_STAFF, 'title'),
        ]);

        $this->delete('{{%author}}', [
            'office_id' => self::DEFAULT_OFFICE_ID,
            'title' => array_column(self::DEFAULT_AUTHORS, 'title'),
        ]);

        $this->delete('{{%job_title}}', [
            'office_id' => self::DEFAULT_OFFICE_ID,
            'title' => array_column(self::DEFAULT_JOB_TITLES, 'title'),
        ]);

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
            ->exists($this->db)
        ;

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
                ->exists($this->db)
            ;

            if ($exists) {
                continue;
            }

            $this->insert('{{%social_platform}}', [
                'code' => $platform['code'],
                'name' => $platform['name'],
                'base_url' => $platform['base_url'],
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
                ->exists($this->db)
            ;

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

    private function seedJobTitles(string $now): void
    {
        foreach (self::DEFAULT_JOB_TITLES as $jobTitle) {
            $exists = (new Query())
                ->from('{{%job_title}}')
                ->where([
                    'office_id' => self::DEFAULT_OFFICE_ID,
                    'title' => $jobTitle['title'],
                ])
                ->exists($this->db)
            ;

            if ($exists) {
                continue;
            }

            $this->insert('{{%job_title}}', [
                'office_id' => self::DEFAULT_OFFICE_ID,
                'title' => $jobTitle['title'],
                'sequence' => $jobTitle['sequence'],
                'description' => $jobTitle['description'],
                'is_deleted' => 0,
                'deleted_by' => 0,
                'verlock' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function seedAuthors(string $now): void
    {
        foreach (self::DEFAULT_AUTHORS as $author) {
            $exists = (new Query())
                ->from('{{%author}}')
                ->where([
                    'office_id' => self::DEFAULT_OFFICE_ID,
                    'title' => $author['title'],
                ])
                ->exists($this->db)
            ;

            if ($exists) {
                continue;
            }

            $this->insert('{{%author}}', [
                'office_id' => self::DEFAULT_OFFICE_ID,
                'title' => $author['title'],
                'email' => $author['email'],
                'phone_number' => $author['phone_number'],
                'is_deleted' => 0,
                'deleted_by' => 0,
                'verlock' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function seedStaff(string $now): void
    {
        foreach (self::DEFAULT_STAFF as $staff) {
            $exists = (new Query())
                ->from('{{%staff}}')
                ->where([
                    'office_id' => self::DEFAULT_OFFICE_ID,
                    'title' => $staff['title'],
                ])
                ->exists($this->db)
            ;

            if ($exists) {
                continue;
            }

            $jobTitleId = (new Query())
                ->select('id')
                ->from('{{%job_title}}')
                ->where([
                    'title' => $staff['job_title'],
                    'office_id' => self::DEFAULT_OFFICE_ID,
                ])
                ->scalar($this->db)
            ;

            if (!$jobTitleId) {
                echo "Skipping staff member {$staff['title']} because job title '{$staff['job_title']}' was not found.\n";

                continue;
            }

            $this->insert('{{%staff}}', [
                'office_id' => self::DEFAULT_OFFICE_ID,
                'job_title_id' => $jobTitleId,
                'title' => $staff['title'],
                'initial' => $staff['initial'],
                'identity_number' => $staff['identity_number'],
                'is_deleted' => 0,
                'deleted_by' => 0,
                'verlock' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
