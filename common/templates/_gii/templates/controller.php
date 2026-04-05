<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
$permissionPrefix = lcfirst($modelClass);

$tableSchema = $class::getTableSchema();
$phpTypeMap = [
    'integer' => 'int',
    'boolean' => 'bool',
    'double' => 'float',
    'string' => 'string',
];
$typedActionParams = $actionParams;

if ($actionParams !== '') {
    $actionParamList = array_map('trim', explode(',', $actionParams));

    foreach ($actionParamList as $index => $actionParam) {
        $pk = $pks[$index] ?? null;
        $column = $pk !== null ? ($tableSchema->columns[$pk] ?? null) : null;
        $phpType = $column !== null ? ($phpTypeMap[$column->phpType] ?? null) : null;

        if ($phpType !== null) {
            $actionParamList[$index] = $phpType . ' ' . $actionParam;
        }
    }

    $typedActionParams = implode(', ', $actionParamList);
}

echo "<?php\n";
?>

namespace <?php echo StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?php echo ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?php echo ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?php echo ltrim($generator->baseControllerClass, '\\') ?>;
use yii\db\Exception;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * <?php echo $controllerClass ?> implements the CRUD actions for the <?php echo $modelClass ?> model.
 */
class <?php echo $controllerClass ?> extends <?php echo StringHelper::basename($generator->baseControllerClass) . "\n" ?>
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
     * Lists all <?php echo $modelClass ?> models.
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        $this->checkAccess('<?php echo $permissionPrefix ?>.index');

<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?php echo isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?php echo $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    /**
     * Displays a single <?php echo $modelClass ?> model.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView(<?php echo $typedActionParams ?>): string
    {
        $this->checkAccess('<?php echo $permissionPrefix ?>.view');

        return $this->render('view', [
            'model' => $this->findModel(<?php echo $actionParams ?>),
        ]);
    }

    /**
     * Creates a new <?php echo $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws ForbiddenHttpException
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $this->checkAccess('<?php echo $permissionPrefix ?>.create');

        $model = new <?php echo $modelClass ?>();

        if (
            $model->loadSafely(Yii::$app->request->post()) &&
            $model->saveSafely()
        ) {
            return $this->redirect(['view', <?php echo $urlParams ?>]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing <?php echo $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return Response|string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate(<?php echo $typedActionParams ?>): Response|string
    {
        $this->checkAccess('<?php echo $permissionPrefix ?>.update');

        $model = $this->findModel(<?php echo $actionParams ?>);

        if (
            $model->loadSafely(Yii::$app->request->post()) &&
            $model->saveSafely()
        ) {
            return $this->redirect(['view', <?php echo $urlParams ?>]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing <?php echo $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionDelete(<?php echo $typedActionParams ?>): Response
    {
        $model = $this->findModel(<?php echo $actionParams ?>);
        $this->checkAccess('<?php echo $permissionPrefix ?>.delete');
        $model->deleteSafely();

        return $this->redirect(['index']);
    }

    /**
     * Finds the <?php echo $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?php echo $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?php echo $typedActionParams ?>): <?php echo $modelClass ?>
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?php echo $modelClass ?>::findOne(<?php echo $condition ?>)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
