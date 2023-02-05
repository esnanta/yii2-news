<?php
namespace common\widgets\portfolio7;

use Yii;
use yii\base\Widget;

class Breadcrumbs extends Widget
{
    public $indexTitle;
    public $pageTitle;

    public function init()
    {
        parent::init();
        
        if ($this->indexTitle === null) {
            $this->indexTitle = 'index';
        }
        
        if ($this->pageTitle === null) {
            $this->pageTitle = 'title';
        }
    }

    public function run()
    {
        return $this->render('_breadcrumbs', [
            'indexTitle' => $this->indexTitle,
            'pageTitle' => $this->pageTitle,
        ]);
    }
}