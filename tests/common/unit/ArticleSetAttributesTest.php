<?php

namespace tests\common\unit;

use Codeception\Test\Unit;
use common\models\Article;

class ArticleSetAttributesTest extends Unit
{
    public function testItNormalizesEmptyUploadValues(): void
    {
        $article = new Article();

        $article->setAttributes([
            'thumbnail' => '',
            'attachments' => '',
        ]);

        $this->assertNull($article->thumbnail);
        $this->assertSame([], $article->attachments);
    }

    public function testItNormalizesNullUploadValues(): void
    {
        $article = new Article();

        $article->setAttributes([
            'thumbnail' => null,
            'attachments' => null,
        ]);

        $this->assertNull($article->thumbnail);
        $this->assertSame([], $article->attachments);
    }

    public function testItKeepsValidUploadArrays(): void
    {
        $article = new Article();

        $thumbnail = [
            'path' => '/storage/source/a.jpg',
            'base_url' => '/storage',
        ];
        $attachments = [
            ['path' => '/storage/source/b.pdf'],
            ['path' => '/storage/source/c.pdf'],
        ];

        $article->setAttributes([
            'thumbnail' => $thumbnail,
            'attachments' => $attachments,
        ]);

        $this->assertSame($thumbnail, $article->thumbnail);
        $this->assertSame($attachments, $article->attachments);
    }
}

