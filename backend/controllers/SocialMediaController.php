<?php

namespace backend\controllers;

use Yii;
use backend\models\SocialMedia;
use backend\models\SocialMediaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SocialMediaController implements the CRUD actions for SocialMedia model.
 */
class SocialMediaController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all SocialMedia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SocialMediaSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single SocialMedia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model              = $this->findModel($id);
        $socialMediaList    = SocialMedia::getArraySocMed();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', [
                'model' => $model,
                'socialMediaList' => $socialMediaList,
            ]);
        }
    }

    /**
     * Creates a new SocialMedia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model              = new SocialMedia;
        $model->description = '@';
        $socialMediaList    = SocialMedia::getArraySocMed();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'socialMediaList' => $socialMediaList,
            ]);
        }
    }

    /**
     * Updates an existing SocialMedia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model              = $this->findModel($id);
        $socialMediaList    = SocialMedia::getArraySocMed(); 
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['theme-detail/index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'socialMediaList' => $socialMediaList,
            ]);
        }
    }

    /**
     * Deletes an existing SocialMedia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SocialMedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SocialMedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SocialMedia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
