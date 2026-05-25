<?php

namespace tests\backend\unit;

use Codeception\Test\Unit;
use common\validators\JsonValidator;

class JsonValidatorTest extends Unit
{
    public function testValidateValuePassesForValidJson(): void
    {
        $validator = new JsonValidator();
        $validator->init();

        $result = $validator->validateValue('{"name":"demo","active":true}');

        $this->assertNull($result);
    }

    public function testValidateValueReturnsErrorForInvalidJson(): void
    {
        $validator = new JsonValidator();
        $validator->init();

        $result = $validator->validateValue('{"name":demo}');

        $this->assertIsArray($result);
        $this->assertStringContainsString('valid JSON', $result[0]);
    }
}
