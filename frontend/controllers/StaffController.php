<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; // load classes

use backend\models\Staff;
use backend\models\StaffSearch;
use backend\models\Employment;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
{
    
    public $layout = "/column1";
    
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
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->query->andWhere('active_status = '.Staff::ACTIVE_STATUS_YES);
        $employments = Employment::find()->orderBy(['sequence' => SORT_ASC])->all();
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'employments'=>$employments
        ]);
    }

    /**
     * Displays a single Staff model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $employmentList=ArrayHelper::map(Employment::find()->asArray()->all(), 'id','title');
        $genderList=Staff::getArrayGenderStatus();
        
        $oldFile = $model->getImageFile();
        $oldAvatar = $model->file_name;
        $oldFileName = $model->title;

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();

            // revert back if no valid file instance uploaded
            if ($image === false) {
                $model->file_name = $oldAvatar;
                $model->title = $oldFileName;
            }

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) { // delete old and overwrite
                    file_exists($oldFile) ? unlink($oldFile) : '' ;
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                // error in saving model
            }
        }        
        else {
            return $this->render('view', [
                'model' => $model,
                'employmentList'=>$employmentList,
                'genderList'=>$genderList
            ]);
        }              
        
    }

    /**
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Staff;
        $employmentList=ArrayHelper::map(Employment::find()->asArray()->all(), 'id','title');
        $genderList=Staff::getArrayGenderStatus();
        
        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();    
            
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) {
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                // error in saving model
            }
        }
        return $this->render('create', [
            'model'=>$model,
            'employmentList'=>$employmentList,
            'genderList'=>$genderList
        ]);           
        
    }

    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $employmentList=ArrayHelper::map(Employment::find()->asArray()->all(), 'id','title');
        $genderList=Staff::getArrayGenderStatus();
        
        $oldFile = $model->getImageFile();
        $oldAvatar = $model->file_name;
        $oldFileName = $model->title;

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();

            // revert back if no valid file instance uploaded
            if ($image === false) {
                $model->file_name = $oldAvatar;
                $model->title = $oldFileName;
            }

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) { // delete old and overwrite
                    file_exists($oldFile) ? unlink($oldFile) : '' ;
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                // error in saving model
            }
        }
        return $this->render('update', [
            'model'=>$model,
            'employmentList'=>$employmentList,
            'genderList'=>$genderList
        ]);         
        
        
    }

    /**
     * Deletes an existing Staff model.
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
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
