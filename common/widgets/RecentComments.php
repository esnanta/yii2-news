<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use backend\models\Comment as Comment;

class RecentComments extends Widget
{
    public $title;
    public $maxData = 5;

    public function init()
    {
        parent::init();

        if ($this->title === null) {
            $this->title = 'title';
        }
    }

    public function run()
    {
        $comments = Comment::findRecentComments($this->maxData);

        return $this->render('_recent_comment', [
            'title' => $this->title,
            'comments' => $comments,
        ]);
    }
}