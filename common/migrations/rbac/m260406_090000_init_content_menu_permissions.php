<?php

use common\models\User;
use common\rbac\Migration;
use yii\rbac\Role;

class m260406_090000_init_content_menu_permissions extends Migration
{
    /* =======================
     * MODULE GROUPS
     * ======================= */

    /**
     * Resource modules for content menu access.
     *
     * @var string[]
     */
    private $contentModules = [
        'article',
        'articleAttachment',
        'articleCategory',
        'author',
        'authorSocialAccount',
        'document',
        'documentCategory',
        'employment',
        'office',
        'officeSocialAccount',
        'socialPlatform',
        'staff',
        'staffSocialAccount',
    ];

    /* =======================
     * ACTION SETS
     * ======================= */

    /**
     * Menu access action.
     *
     * @var string[]
     */
    private $actionsCrud = ['index', 'view', 'create', 'update', 'delete'];

    /**
     * Read-only action set for regular users.
     *
     * @var string[]
     */
    private $actionsReadOnly = ['index', 'view'];

    /**
     * @return bool|void
     */
    public function up()
    {
        echo ">> RBAC migration for content menu START\n";

        $this->auth->invalidateCache();

        $managerRole = $this->auth->getRole(User::ROLE_MANAGER);
        $administratorRole = $this->auth->getRole(User::ROLE_ADMINISTRATOR);

        if (!$managerRole || !$administratorRole) {
            echo "!! Roles not found. Skipping RBAC setup.\n";

            return;
        }

        $regularRole = $this->auth->getRole(User::ROLE_USER);
        if (!$regularRole) {
            echo "!! User role not found. Skipping RBAC setup.\n";

            return;
        }

        if (!$this->auth->hasChild($managerRole, $regularRole)) {
            $this->auth->addChild($managerRole, $regularRole);
        }
        if (!$this->auth->hasChild($administratorRole, $managerRole)) {
            $this->auth->addChild($administratorRole, $managerRole);
        }

        $this->createPermissions($this->contentModules, $this->actionsCrud);
        $this->assign($regularRole, $this->contentModules, $this->actionsReadOnly);
        $this->assign($managerRole, $this->contentModules, $this->actionsCrud);
        $this->assign($administratorRole, $this->contentModules, $this->actionsCrud);

        $this->auth->invalidateCache();
        echo ">> RBAC migration for content menu DONE\n";
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        echo ">> Rolling back RBAC for content menu\n";

        foreach ($this->contentModules as $module) {
            foreach ($this->actionsCrud as $action) {
                $permissionName = "{$module}.{$action}";
                $permission = $this->auth->getPermission($permissionName);
                if (null !== $permission) {
                    $this->auth->remove($permission);
                    echo "    > Removed permission: {$permissionName}\n";
                }
            }
        }

        $this->auth->invalidateCache();
        echo ">> RBAC permissions have been removed.\n";
    }

    /* =========================================================
     * HELPERS
     * ========================================================= */

    /**
     * @param string[] $modules
     * @param string[] $actions
     */
    private function createPermissions(array $modules, array $actions)
    {
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissionName = "{$module}.{$action}";
                if (null !== $this->auth->getPermission($permissionName)) {
                    continue;
                }

                $permission = $this->auth->createPermission($permissionName);
                $permission->description = "Allow user to {$action} {$module}";
                $this->auth->add($permission);
                echo "    > Permission created: {$permissionName}\n";
            }
        }
    }

    /**
     * @param Role     $role
     * @param string[] $modules
     * @param string[] $actions
     */
    private function assign($role, array $modules, array $actions)
    {
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissionName = "{$module}.{$action}";
                $permission = $this->auth->getPermission($permissionName);
                if (null !== $permission && !$this->auth->hasChild($role, $permission)) {
                    $this->auth->addChild($role, $permission);
                    echo "    > Assigned '{$permissionName}' to role '{$role->name}'\n";
                }
            }
        }
    }
}
