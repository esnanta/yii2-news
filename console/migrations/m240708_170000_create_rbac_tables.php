<?php

use yii\db\Migration;

/**
 * Class m240708_170000_create_rbac_tables
 * Migrasi ini hanya bertanggung jawab untuk membuat tabel-tabel yang diperlukan oleh RBAC.
 */
class m240708_170000_create_rbac_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // --- START: Membuat Tabel RBAC ---
        // Tabel-tabel ini diperlukan oleh DbManager untuk fungsionalitas RBAC.

        // Menggunakan {{%auth_rule}} agar prefix 'tx_' dari konfigurasi DB diterapkan secara otomatis
        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addPrimaryKey('PK_tx_auth_rule_name', '{{%auth_rule}}', 'name');

        // Menggunakan {{%auth_item}}
        $this->createTable('{{%auth_item}}', [
            'name' => $this->string(64)->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addPrimaryKey('PK_tx_auth_item_name', '{{%auth_item}}', 'name');
        $this->createIndex('idx-tx_auth_item-type', '{{%auth_item}}', 'type');
        $this->addForeignKey(
            'FK_tx_auth_item_rule_name',
            '{{%auth_item}}',
            'rule_name',
            '{{%auth_rule}}', // Menggunakan {{%auth_rule}}
            'name',
            'SET NULL',
            'CASCADE'
        );

        // Menggunakan {{%auth_item_child}}
        $this->createTable('{{%auth_item_child}}', [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
        ]);
        $this->addPrimaryKey('PK_tx_auth_item_child_parent_child', '{{%auth_item_child}}', ['parent', 'child']);
        $this->addForeignKey(
            'FK_tx_auth_item_child_parent',
            '{{%auth_item_child}}',
            'parent',
            '{{%auth_item}}', // Menggunakan {{%auth_item}}
            'name',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'FK_tx_auth_item_child_child',
            '{{%auth_item_child}}',
            'child',
            '{{%auth_item}}', // Menggunakan {{%auth_item}}
            'name',
            'CASCADE',
            'CASCADE'
        );

        // Menggunakan {{%auth_assignment}}
        $this->createTable('{{%auth_assignment}}', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(), // user_id harus cocok dengan tipe ID pengguna Anda (misalnya, int atau string)
            'created_at' => $this->integer(),
        ]);
        $this->addPrimaryKey('PK_tx_auth_assignment_item_name_user_id', '{{%auth_assignment}}', ['item_name', 'user_id']);
        $this->createIndex('idx-tx_auth_assignment-user_id', '{{%auth_assignment}}', 'user_id'); // Tambahkan indeks untuk user_id
        $this->addForeignKey(
            'FK_tx_auth_assignment_item_name',
            '{{%auth_assignment}}',
            'item_name',
            '{{%auth_item}}', // Menggunakan {{%auth_item}}
            'name',
            'CASCADE',
            'CASCADE'
        );
        // Catatan: Kunci asing ke tabel pengguna yang sebenarnya (tx_user) biasanya ditambahkan di sini.
        // Jika user_id Anda di tx_user adalah INT, ubah 'user_id' di atas menjadi $this->integer()
        // dan hapus komentar berikut:
        /*
        $this->addForeignKey(
            'FK_tx_auth_assignment_user_id',
            '{{%auth_assignment}}',
            'user_id',
            '{{%tx_user}}', // Asumsi tabel pengguna Anda bernama tx_user
            'id',
            'CASCADE',
            'CASCADE'
        );
        */
        // --- END: Membuat Tabel RBAC ---
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // --- START: Menghapus Tabel RBAC ---
        $this->dropForeignKey('FK_tx_auth_assignment_item_name', '{{%auth_assignment}}'); // Menggunakan {{%auth_assignment}}
        // Hapus komentar jika Anda menambahkan FK ke tx_user
        // $this->dropForeignKey('FK_tx_auth_assignment_user_id', '{{%auth_assignment}}');

        $this->dropForeignKey('FK_tx_auth_item_child_parent', '{{%auth_item_child}}'); // Menggunakan {{%auth_item_child}}
        $this->dropForeignKey('FK_tx_auth_item_child_child', '{{%auth_item_child}}');   // Menggunakan {{%auth_item_child}}

        $this->dropForeignKey('FK_tx_auth_item_rule_name', '{{%auth_item}}'); // Menggunakan {{%auth_item}}

        $this->dropTable('{{%auth_assignment}}'); // Menggunakan {{%auth_assignment}}
        $this->dropTable('{{%auth_item_child}}'); // Menggunakan {{%auth_item_child}}
        $this->dropTable('{{%auth_item}}');       // Menggunakan {{%auth_item}}
        $this->dropTable('{{%auth_rule}}');       // Menggunakan {{%auth_rule}}
        // --- END: Menghapus Tabel RBAC ---
    }
}
