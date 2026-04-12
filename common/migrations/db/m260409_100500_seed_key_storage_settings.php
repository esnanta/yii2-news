<?php

use yii\db\Migration;
use yii\db\Query;

class m260409_100500_seed_key_storage_settings extends Migration
{
    private const DEFAULT_SETTINGS = [
        'frontend.meta.description' => [
            'value' => 'Website resmi Main Office.',
            'comment' => 'Default meta description for frontend pages',
        ],
        'frontend.meta.keywords' => [
            'value' => 'main office, berita, publikasi, regulasi',
            'comment' => 'Default meta keywords for frontend pages',
        ],
    ];

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        foreach (self::DEFAULT_SETTINGS as $key => $config) {
            $exists = (new Query())
                ->from('{{%key_storage_item}}')
                ->where(['key' => $key])
                ->exists($this->db)
            ;

            if ($exists) {
                continue;
            }

            $this->insert('{{%key_storage_item}}', [
                'key' => $key,
                'value' => (string) $config['value'],
                'comment' => $config['comment'],
            ]);
        }
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->delete('{{%key_storage_item}}', [
            'key' => array_keys(self::DEFAULT_SETTINGS),
        ]);
    }
}
