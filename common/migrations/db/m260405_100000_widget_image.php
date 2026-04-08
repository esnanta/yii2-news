<?php

use yii\db\Migration;

class m260405_100000_widget_image extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%widget_image}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(100)->notNull(),
            'title' => $this->string(100),
            'base_url' => $this->string(1024),
            'path' => $this->string(1024),
            'mime_type' => $this->string(100),
            'size' => $this->integer(),
            'link_url' => $this->string(500),
            'alt_text' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('idx-widget_image-key', '{{%widget_image}}', 'key');

        $now = time();
        $frontendUrl = \Yii::getAlias('@frontendUrl');
        $themeImageBaseUrl = $frontendUrl . '/themes/bootstrap4news/assets/img';

        // Default placeholders for common page image slots.
        $this->batchInsert('{{%widget_image}}', [
            'key',
            'title',
            'base_url',
            'path',
            'mime_type',
            'size',
            'link_url',
            'alt_text',
            'created_at',
            'updated_at',
        ], [
            [
                'logo_top',
                'Logo Header',
                $themeImageBaseUrl,
                'logo.png',
                'image/png',
                null,
                $frontendUrl,
                'Logo website di bagian atas',
                $now,
                $now,
            ],
            [
                'logo_bottom',
                'Logo Footer',
                $themeImageBaseUrl,
                'logo.png',
                'image/png',
                null,
                $frontendUrl,
                'Logo website di bagian bawah',
                $now,
                $now,
            ],
            [
                'hero_horizontal_top_center',
                'Banner Horizontal Atas Tengah',
                $themeImageBaseUrl,
                'ads-1.jpg',
                'image/jpeg',
                null,
                $frontendUrl,
                'Banner horizontal pada bagian atas tengah halaman',
                $now,
                $now,
            ],
            [
                'hero_horizontal_top_center_alt',
                'Banner Horizontal Atas Tengah Alternatif',
                $themeImageBaseUrl,
                'ads-2.jpg',
                'image/jpeg',
                null,
                $frontendUrl,
                'Banner horizontal alternatif untuk area atas tengah',
                $now,
                $now,
            ],
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropIndex('idx-widget_image-key', '{{%widget_image}}');
        $this->dropTable('{{%widget_image}}');
    }
}
