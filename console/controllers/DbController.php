<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\db\Connection;
use yii\log\DbTarget;
use yii\rbac\DbManager;

class DbController extends Controller
{
    /** @var array<string,string>|null */
    private $dotEnvValues;

    /**
     * Create databases based on .env configuration.
     *
     * @param string $target all|main|test
     * @throws \yii\db\Exception
     */
    public function actionCreate($target = 'all')
    {
        $hasError = false;
        foreach ($this->resolveTargets($target) as $name => $config) {
            try {
                $dbName = $this->extractDatabaseName($config['dsn']);
                if ($dbName === null) {
                    Console::error("Skip {$name}: dbname was not found in DSN.");
                    continue;
                }

                $connection = $this->buildAdminConnection($config);
                try {
                    $exists = (bool) $connection->createCommand(
                        'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :name',
                        [':name' => $dbName]
                    )->queryScalar();

                    if ($exists) {
                        $this->stdout("Database already exists [{$dbName}] ({$name})" . PHP_EOL, Console::FG_YELLOW);
                    } else {
                        $this->assertSafeIdentifier($dbName);
                        $charset = $config['charset'] ?: 'utf8mb4';
                        $sql = sprintf('CREATE DATABASE %s CHARACTER SET %s', $connection->quoteTableName($dbName), $charset);
                        $connection->createCommand($sql)->execute();
                        $this->stdout("Database created [{$dbName}] ({$name})" . PHP_EOL, Console::FG_GREEN);
                    }
                } finally {
                    $connection->close();
                }

                $this->runMigrationsForTarget($name, $config);
            } catch (\Throwable $e) {
                $hasError = true;
                Console::error("Failed to create target {$name}: " . $e->getMessage());
            }
        }

        return $hasError ? ExitCode::UNSPECIFIED_ERROR : ExitCode::OK;
    }

    /**
     * Drop databases based on .env configuration.
     *
     * @param string $target all|main|test
     * @param bool $force true to skip confirmation
     * @throws \yii\db\Exception
     */
    public function actionDrop($target = 'all', $force = false)
    {
        $hasError = false;
        foreach ($this->resolveTargets($target) as $name => $config) {
            try {
                $dbName = $this->extractDatabaseName($config['dsn']);
                if ($dbName === null) {
                    Console::error("Skip {$name}: dbname was not found in DSN.");
                    continue;
                }

                if (!$force && !$this->confirm("Drop database [{$dbName}] ({$name})?")) {
                    $this->stdout("Skipped [{$dbName}] ({$name})" . PHP_EOL, Console::FG_YELLOW);
                    continue;
                }

                $connection = $this->buildAdminConnection($config);
                try {
                    $this->assertSafeIdentifier($dbName);
                    $sql = sprintf('DROP DATABASE IF EXISTS %s', $connection->quoteTableName($dbName));
                    $connection->createCommand($sql)->execute();
                    $this->stdout("Database dropped [{$dbName}] ({$name})" . PHP_EOL, Console::FG_GREEN);
                } finally {
                    $connection->close();
                }
            } catch (\Throwable $e) {
                $hasError = true;
                Console::error("Failed to drop target {$name}: " . $e->getMessage());
            }
        }

        return $hasError ? ExitCode::UNSPECIFIED_ERROR : ExitCode::OK;
    }

    /**
     * @param string $target
     * @return array<string,array<string,string|null>>
     */
    private function resolveTargets($target)
    {
        $target = strtolower((string) $target);
        $targets = [
            'main' => [
                'dsn' => $this->envValue('DB_DSN'),
                'username' => $this->envValue('DB_USERNAME'),
                'password' => $this->envValue('DB_PASSWORD'),
                'tablePrefix' => $this->envValue('DB_TABLE_PREFIX', ''),
                'charset' => $this->envValue('DB_CHARSET', 'utf8mb4'),
            ],
            'test' => [
                'dsn' => $this->envValue('TEST_DB_DSN'),
                'username' => $this->envValue('TEST_DB_USERNAME', $this->envValue('DB_USERNAME')),
                'password' => $this->envValue('TEST_DB_PASSWORD', $this->envValue('DB_PASSWORD')),
                'tablePrefix' => $this->envValue('TEST_DB_TABLE_PREFIX', $this->envValue('DB_TABLE_PREFIX', '')),
                'charset' => $this->envValue('DB_CHARSET', 'utf8mb4'),
            ],
        ];

        if ($target === 'all') {
            return array_filter($targets, static function ($config) {
                return !empty($config['dsn']);
            });
        }

        if (!isset($targets[$target])) {
            throw new \InvalidArgumentException('Invalid target. Allowed values: all, main, test.');
        }

        return empty($targets[$target]['dsn']) ? [] : [$target => $targets[$target]];
    }

    /**
     * @param array<string,string|null> $config
     * @return Connection
     */
    private function buildAdminConnection(array $config)
    {
        $dsn = (string) $config['dsn'];
        if (stripos($dsn, 'mysql:') !== 0) {
            throw new \RuntimeException('This command currently supports mysql DSN only.');
        }

        $adminDsn = $this->removeDatabaseNameFromDsn($dsn);

        return new Connection([
            'dsn' => $adminDsn,
            'username' => $config['username'],
            'password' => $config['password'],
            'charset' => $config['charset'] ?: 'utf8mb4',
        ]);
    }

    /**
     * @param array<string,string|null> $config
     * @return Connection
     */
    private function buildTargetConnection(array $config)
    {
        return new Connection([
            'dsn' => (string) $config['dsn'],
            'username' => $config['username'],
            'password' => $config['password'],
            'tablePrefix' => (string) ($config['tablePrefix'] ?? ''),
            'charset' => $config['charset'] ?: 'utf8mb4',
        ]);
    }

    private function runMigrationsForTarget($targetName, array $config)
    {
        $this->stdout(
            "Running migrations for target [{$targetName}]..." . PHP_EOL,
            Console::FG_CYAN
        );

        $originalDb = Yii::$app->get('db', false);
        $dbLogTargetStates = [];
        $authManagerDbState = null;
        $targetDb = $this->buildTargetConnection($config);

        $authManager = Yii::$app->get('authManager', false);
        if ($authManager instanceof DbManager) {
            $authManagerDbState = $authManager->db;
            $authManager->db = $targetDb;
        }

        $logDispatcher = Yii::$app->get('log', false);
        if ($logDispatcher !== null) {
            foreach ($logDispatcher->targets as $targetId => $target) {
                if (!$target instanceof DbTarget) {
                    continue;
                }

                $dbLogTargetStates[$targetId] = [
                    'enabled' => $target->enabled,
                    'db' => $target->db,
                ];

                // Prevent auto-created log table and force framework log migration to use current target DB.
                $target->enabled = false;
                $target->db = $targetDb;
            }
        }

        try {
            Yii::$app->set('db', $targetDb);

            /*
             * Shared DB migrations
             */
            $this->executeMigration('migrate/up', [
                'interactive' => false,
            ]);

            /*
             * Shared RBAC migrations
             */
            $this->executeMigration('rbac-migrate/up', [
                'interactive' => false,
            ]);

            /*
             * Project DB migrations
             */
            $this->executeMigration('migrate', [
                'migrationPath' => '@common/migrations/db/retread',
                'interactive' => false,
            ]);

            /*
             * Project RBAC migrations
             */
            $this->executeMigration('rbac-migrate', [
                'migrationPath' => '@common/migrations/rbac/retread',
                'interactive' => false,
            ]);

            $this->stdout(
                "Migration finished for [{$targetName}]" . PHP_EOL,
                Console::FG_GREEN
            );
        } finally {
            $targetDb->close();

            if ($originalDb !== null) {
                Yii::$app->set('db', $originalDb);
            }

            if ($authManager instanceof DbManager && $authManagerDbState !== null) {
                $authManager->db = $authManagerDbState;
            }

            if ($logDispatcher !== null) {
                foreach ($dbLogTargetStates as $targetId => $state) {
                    if (isset($logDispatcher->targets[$targetId]) && $logDispatcher->targets[$targetId] instanceof DbTarget) {
                        $logDispatcher->targets[$targetId]->enabled = $state['enabled'];
                        $logDispatcher->targets[$targetId]->db = $state['db'];
                    }
                }
            }
        }
    }

    /**
     * Rollback migrations for all/specific targets.
     *
     * @param string $target all|main|test
     * @param int $limit number of migration steps to rollback per migration group
     * @return int
     */
    public function actionMigrateDown($target = 'all', $limit = 1)
    {
        $hasError = false;
        $limit = (int) $limit;

        if ($limit < 1) {
            throw new \InvalidArgumentException('Limit must be >= 1.');
        }

        foreach ($this->resolveTargets($target) as $name => $config) {
            try {
                $this->runMigrationsDownForTarget($name, $config, $limit);
            } catch (\Throwable $e) {
                $hasError = true;
                Console::error("Rollback failed for {$name}: " . $e->getMessage());
            }
        }

        return $hasError
            ? ExitCode::UNSPECIFIED_ERROR
            : ExitCode::OK;
    }

    /**
     * @param string $targetName
     * @param array<string,string|null> $config
     * @param int $limit
     * @return void
     */
    private function runMigrationsDownForTarget($targetName, array $config, $limit)
    {
        $this->stdout(
            "Rolling back migrations for target [{$targetName}]..." . PHP_EOL,
            Console::FG_CYAN
        );

        $originalDb = Yii::$app->get('db', false);
        $dbLogTargetStates = [];
        $authManagerDbState = null;
        $targetDb = $this->buildTargetConnection($config);

        $authManager = Yii::$app->get('authManager', false);
        if ($authManager instanceof DbManager) {
            $authManagerDbState = $authManager->db;
            $authManager->db = $targetDb;
        }

        $logDispatcher = Yii::$app->get('log', false);
        if ($logDispatcher !== null) {
            foreach ($logDispatcher->targets as $targetId => $target) {
                if (!$target instanceof DbTarget) {
                    continue;
                }

                $dbLogTargetStates[$targetId] = [
                    'enabled' => $target->enabled,
                    'db' => $target->db,
                ];

                $target->enabled = false;
                $target->db = $targetDb;
            }
        }

        try {
            Yii::$app->set('db', $targetDb);

            $this->rollbackByResolvedPath(
                'rbac-migrate',
                '{{%system_rbac_migration}}',
                ['@common/migrations/rbac/retread', '@common/migrations/rbac'],
                $limit,
                $targetDb
            );

            $this->rollbackByResolvedPath(
                'migrate',
                '{{%system_db_migration}}',
                ['@common/migrations/db/retread', '@common/migrations/db'],
                $limit,
                $targetDb
            );

            $this->stdout(
                "Rollback finished for [{$targetName}]" . PHP_EOL,
                Console::FG_GREEN
            );
        } finally {
            $targetDb->close();

            if ($originalDb !== null) {
                Yii::$app->set('db', $originalDb);
            }

            if ($authManager instanceof DbManager && $authManagerDbState !== null) {
                $authManager->db = $authManagerDbState;
            }

            if ($logDispatcher !== null) {
                foreach ($dbLogTargetStates as $targetId => $state) {
                    if (isset($logDispatcher->targets[$targetId]) && $logDispatcher->targets[$targetId] instanceof DbTarget) {
                        $logDispatcher->targets[$targetId]->enabled = $state['enabled'];
                        $logDispatcher->targets[$targetId]->db = $state['db'];
                    }
                }
            }
        }
    }

    /**
     * Roll back migration steps by selecting migrationPath from latest applied version.
     *
     * @param string $routeBase migrate|rbac-migrate
     * @param string $migrationTable
     * @param array<int,string> $migrationPaths
     * @param int $limit
     * @param Connection $db
     */
    private function rollbackByResolvedPath($routeBase, $migrationTable, array $migrationPaths, $limit, Connection $db)
    {
        $resolvedPaths = [];
        foreach ($migrationPaths as $path) {
            $resolvedPaths[] = Yii::getAlias($path);
        }

        for ($i = 0; $i < $limit; $i++) {
            $version = $this->latestMigrationVersion($migrationTable, $db);
            if ($version === null) {
                return;
            }

            $path = $this->findMigrationPathForVersion($version, $resolvedPaths);
            if ($path === null) {
                throw new \RuntimeException("Migration file was not found for version [{$version}].");
            }

            $this->executeMigration($routeBase . '/down', [
                'migrationPath' => $path,
                0 => 1,
                'interactive' => false,
            ]);
        }
    }

    /**
     * @param string $migrationTable
     * @param Connection $db
     * @return string|null
     */
    private function latestMigrationVersion($migrationTable, Connection $db)
    {
        $table = $db->schema->getRawTableName($migrationTable);
        if ($db->schema->getTableSchema($table, true) === null) {
            return null;
        }

        $version = $db->createCommand(
            "SELECT [[version]] FROM {$db->quoteTableName($table)} WHERE [[version]] <> :base ORDER BY [[apply_time]] DESC, [[version]] DESC LIMIT 1",
            [':base' => 'm000000_000000_base']
        )->queryScalar();

        return $version === false ? null : (string) $version;
    }

    /**
     * @param string $version
     * @param array<int,string> $paths
     * @return string|null
     */
    private function findMigrationPathForVersion($version, array $paths)
    {
        foreach ($paths as $path) {
            if (is_file($path . DIRECTORY_SEPARATOR . $version . '.php')) {
                return $path;
            }
        }

        return null;
    }

    /**
     * @param string $dsn
     * @return string|null
     */
    private function extractDatabaseName($dsn)
    {
        if (preg_match('/(?:^|;)dbname=([^;]+)/', $dsn, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    /**
     * @param string $dsn
     * @return string
     */
    private function removeDatabaseNameFromDsn($dsn)
    {
        $dsn = preg_replace('/(^|;)dbname=[^;]+;?/', '$1', $dsn);
        $dsn = preg_replace('/;;+/', ';', (string) $dsn);

        return rtrim((string) $dsn, ';');
    }

    /**
     * Basic validation so DB name is safe for SQL identifiers.
     *
     * @param string $name
     */
    private function assertSafeIdentifier($name)
    {
        if (!preg_match('/^[A-Za-z0-9_]+$/', $name)) {
            throw new \InvalidArgumentException("Unsafe database name: {$name}");
        }
    }

    /**
     * Resolve env value with priority from the project .env file.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    private function envValue($key, $default = null)
    {
        $values = $this->loadDotEnvValues();
        if (array_key_exists($key, $values)) {
            return $values[$key];
        }

        return env($key, $default);
    }

    /**
     * @return array<string,string>
     */
    private function loadDotEnvValues()
    {
        if ($this->dotEnvValues !== null) {
            return $this->dotEnvValues;
        }

        $file = dirname(__DIR__, 2) . '/.env';
        if (!is_file($file) && Yii::getAlias('@base', false) !== false) {
            $file = Yii::getAlias('@base/.env');
        }

        if (!is_file($file)) {
            $this->dotEnvValues = [];
            return $this->dotEnvValues;
        }

        $values = [];
        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }

            $pos = strpos($line, '=');
            if ($pos === false) {
                continue;
            }

            $name = trim(substr($line, 0, $pos));
            $value = trim(substr($line, $pos + 1));
            if ($name === '') {
                continue;
            }

            // Strip simple quotes for compatibility with common .env formats.
            if ((strlen($value) >= 2) && (
                    ($value[0] === '"' && substr($value, -1) === '"') ||
                    ($value[0] === "'" && substr($value, -1) === "'")
                )) {
                $value = substr($value, 1, -1);
            }

            $values[$name] = $value;
        }

        $this->dotEnvValues = $values;
        return $this->dotEnvValues;
    }

    /**
     * Run migrations for all/specific targets.
     *
     * @param string $target all|main|test
     * @return int
     */
    public function actionMigrate($target = 'all')
    {
        $hasError = false;

        foreach ($this->resolveTargets($target) as $name => $config) {
            try {
                $this->runMigrationsForTarget($name, $config);
            } catch (\Throwable $e) {
                $hasError = true;
                Console::error("Migration failed for {$name}: " . $e->getMessage());
            }
        }

        return $hasError
            ? ExitCode::UNSPECIFIED_ERROR
            : ExitCode::OK;
    }

    /**
     * Execute migration action safely.
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    private function executeMigration($route, array $params = [])
    {
        Yii::$app->runAction($route, $params);
    }
}
