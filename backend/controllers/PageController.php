<?php

namespace backend\controllers;


use common\helper\MessageHelper;
use common\models\Page;
use common\models\PageSearch;
use common\service\DataListService;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ThemeDetailController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'remove-content' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex($type)
    {
        if (Yii::$app->user->can('index-page')) {
            $searchModel = new PageSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
            $dataProvider->query->andWhere(['page_type' => $type]);

            $dataList = DataListService::getPage();
            $pageTypeList = Page::getArrayPageType();

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'pageTypeList' => $pageTypeList,
                'dataList' => $dataList,
            ]);
        } else {
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     * @throws Exception
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('view-page')) {
            $model = $this->findModel($id);
            $dataList = DataListService::getPage();
            $pageTypeList = Page::getArrayPageType();

            if ($model->load(Yii::$app->request->post())) {
                return $this->validateAndSave($model);
            } else {
                return $this->render('view', [
                    'model' => $model,
                    'dataList' => $dataList,
                    'pageTypeList' => $pageTypeList,
                ]);
            }
        } else {
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Exception
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-page')) {
            $model = new Page;
            $dataList = DataListService::getPage();
            $pageTypeList = Page::getArrayPageType();

            if ($model->load(Yii::$app->request->post())) {
                return $this->validateAndSave($model);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'dataList' => $dataList,
                    'pageTypeList' => $pageTypeList,
                ]);
            }
        } else {
            MessageHelper::getFlashAccessDenied();
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('update-page')) {
            $model = $this->findModel($id);
            $dataList = DataListService::getPage();
            $pageTypeList = Page::getArrayPageType();

            if ($model->load(Yii::$app->request->post())) {
                return $this->validateAndSave($model);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'dataList' => $dataList,
                    'pageTypeList' => $pageTypeList,
                ]);
            }
        } else {
            MessageHelper::getFlashAccessDenied();
            return throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-page')) {
            $this->findModel($id)->delete();
            MessageHelper::getFlashDeleteSuccess();
            return $this->redirect(['index']);
        } else {
            MessageHelper::getFlashAccessDenied();
            return throw new ForbiddenHttpException;
        }
    }

    /**
     * @throws \yii\db\Exception
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionEmpty($id): Response
    {
        if (Yii::$app->user->can('delete-page')) {
            $model = $this->findModel($id);
            $model->content = '';
            $model->save();
            MessageHelper::getFlashRemoveContentSuccess();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            MessageHelper::getFlashAccessDenied();
            return throw new ForbiddenHttpException;
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Page
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @throws \yii\db\Exception
     */
    private function validateAndSave(Page $model): Response
    {
        if ($model->validate() && $model->save()) {
            MessageHelper::getFlashSaveSuccess();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            MessageHelper::getFlashImageExceed();
            return $this->redirect(['view', 'id' => $model->id, 'edit' => 't']);
        }
    }
}
