<?php

use yii\db\Migration;
use yii\rbac\DbManager;

/**
 * Class m240708_170000_create_rbac_tables
 */
class m240708_170000_create_rbac_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // --- START: Create RBAC Tables ---
        // These tables are required by DbManager for RBAC functionality.
        // They are typically created by Yii2's default RBAC migration (m140506_102106_rbac_init)
        // or by a user module like Da\User. We include them here to ensure they exist.

        $this->createTable('{{%tx_auth_rule}}', [
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addPrimaryKey('PK_tx_auth_rule_name', '{{%tx_auth_rule}}', 'name');

        $this->createTable('{{%tx_auth_item}}', [
            'name' => $this->string(64)->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addPrimaryKey('PK_tx_auth_item_name', '{{%tx_auth_item}}', 'name');
        $this->createIndex('idx-tx_auth_item-type', '{{%tx_auth_item}}', 'type');
        $this->addForeignKey(
            'FK_tx_auth_item_rule_name',
            '{{%tx_auth_item}}',
            'rule_name',
            '{{%tx_auth_rule}}',
            'name',
            'SET NULL',
            'CASCADE'
        );

        $this->createTable('{{%tx_auth_item_child}}', [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
        ]);
        $this->addPrimaryKey('PK_tx_auth_item_child_parent_child', '{{%tx_auth_item_child}}', ['parent', 'child']);
        $this->addForeignKey(
            'FK_tx_auth_item_child_parent',
            '{{%tx_auth_item_child}}',
            'parent',
            '{{%tx_auth_item}}',
            'name',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'FK_tx_auth_item_child_child',
            '{{%tx_auth_item_child}}',
            'child',
            '{{%tx_auth_item}}',
            'name',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%tx_auth_assignment}}', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(), // user_id should match the type of your user ID (e.g., int or string)
            'created_at' => $this->integer(),
        ]);
        $this->addPrimaryKey('PK_tx_auth_assignment_item_name_user_id', '{{%tx_auth_assignment}}', ['item_name', 'user_id']);
        $this->createIndex('idx-tx_auth_assignment-user_id', '{{%tx_auth_assignment}}', 'user_id'); // Add index for user_id
        $this->addForeignKey(
            'FK_tx_auth_assignment_item_name',
            '{{%tx_auth_assignment}}',
            'item_name',
            '{{%tx_auth_item}}',
            'name',
            'CASCADE',
            'CASCADE'
        );
        // Note: A foreign key to the actual user table (tx_user) is usually added here.
        // Assuming tx_user is created in m20250708000000_init_news_schema.php
        // If your user_id in tx_user is an INT, change 'user_id' above to $this->integer()
        // and uncomment the following:
        /*
        $this->addForeignKey(
            'FK_tx_auth_assignment_user_id',
            '{{%tx_auth_assignment}}',
            'user_id',
            '{{%tx_user}}', // Assuming your user table is named tx_user
            'id',
            'CASCADE',
            'CASCADE'
        );
        */
        // --- END: Create RBAC Tables ---

        // IMPORTANT: Clear schema cache to ensure DbManager sees the newly created tables
        Yii::$app->db->schema->refresh();

        $auth = new DbManager();
        $auth->db = Yii::$app->db;

        // Clear existing RBAC data (if any) - Now safe to execute after tables are created
        $this->execute('DELETE FROM {{%tx_auth_assignment}}');
        $this->execute('DELETE FROM {{%tx_auth_item_child}}');
        $this->execute('DELETE FROM {{%tx_auth_item}}');
        $this->execute('DELETE FROM {{%tx_auth_rule}}');

        // Insert roles
        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        $regular = $auth->createRole('regular');
        $regular->description = 'Reguler';
        $auth->add($regular);

        $guest = $auth->createRole('guest');
        $guest->description = 'Guest';
        $auth->add($guest);

        // Insert permissions (items)
        $permissions = [
            'create-user-owner' => 'Create User Owner',
            'create-user-regular' => 'Create User Regular',

            'index-master' => 'Index Master',
            'create-master' => 'Create Master',
            'update-master' => 'Update Master',
            'view-master' => 'View Master',
            'delete-master' => 'Delete Master',
            'report-master' => 'Report Master',

            'index-transaction' => 'Index Transaction',
            'create-transaction' => 'Create Transaction',
            'update-transaction' => 'Update Transaction',
            'view-transaction' => 'View Transaction',
            'delete-transaction' => 'Delete Transaction',
            'report-transaction' => 'Report Transaction',

            'index-article' => 'Index Article',
            'create-article' => 'Create Article',
            'update-article' => 'Update Article',
            'view-article' => 'View Article',
            'delete-article' => 'Delete Article',
            'report-article' => 'Report Article',

            'index-articlecategory' => 'Index Article Category',
            'create-articlecategory' => 'Create Article Category',
            'update-articlecategory' => 'Update Archive Category',
            'view-articlecategory' => 'View Article Category',
            'delete-articlecategory' => 'Delete Article Category',
            'report-articlecategory' => 'Report Article Category',

            'index-asset' => 'Index Asset',
            'create-asset' => 'Create Asset',
            'update-asset' => 'Update Asset',
            'view-asset' => 'View Asset',
            'delete-asset' => 'Delete Asset',
            'report-asset' => 'Report Asset',

            'index-assetcategory' => 'Index Asset Category',
            'create-assetcategory' => 'Create Asset Category',
            'update-assetcategory' => 'Update Asset Category',
            'view-assetcategory' => 'View Asset Category',
            'delete-assetcategory' => 'Delete Asset Category',
            'report-assetcategory' => 'Report Asset Category',

            'index-author' => 'Index Author',
            'create-author' => 'Create Author',
            'update-author' => 'Update Author',
            'view-author' => 'View Author',
            'delete-author' => 'Delete Author',

            'index-authormedia' => 'Index Author Media',
            'create-authormedia' => 'Create Author Media',
            'update-authormedia' => 'Update Author Media',
            'view-authormedia' => 'View Author Media',
            'delete-authormedia' => 'Delete Author Media',

            'index-employment' => 'Index Employment',
            'create-employment' => 'Create Employment',
            'update-employment' => 'Update Employment',
            'view-employment' => 'View Employment',
            'delete-employment' => 'Delete Employment',

            'index-event' => 'Index Event',
            'create-event' => 'Create Event',
            'update-event' => 'Update Event',
            'view-event' => 'View Event',
            'delete-event' => 'Delete Event',

            'index-office' => 'Index Office',
            'create-office' => 'Create Office',
            'update-office' => 'Update Office',
            'view-office' => 'View Office',
            'delete-office' => 'Delete Office',

            'index-officemedia' => 'Index Office Media',
            'create-officemedia' => 'Create Office Media',
            'update-officemedia' => 'Update Office Media',
            'view-officemedia' => 'View Office Media',
            'delete-officemedia' => 'Delete Office Media',

            'index-profile' => 'Index Profile',
            'create-profile' => 'Create Profile',
            'update-profile' => 'Update Profile',
            'view-profile' => 'View Profile',
            'delete-profile' => 'Delete Profile',

            'index-quote' => 'Index Quote',
            'create-quote' => 'Create Quote',
            'update-quote' => 'Update Quote',
            'view-quote' => 'View Quote',
            'delete-quote' => 'Delete Quote',

            'index-staff' => 'Index Staff',
            'create-staff' => 'Create Staff',
            'update-staff' => 'Update Staff',
            'view-staff' => 'View Staff',
            'delete-staff' => 'Delete Staff',

            'index-staffmedia' => 'Index Staff Media',
            'create-staffmedia' => 'Create Staff Media',
            'update-staffmedia' => 'Update Staff Media',
            'view-staffmedia' => 'View Staff Media',
            'delete-staffmedia' => 'Delete Staff Media',

            'index-page' => 'Index Page',
            'create-page' => 'Create Page',
            'update-page' => 'Update Page',
            'view-page' => 'View Page',
            'delete-page' => 'Delete Page',
        ];

        foreach ($permissions as $name => $description) {
            $permission = $auth->createPermission($name);
            $permission->description = $description;
            $auth->add($permission);
        }

        // Assign permissions to roles
        // Admin role
        $auth->addChild($admin, $auth->getPermission('create-user-owner'));
        $auth->addChild($admin, $auth->getPermission('index-master'));
        $auth->addChild($admin, $auth->getPermission('create-master'));
        $auth->addChild($admin, $auth->getPermission('update-master'));
        $auth->addChild($admin, $auth->getPermission('view-master'));
        $auth->addChild($admin, $auth->getPermission('delete-master'));
        $auth->addChild($admin, $auth->getPermission('report-master'));
        $auth->addChild($admin, $auth->getPermission('index-transaction'));
        $auth->addChild($admin, $auth->getPermission('create-transaction'));
        $auth->addChild($admin, $auth->getPermission('update-transaction'));
        $auth->addChild($admin, $auth->getPermission('view-transaction'));
        $auth->addChild($admin, $auth->getPermission('delete-transaction'));
        $auth->addChild($admin, $auth->getPermission('report-transaction'));

        // Regular role
        $auth->addChild($regular, $auth->getPermission('index-transaction'));
        $auth->addChild($regular, $auth->getPermission('create-transaction'));
        $auth->addChild($regular, $auth->getPermission('update-transaction'));
        $auth->addChild($regular, $auth->getPermission('view-transaction'));
        $auth->addChild($regular, $auth->getPermission('delete-transaction'));
        $auth->addChild($regular, $auth->getPermission('report-transaction'));
        $auth->addChild($regular, $auth->getPermission('update-profile'));
        $auth->addChild($regular, $auth->getPermission('view-profile'));

        // Guest role
        $auth->addChild($guest, $auth->getPermission('index-asset'));
        $auth->addChild($guest, $auth->getPermission('view-asset'));
        $auth->addChild($guest, $auth->getPermission('index-article'));
        $auth->addChild($guest, $auth->getPermission('view-article'));

        // Master permissions children
        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-articlecategory'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-articlecategory'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-articlecategory'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-articlecategory'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-articlecategory'));
        $auth->addChild($auth->getPermission('report-master'), $auth->getPermission('report-articlecategory'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-assetcategory'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-assetcategory'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-assetcategory'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-assetcategory'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-assetcategory'));
        $auth->addChild($auth->getPermission('report-master'), $auth->getPermission('report-assetcategory'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-author'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-author'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-author'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-author'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-author'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-authormedia'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-authormedia'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-authormedia'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-authormedia'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-authormedia'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-employment'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-employment'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-employment'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-employment'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-employment'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-event'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-event'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-event'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-event'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-event'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-office'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-office'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-office'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-office'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-office'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-officemedia'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-officemedia'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-officemedia'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-officemedia'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-officemedia'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-profile'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-profile'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-profile'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-profile'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-profile'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-quote'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-quote'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-quote'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-quote'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-quote'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-staff'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-staff'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-staff'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-staff'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-staff'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-staffmedia'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-staffmedia'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-staffmedia'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-staffmedia'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-staffmedia'));

        $auth->addChild($auth->getPermission('index-master'), $auth->getPermission('index-page'));
        $auth->addChild($auth->getPermission('create-master'), $auth->getPermission('create-page'));
        $auth->addChild($auth->getPermission('update-master'), $auth->getPermission('update-page'));
        $auth->addChild($auth->getPermission('view-master'), $auth->getPermission('view-page'));
        $auth->addChild($auth->getPermission('delete-master'), $auth->getPermission('delete-page'));

        // Transaction permissions children
        $auth->addChild($auth->getPermission('index-transaction'), $auth->getPermission('index-article'));
        $auth->addChild($auth->getPermission('create-transaction'), $auth->getPermission('create-article'));
        $auth->addChild($auth->getPermission('update-transaction'), $auth->getPermission('update-article'));
        $auth->addChild($auth->getPermission('view-transaction'), $auth->getPermission('view-article'));
        $auth->addChild($auth->getPermission('delete-transaction'), $auth->getPermission('delete-article'));

        $auth->addChild($auth->getPermission('index-transaction'), $auth->getPermission('index-asset'));
        $auth->addChild($auth->getPermission('create-transaction'), $auth->getPermission('create-asset'));
        $auth->addChild($auth->getPermission('update-transaction'), $auth->getPermission('update-asset'));
        $auth->addChild($auth->getPermission('view-transaction'), $auth->getPermission('view-asset'));
        $auth->addChild($auth->getPermission('delete-transaction'), $auth->getPermission('delete-asset'));

        $auth->addChild($auth->getPermission('index-transaction'), $auth->getPermission('create-user-regular'));

        // Assign admin role to user_id '1'
        $auth->assign($admin, '1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = new DbManager();
        $auth->db = Yii::$app->db;

        // Remove all assignments, children, and items
        $auth->removeAllAssignments();
        $auth->removeAllPermissions();
        $auth->removeAllRoles();
        $auth->removeAllRules();

        // --- START: Drop RBAC Tables ---
        $this->dropForeignKey('FK_tx_auth_assignment_item_name', '{{%tx_auth_assignment}}');
        // Uncomment if you add FK to tx_user
        // $this->dropForeignKey('FK_tx_auth_assignment_user_id', '{{%tx_auth_assignment}}');

        $this->dropForeignKey('FK_tx_auth_item_child_parent', '{{%tx_auth_item_child}}');
        $this->dropForeignKey('FK_tx_auth_item_child_child', '{{%tx_auth_item_child}}');

        $this->dropForeignKey('FK_tx_auth_item_rule_name', '{{%tx_auth_item}}');

        $this->dropTable('{{%tx_auth_assignment}}');
        $this->dropTable('{{%tx_auth_item_child}}');
        $this->dropTable('{{%tx_auth_item}}');
        $this->dropTable('{{%tx_auth_rule}}');
        // --- END: Drop RBAC Tables ---
    }
}
