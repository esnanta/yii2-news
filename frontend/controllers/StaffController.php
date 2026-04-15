<?php

namespace frontend\controllers;

use common\models\JobTitle;
use common\models\search\StaffSearch;
use common\models\search\StaffSocialAccountSearch;
use common\models\Staff;
use common\models\StaffSocialAccount;
use common\service\DataListService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

// load classes

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
{
    public $layout = '/column1';

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
     * Lists all Staff models.
     */
    public function actionIndex(): string
    {
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());
        $dataProvider->query->andWhere('status = ' . Staff::STATUS_ACTIVE);
        $jobTitles = JobTitle::find()->orderBy(['sequence' => SORT_ASC])->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'jobTitles' => $jobTitles,
        ]);
    }

    /**
     * Displays a single Staff model.
     */
    public function actionView(int $id): Response|string
    {
        $model = $this->findModel($id);
        $searchModelMedia = new StaffSocialAccountSearch();
        $dataProviderSocial = $searchModelMedia->search(\Yii::$app->request->getQueryParams());
        $dataProviderSocial->query->andWhere([
            'is_visible' => StaffSocialAccount::FLAG_YES,
            'staff_id' => $model->id,
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProviderSocial' => $dataProviderSocial,
        ]);
    }

    /**
     * Updates an existing Staff model.
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'employmentList' => DataListService::getJobTitle(),
            'genderList' => Staff::genders(),
        ]);
    }



    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Staff the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Staff
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
