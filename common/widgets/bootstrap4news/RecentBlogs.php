<?php
namespace common\widgets\bootstrap4news;

use Yii;
use yii\base\Widget;
use common\models\Article as Article;

class RecentBlogs extends Widget
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
        $blogs = Article::find()->where(['publish_status' => Article::PUBLISH_STATUS_YES])->orderBy(['created_at' => SORT_DESC])->limit($this->maxData)->all();
        return $this->render('_recent_blog', [
            'title' => $this->title,
            'blogs' => $blogs,
        ]);
    }
}