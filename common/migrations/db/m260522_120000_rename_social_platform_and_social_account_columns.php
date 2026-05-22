<?php

use yii\db\Migration;

class m260522_120000_rename_social_platform_and_social_account_columns extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->renameColumn('{{%social_platform}}', 'name', 'title');
        $this->renameColumn('{{%social_platform}}', 'base_url', 'url');

        $this->renameColumn('{{%office_social_account}}', 'username', 'title');
        $this->renameColumn('{{%author_social_account}}', 'username', 'title');
        $this->renameColumn('{{%staff_social_account}}', 'username', 'title');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->renameColumn('{{%staff_social_account}}', 'title', 'username');
        $this->renameColumn('{{%author_social_account}}', 'title', 'username');
        $this->renameColumn('{{%office_social_account}}', 'title', 'username');

        $this->renameColumn('{{%social_platform}}', 'url', 'base_url');
        $this->renameColumn('{{%social_platform}}', 'title', 'name');
    }
}

