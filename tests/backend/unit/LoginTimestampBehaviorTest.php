<?php

namespace tests\backend\unit;

use Codeception\Test\Unit;
use common\behaviors\LoginTimestampBehavior;
use yii\web\UserEvent;

class LoginTimestampBehaviorTest extends Unit
{
    public function testAfterLoginTouchesDefaultAttributeAndSavesWithoutValidation(): void
    {
        $identity = new TestLoginIdentity();
        $event = new UserEvent(['identity' => $identity]);

        $behavior = new LoginTimestampBehavior();
        $behavior->afterLogin($event);

        $this->assertSame('logged_at', $identity->touchedAttribute);
        $this->assertFalse($identity->lastSaveRunValidation);
    }

    public function testAfterLoginUsesCustomAttribute(): void
    {
        $identity = new TestLoginIdentity();
        $event = new UserEvent(['identity' => $identity]);

        $behavior = new LoginTimestampBehavior();
        $behavior->attribute = 'last_seen_at';
        $behavior->afterLogin($event);

        $this->assertSame('last_seen_at', $identity->touchedAttribute);
        $this->assertFalse($identity->lastSaveRunValidation);
    }
}
