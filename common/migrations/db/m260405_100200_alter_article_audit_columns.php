<?php

use yii\db\Migration;

class m260405_100200_alter_article_audit_columns extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->convertUnixIntToDateTime('{{%article_category}}', 'created_at');
        $this->convertUnixIntToDateTime('{{%article_category}}', 'updated_at');

        $this->addColumn('{{%article_category}}', 'created_by', $this->integer());
        $this->addColumn('{{%article_category}}', 'updated_by', $this->integer());
        $this->addColumn('{{%article_category}}', 'is_deleted', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('{{%article_category}}', 'deleted_at', $this->dateTime());
        $this->addColumn('{{%article_category}}', 'deleted_by', $this->integer()->defaultValue(0));
        $this->addColumn('{{%article_category}}', 'verlock', $this->bigInteger());
        $this->addColumn('{{%article_category}}', 'uuid', $this->string(36));
        $this->update('{{%article_category}}', ['deleted_by' => 0], [
            'and',
            ['deleted_by' => null],
            ['is_deleted' => 0],
            ['deleted_at' => null],
        ]);

        $this->convertUnixIntToDateTime('{{%article}}', 'created_at');
        $this->convertUnixIntToDateTime('{{%article}}', 'updated_at');
        $this->convertUnixIntToDateTime('{{%article}}', 'published_at');

        $this->addColumn('{{%article}}', 'is_deleted', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('{{%article}}', 'deleted_at', $this->dateTime());
        $this->addColumn('{{%article}}', 'deleted_by', $this->integer()->defaultValue(0));
        $this->addColumn('{{%article}}', 'verlock', $this->bigInteger());
        $this->addColumn('{{%article}}', 'uuid', $this->string(36));
        $this->addColumn('{{%article}}', 'author_id', $this->integer()->after('id'));
        $this->update('{{%article}}', ['deleted_by' => 0], [
            'and',
            ['deleted_by' => null],
            ['is_deleted' => 0],
            ['deleted_at' => null],
        ]);

        $this->convertUnixIntToDateTime('{{%article_attachment}}', 'created_at');

        $this->addColumn('{{%article_attachment}}', 'updated_at', $this->dateTime());
        $this->addColumn('{{%article_attachment}}', 'created_by', $this->integer());
        $this->addColumn('{{%article_attachment}}', 'updated_by', $this->integer());
        $this->addColumn('{{%article_attachment}}', 'is_deleted', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('{{%article_attachment}}', 'deleted_at', $this->dateTime());
        $this->addColumn('{{%article_attachment}}', 'deleted_by', $this->integer()->defaultValue(0));
        $this->addColumn('{{%article_attachment}}', 'verlock', $this->bigInteger());
        $this->addColumn('{{%article_attachment}}', 'uuid', $this->string(36));
        $this->update('{{%article_attachment}}', ['deleted_by' => 0], [
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

        $this->dropColumn('{{%article_attachment}}', 'uuid');
        $this->dropColumn('{{%article_attachment}}', 'verlock');
        $this->dropColumn('{{%article_attachment}}', 'deleted_by');
        $this->dropColumn('{{%article_attachment}}', 'deleted_at');
        $this->dropColumn('{{%article_attachment}}', 'is_deleted');
        $this->dropColumn('{{%article_attachment}}', 'updated_by');
        $this->dropColumn('{{%article_attachment}}', 'created_by');
        $this->dropColumn('{{%article_attachment}}', 'updated_at');

        $this->convertDateTimeToUnixInt('{{%article_attachment}}', 'created_at');

        $this->dropColumn('{{%article}}', 'uuid');
        $this->dropColumn('{{%article}}', 'verlock');
        $this->dropColumn('{{%article}}', 'deleted_by');
        $this->dropColumn('{{%article}}', 'deleted_at');
        $this->dropColumn('{{%article}}', 'is_deleted');
        $this->dropColumn('{{%article}}', 'author_id');

        $this->convertDateTimeToUnixInt('{{%article}}', 'published_at');
        $this->convertDateTimeToUnixInt('{{%article}}', 'updated_at');
        $this->convertDateTimeToUnixInt('{{%article}}', 'created_at');

        $this->dropColumn('{{%article_category}}', 'uuid');
        $this->dropColumn('{{%article_category}}', 'verlock');
        $this->dropColumn('{{%article_category}}', 'deleted_by');
        $this->dropColumn('{{%article_category}}', 'deleted_at');
        $this->dropColumn('{{%article_category}}', 'is_deleted');
        $this->dropColumn('{{%article_category}}', 'updated_by');
        $this->dropColumn('{{%article_category}}', 'created_by');

        $this->convertDateTimeToUnixInt('{{%article_category}}', 'updated_at');
        $this->convertDateTimeToUnixInt('{{%article_category}}', 'created_at');
    }

    private function convertUnixIntToDateTime($table, $column)
    {
        $temporaryColumn = $column.'_tmp_datetime';
        $this->addColumn($table, $temporaryColumn, $this->dateTime());
        $this->execute("UPDATE {$table} SET [[{$temporaryColumn}]] = FROM_UNIXTIME([[{$column}]]) WHERE [[{$column}]] IS NOT NULL");
        $this->dropColumn($table, $column);
        $this->renameColumn($table, $temporaryColumn, $column);
    }

    private function convertUnixIntToDate($table, $column)
    {
        $temporaryColumn = $column.'_tmp_date';
        $this->addColumn($table, $temporaryColumn, $this->date());
        $this->execute("UPDATE {$table} SET [[{$temporaryColumn}]] = DATE(FROM_UNIXTIME([[{$column}]])) WHERE [[{$column}]] IS NOT NULL");
        $this->dropColumn($table, $column);
        $this->renameColumn($table, $temporaryColumn, $column);
    }

    private function convertDateTimeToUnixInt($table, $column)
    {
        $temporaryColumn = $column.'_tmp_integer';
        $this->addColumn($table, $temporaryColumn, $this->integer());
        $this->execute("UPDATE {$table} SET [[{$temporaryColumn}]] = UNIX_TIMESTAMP([[{$column}]]) WHERE [[{$column}]] IS NOT NULL");
        $this->dropColumn($table, $column);
        $this->renameColumn($table, $temporaryColumn, $column);
    }

    private function convertDateToUnixInt($table, $column)
    {
        $temporaryColumn = $column.'_tmp_integer';
        $this->addColumn($table, $temporaryColumn, $this->integer());
        $this->execute("UPDATE {$table} SET [[{$temporaryColumn}]] = UNIX_TIMESTAMP([[{$column}]]) WHERE [[{$column}]] IS NOT NULL");
        $this->dropColumn($table, $column);
        $this->renameColumn($table, $temporaryColumn, $column);
    }
}
