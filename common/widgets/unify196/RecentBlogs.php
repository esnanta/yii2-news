<?php
namespace common\widgets\unify196;

use Yii;
use yii\base\Widget;
use backend\models\Blog as Blog;
use backend\models\Comment as Comment;

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
        $blogs = Blog::find()->where(['publish_status' =>Blog::PUBLISH_STATUS_YES])->orderBy(['created_at' => SORT_DESC])->limit($this->maxData)->all();
        
        return $this->render('_unify196_recent_blog', [
            'title' => $this->title,
            'blogs' => $blogs,
            
        ]);
    }
}