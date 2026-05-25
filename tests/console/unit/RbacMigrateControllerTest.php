<?php

namespace tests\console\unit;

use Codeception\Test\Unit;
use Yii;
use console\controllers\RbacMigrateController;

class RbacMigrateControllerTest extends Unit
{
    public function testCreateMigrationLoadsClassFromMigrationPath(): void
    {
        $className = 'm' . date('ymd_His') . '_' . uniqid('test_rbac_', false);
        $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('rbac_migrate_test_', false);
        mkdir($tempDir, 0777, true);

        $migrationFile = $tempDir . DIRECTORY_SEPARATOR . $className . '.php';
        $migrationContent = "<?php\nclass {$className}\n{\n    public \$marker = 'loaded';\n}\n";
        file_put_contents($migrationFile, $migrationContent);

        $controller = new class('rbac-migrate', Yii::$app) extends RbacMigrateController {
            public function createMigrationForTest(string $class)
            {
                return $this->createMigration($class);
            }
        };
        $controller->migrationPath = $tempDir;

        $migration = $controller->createMigrationForTest($className);

        $this->assertInstanceOf($className, $migration);
        $this->assertSame('loaded', $migration->marker);

        unlink($migrationFile);
        rmdir($tempDir);
    }
}
