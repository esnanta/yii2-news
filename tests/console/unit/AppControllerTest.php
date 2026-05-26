<?php

namespace tests\console\unit;

use Codeception\Test\Unit;
use console\controllers\AppController;

/**
 * @internal
 *
 * @coversNothing
 */
class AppControllerTest extends Unit
{
    public function testActionSetKeysReplacesGeneratedKeyPlaceholders(): void
    {
        $tempFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid('app_set_keys_', false).'.env';
        $initialContent = "APP_KEY=<generated_key>\nJWT_KEY=<generated_key>\n";
        file_put_contents($tempFile, $initialContent);

        $controller = new AppController('app', \Yii::$app);
        $controller->generateKeysPaths = [$tempFile];

        $controller->actionSetKeys();

        $updatedContent = file_get_contents($tempFile);

        $this->assertStringNotContainsString('<generated_key>', $updatedContent);
        $this->assertMatchesRegularExpression('/APP_KEY=[A-Za-z0-9_-]{32}/', $updatedContent);
        $this->assertMatchesRegularExpression('/JWT_KEY=[A-Za-z0-9_-]{32}/', $updatedContent);

        unlink($tempFile);
    }

    public function testActionSetWritableMakesConfiguredFileWritable(): void
    {
        $tempFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid('app_set_writable_', false).'.tmp';
        file_put_contents($tempFile, 'content');
        chmod($tempFile, 0444);

        $controller = new AppController('app', \Yii::$app);
        $controller->writablePaths = [$tempFile];

        $controller->actionSetWritable();

        clearstatcache(true, $tempFile);
        $this->assertTrue(is_writable($tempFile));

        unlink($tempFile);
    }
}
