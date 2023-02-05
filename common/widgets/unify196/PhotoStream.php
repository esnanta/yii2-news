<?php
namespace common\widgets\unify196;

use Yii;
use yii\base\Widget;
use backend\models\Photo;
use backend\models\Lookup as Lookup;

class PhotoStream extends Widget
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

        $models = Photo::find()->limit(9)
            ->joinWith('album')
            ->where([
                'tx_album.album_type' => Lookup::getId(Yii::$app->params['LookupToken_Public'])])
            ->orderBy(['created_at'=>SORT_DESC])
            ->all();  
    
        return $this->render('_unify196_photo_stream', [
            'title' => $this->title,
            'models' => $models,
        ]);
    }
}