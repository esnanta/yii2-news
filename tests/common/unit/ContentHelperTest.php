<?php

namespace tests\common\unit;

use Codeception\Test\Unit;
use common\helpers\ContentHelper;

class ContentHelperTest extends Unit
{
    public function testExcerptConvertsHtmlToNormalizedPlainText(): void
    {
        $html = "<p>Alpha</p>\n<p><strong>Beta</strong></p>";

        $result = ContentHelper::excerpt($html, 100);

        $this->assertSame('Alpha Beta', $result);
    }

    public function testExcerptReturnsEmptyStringForEmptyHtml(): void
    {
        $this->assertSame('', ContentHelper::excerpt('   ', 100));
    }
}

