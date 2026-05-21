<?php

use yii\db\Migration;

/**
 * Class m260521_213000_seed_footer_menu_text_block
 */
class m260521_213000_seed_footer_menu_text_block extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%widget_text}}', [
            'key' => 'frontend.footer-menu',
            'title' => 'Footer Menu',
            'body' => '
            <a href="">Terms of use</a>
            <a href="">Privacy policy</a>
            <a href="">Cookies</a>
            <a href="">Accessibility help</a>
            <a href="">Advertise with us</a>
            <a href="">Contact us</a>',
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
            'key' => 'frontend.footer-menu',
        ]);
    }
}
