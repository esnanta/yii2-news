<?php

namespace backend\modules\widget\controllers;

use backend\modules\widget\models\search\ImageSearch;
use common\models\WidgetImage;
use common\traits\FormAjaxValidationTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ImageController extends Controller
{
    use FormAjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $widgetImage = new WidgetImage();

        $this->performAjaxValidation($widgetImage);

        if ($widgetImage->load(Yii::$app->request->post()) && $widgetImage->save()) {
            return $this->redirect(['index']);
        }

        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $widgetImage,
        ]);
    }

    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $widgetImage = $this->findWidget($id);

        $this->performAjaxValidation($widgetImage);

        if ($widgetImage->load(Yii::$app->request->post()) && $widgetImage->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $widgetImage,
        ]);
    }

    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findWidget($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     *
     * @return WidgetImage
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findWidget($id)
    {
        if (($model = WidgetImage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

