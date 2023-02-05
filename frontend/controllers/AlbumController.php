<?php

namespace frontend\controllers;

use Yii;
use backend\models\Album;
use backend\models\AlbumSearch;
use backend\models\Lookup;
use backend\models\Photo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; // load classes
use yii\data\ArrayDataProvider;

/**
 * AlbumController implements the CRUD actions for Album model.
 */
class AlbumController extends Controller
{

    public $layout = "/column1_album";  

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
     * Lists all Album models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlbumSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataList = Album::getArrayAlbumType();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'dataList'=>$dataList
        ]);
    }

    /**
     * Displays a single Album model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $dataList=ArrayHelper::map(Lookup::find()->where(['category' =>  Yii::$app->params['LookupCategory_PrivatePublic']])->asArray()->all(), 'id','title');

        $providerPhoto = new ArrayDataProvider([
            'allModels' => $model->photos,
            'pagination' => [
                    'pagesize' => 16,
            ],
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', [
                'model' => $model,
                'dataList'=>$dataList,
                'providerPhoto'=>$providerPhoto
            ]);
        }
    }

    /**
     * Creates a new Album model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Album;
        $dataList=ArrayHelper::map(Lookup::find()->where(['category' => Yii::$app->params['LookupCategory_PrivatePublic']])->asArray()->all(), 'id','title');

        try {

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'dataList'=>$dataList
                ]);
            }

        }
        catch (StaleObjectException $e) {
            throw new StaleObjectException('The object being updated is outdated.');
        }

    }

    /**
     * Updates an existing Album model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dataList=ArrayHelper::map(Lookup::find()->where(['category' => Yii::$app->params['LookupCategory_PrivatePublic']])->asArray()->all(), 'id','title');

        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'dataList'=>$dataList
                ]);
            }
        }
        catch (StaleObjectException $e) {
            throw new StaleObjectException('The object being updated is outdated.');
        }

    }

    /**
     * Deletes an existing Album model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Album model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Album the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Album::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionSetCover($id,$title=null){
        $photo = Photo::find()->where(['id'=>$id])->one();
        $model = Album::find()->where(['id'=>$photo->album_id])->one();
        $model->cover = $photo->file_name;
        $model->save();
        return $this->redirect(['view', 'id' => $model->id]);
    }
}
