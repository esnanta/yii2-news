<?php

/**
 * This is the template for generating a CRUD controller class file.
 */
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator \mootensai\enhancedgii\crud\Generator */
/* @var $relations array */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}
$pks = $generator->tableSchema->primaryKey;
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
$typedActionParams = [];
$typedActionParamNames = [];
foreach ($pks as $pk) {
    $typeHint = '';
    if (isset($generator->tableSchema->columns[$pk])) {
        $phpType = $generator->tableSchema->columns[$pk]->phpType;
        if (in_array($phpType, ['int', 'float', 'bool', 'string'], true)) {
            $typeHint = $phpType . ' ';
        }
    }
    $typedActionParams[] = $typeHint . '$' . $pk;
    $typedActionParamNames[] = '$' . $pk;
}
$typedActionParamsString = implode(', ', $typedActionParams);
$actionParamNamesString = implode(', ', $typedActionParamNames);
$permissionPrefix = lcfirst($modelClass);
echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else : ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use common\base\BaseController;
use yii\data\ArrayDataProvider;
use yii\db\Exception;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends BaseController
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
<?php if ($generator->loggedUserOnly):
    $actions = ["'index'", "'view'", "'create'", "'update'","'delete'"];
    if($generator->pdf){
        array_push($actions,"'pdf'");
    }
    if($generator->saveAsNew){
        array_push($actions,"'save-as-new'");
    }
    foreach ($relations as $name => $rel){
        if ($rel[2] && isset($rel[3]) && !in_array($name, $generator->skippedRelations)){
            array_push($actions,"'".\yii\helpers\Inflector::camel2id('add'.$rel[1])."'");
        }
    }
?>
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [<?= implode(', ',$actions)?>],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
<?php endif; ?>
        ];
    }

    /**
     * Lists all <?= $modelClass ?> models.
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        $this->checkAccess('<?= $permissionPrefix ?>.index');
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else : ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView(<?= $typedActionParamsString ?>): string
    {
        $this->checkAccess('<?= $permissionPrefix ?>.view');

        $model = $this->findModel(<?= $actionParamNamesString ?>);
<?php foreach ($relations as $name => $rel): ?>
<?php if ($rel[2] && isset($rel[3]) && !in_array($name, $generator->skippedRelations)): ?>
        $provider<?= $rel[1]?> = new ArrayDataProvider([
            'allModels' => $model-><?= $name ?>,
        ]);
<?php endif; ?>
<?php endforeach; ?>
        return $this->render('view', [
            'model' => $model,
<?php foreach ($relations as $name => $rel): ?>
<?php if ($rel[2] && isset($rel[3]) && !in_array($name, $generator->skippedRelations)): ?>
            'provider<?= $rel[1]?>' => $provider<?= $rel[1]?>,
<?php endif; ?>
<?php endforeach; ?>
        ]);
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws ForbiddenHttpException
     * @throws Exception
     */
    public function actionCreate()
    {
        $this->checkAccess('<?= $permissionPrefix ?>.create');

        $model = new <?= $modelClass ?>();

        if (
            $model->loadSafely(Yii::$app->request->post()) &&
            $model->saveSafely()
        ) {
            return $this->redirect(['view', <?= $urlParams ?>]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return Response|string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate(<?= $typedActionParamsString ?>)
    {
        $this->checkAccess('<?= $permissionPrefix ?>.update');

<?php if($generator->saveAsNew) : ?>
        if (Yii::$app->request->post('_asnew') == '1') {
            $model = new <?= $modelClass ?>();
        } else {
            $model = $this->findModel(<?= $actionParamNamesString ?>);
        }

<?php else: ?>
        $model = $this->findModel(<?= $actionParamNamesString ?>);

<?php endif; ?>
        if (
            $model->loadSafely(Yii::$app->request->post()) &&
            $model->saveSafely()
        ) {
            return $this->redirect(['view', <?= $urlParams ?>]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionDelete(<?= $typedActionParamsString ?>): Response
    {
        $model = $this->findModel(<?= $actionParamNamesString ?>);
        $this->checkAccess('<?= $permissionPrefix ?>.delete');
        $model->deleteSafely();

        return $this->redirect(['index']);
    }
<?php if ($generator->pdf):?>    
    /**
     * 
     * Export <?= $modelClass ?> information into PDF format.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionPdf(<?= $typedActionParamsString ?>): string
    {
        $this->checkAccess('<?= $permissionPrefix ?>.pdf');

        $model = $this->findModel(<?= $actionParamNamesString ?>);
<?php foreach ($relations as $name => $rel): ?>
<?php if ($rel[2] && isset($rel[3]) && !in_array($name, $generator->skippedRelations)): ?>
        $provider<?= $rel[1] ?> = new ArrayDataProvider([
            'allModels' => $model-><?= $name; ?>,
        ]);
<?php endif; ?>
<?php endforeach; ?>

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
<?php foreach ($relations as $name => $rel): ?>
<?php if ($rel[2] && isset($rel[3]) && !in_array($name, $generator->skippedRelations)): ?>
            'provider<?= $rel[1]?>' => $provider<?= $rel[1] ?>,
<?php endif; ?>
<?php endforeach; ?>
        ]);

        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_CORE,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => \Yii::$app->name],
            'methods' => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }
<?php endif; ?>

<?php if($generator->saveAsNew):?>
    /**
    * Creates a new <?= $modelClass ?> model by another data,
    * so user don't need to input all field from scratch.
    * If creation is successful, the browser will be redirected to the 'view' page.
    *
    * @param mixed $id
    * @return Response|string
    * @throws NotFoundHttpException
    * @throws ForbiddenHttpException
    * @throws Exception
    */
    public function actionSaveAsNew(<?= $typedActionParamsString; ?>): Response|string
    {
        $this->checkAccess('<?= $permissionPrefix ?>.saveAsNew');

        $model = new <?= $modelClass ?>();

        if (Yii::$app->request->post('_asnew') != '1') {
            $model = $this->findModel(<?= $actionParamNamesString; ?>);
        }
    
        if (
            $model->loadSafely(Yii::$app->request->post()) &&
            $model->saveSafely()
        ) {
            return $this->redirect(['view', <?= $urlParams ?>]);
        }

        return $this->render('saveAsNew', [
            'model' => $model,
        ]);
    }
<?php endif; ?>
    
    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $typedActionParamsString ?>): <?= $modelClass ?>
    {
<?php
if (count($pks) === 1) {
    $condition = $typedActionParamNames[0];
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(<?= $generator->generateString('The requested page does not exist.')?>);
        }
    }
<?php foreach ($relations as $name => $rel): ?>
<?php if ($rel[2] && isset($rel[3]) && !in_array($name, $generator->skippedRelations)): ?>
    
    /**
    * Action to load a tabular form grid
    * for <?= $rel[1] . "\n" ?>
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return string
    * @throws NotFoundHttpException
    */
    public function actionAdd<?= $rel[1] ?>(): string
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('<?= $rel[1] ?>');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_form<?= $rel[1] ?>', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(<?= $generator->generateString('The requested page does not exist.')?>);
        }
    }
<?php endif; ?>
<?php endforeach; ?>
}
