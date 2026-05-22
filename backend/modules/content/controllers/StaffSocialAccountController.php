<?php

namespace backend\modules\content\controllers;

use common\base\BaseController;
use common\models\search\StaffSocialAccountSearch;
use common\models\Staff;
use common\models\StaffSocialAccount;
use common\service\DataListService;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * StaffSocialAccountController implements the CRUD actions for the StaffSocialAccount model.
 */
class StaffSocialAccountController extends BaseController
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
     * Lists all StaffSocialAccount models.
     *
     * @throws ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        $this->checkAccess('staffSocialAccount.index');

        $searchModel = new StaffSocialAccountSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'officeOptions' => DataListService::getOffice(),
            'staffOptions' => DataListService::getStaff(),
            'platformOptions' => DataListService::getSocialPlatform(),
        ]);
    }

    /**
     * Displays a single StaffSocialAccount model.
     *
     * @param int $id ID
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $this->checkAccess('staffSocialAccount.view');

        return $this->render('view', [
            'model' => $this->findModel($id),
            'officeOptions' => DataListService::getOffice(),
            'staffOptions' => DataListService::getStaff(),
            'platformOptions' => DataListService::getSocialPlatform(),
        ]);
    }

    /**
     * Creates a new StaffSocialAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @throws ForbiddenHttpException
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $this->checkAccess('staffSocialAccount.create');

        $model = new StaffSocialAccount();
        $staffId = (int) \Yii::$app->request->get('staff_id');
        $staff = $staffId > 0 ? Staff::findOne($staffId) : null;
        if ($staff !== null) {
            $model->staff_id = $staff->id;
            $model->office_id = $staff->office_id;
        }

        if ($model->loadSafely(\Yii::$app->request->post())) {
            if ($staff !== null) {
                $model->staff_id = $staff->id;
                $model->office_id = $staff->office_id;
            }

            if ($model->saveSafely()) {
                if ($staffId > 0) {
                    return $this->redirect(['staff/view', 'id' => $model->staff_id, 'tab' => 'social-account']);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'officeOptions' => DataListService::getOffice(),
            'staffOptions' => DataListService::getStaff(),
            'platformOptions' => DataListService::getSocialPlatform(),
        ]);
    }

    /**
     * Updates an existing StaffSocialAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id ID
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate(int $id): Response|string
    {
        $this->checkAccess('staffSocialAccount.update');

        $model = $this->findModel($id);
        $staffId = (int) \Yii::$app->request->get('staff_id');

        if ($model->loadSafely(\Yii::$app->request->post())
            && $model->saveSafely()
        ) {
            if ($staffId > 0) {
                return $this->redirect(['staff/view', 'id' => $model->staff_id, 'tab' => 'social-account']);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'officeOptions' => DataListService::getOffice(),
            'staffOptions' => DataListService::getStaff(),
            'platformOptions' => DataListService::getSocialPlatform(),
        ]);
    }

    /**
     * Deletes an existing StaffSocialAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id ID
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $this->checkAccess('staffSocialAccount.delete');
        $staffId = $model->staff_id;
        $model->deleteSafely();

        if ((int) \Yii::$app->request->get('staff_id') > 0) {
            return $this->redirect(['staff/view', 'id' => $staffId, 'tab' => 'social-account']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the StaffSocialAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     *
     * @return StaffSocialAccount the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): StaffSocialAccount
    {
        if (($model = StaffSocialAccount::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
