<?php

namespace backend\modules\content\controllers;

use Yii;
use common\models\SocialPlatform;
use common\models\search\SocialPlatformSearch;
use common\base\BaseController;
use yii\db\Exception;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * SocialPlatformController implements the CRUD actions for the SocialPlatform model.
 */
class SocialPlatformController extends BaseController
{

    public function behaviors(): array
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
     * Lists all SocialPlatform models.
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        $this->checkAccess('socialPlatform.index');

        $searchModel = new SocialPlatformSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SocialPlatform model.
     * @param int $id ID
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $this->checkAccess('socialPlatform.view');

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SocialPlatform model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws ForbiddenHttpException
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $this->checkAccess('socialPlatform.create');

        $model = new SocialPlatform();

        if (
            $model->loadSafely(Yii::$app->request->post()) &&
            $model->saveSafely()
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SocialPlatform model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return Response|string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate(int $id): Response|string
    {
        $this->checkAccess('socialPlatform.update');

        $model = $this->findModel($id);

        if (
            $model->loadSafely(Yii::$app->request->post()) &&
            $model->saveSafely()
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SocialPlatform model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $this->checkAccess('socialPlatform.delete');
        $model->deleteSafely();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SocialPlatform model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SocialPlatform the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): SocialPlatform    {
        if (($model = SocialPlatform::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
