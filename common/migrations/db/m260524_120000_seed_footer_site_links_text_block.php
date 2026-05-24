<?php

use yii\db\Migration;

/**
 * Class m260524_120000_seed_footer_site_links_text_block
 */
class m260524_120000_seed_footer_site_links_text_block extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%widget_text}}', [
            'key' => 'footer_site_links',
            'title' => 'Footer Site Links',
            'body' => '<ul>
    <li><a href="#">Link 1</a></li>
    <li><a href="#">Link 2</a></li>
    <li><a href="#">Link 3</a></li>
</ul>',
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%widget_text}}', [
            'key' => 'footer_site_links',
        ]);
    }
}

