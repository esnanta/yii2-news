<?php

namespace tests\common\unit;

use Codeception\Test\Unit;
use common\models\Article;
use yii\db\Expression;

class ArticleQueryTest extends Unit
{
    public function testPublishedScopeReturnsOnlyPublishedArticles(): void
    {
        $query = Article::find()->published();

        $this->assertIsArray($query->where);
        $this->assertSame('and', $query->where[0]);

        $statusCondition = $query->where[1];
        $publishedAtCondition = $query->where[2];

        $this->assertSame(Article::STATUS_PUBLISHED, $statusCondition['{{%article}}.[[status]]']);
        $this->assertSame('<=', $publishedAtCondition[0]);
        $this->assertSame('{{%article}}.[[published_at]]', $publishedAtCondition[1]);
        $this->assertInstanceOf(Expression::class, $publishedAtCondition[2]);
        $this->assertSame('NOW()', (string) $publishedAtCondition[2]);
    }
}

