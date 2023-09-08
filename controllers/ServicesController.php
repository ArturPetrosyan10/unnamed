<?php

namespace app\controllers;

use app\models\BoostServices;
use app\models\Providers;
use app\models\ServiceLogs;
use app\models\Services;
use app\models\ServicesSearch;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ServicesController implements the CRUD actions for Services model.
 */
class ServicesController extends Controller
{
    /**
     * @inheritDoc
     */
//    public function behaviors()
//    {
//        return array_merge(
//            parent::behaviors(),
//            [
//                'verbs' => [
//                    'class' => VerbFilter::className(),
//                    'actions' => [
//                        'delete' => ['POST'],
//                    ],
//                ],
//            ]
//        );
//    }
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['categories','index','create','update','delete','View'], // Укажите здесь действия, которые хотите ограничить
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['index', 'create'],
                        'roles' => ['?'], // Запретить доступ для гостей (неавторизованных пользователей)
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'], // Разрешить доступ для авторизованных пользователей
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['site/login']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all Services models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new Services();
        $service_log = new ServiceLogs();
        $user_id = \Yii::$app->user->identity->id;
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            if(@$post['id']){
                $model = Services::findOne([$post['id']]);
            }
            $service_log->from_def_service = @$model->def_service;
            $service_log->from_def_provider = @$model->def_provider;
            $model->load($this->request->post());

            if (@$post['Services']['def_provider'] && @$post['Services']['def_provider'] != "select Default provider"){
                $model->def_provider = $post['Services']['def_provider'];
            }
            if(@$post['Services']['def_service']){
                $model->def_service =  $post['Services']['def_service'];
                $model->price = BoostServices::findOne($model->def_service)->rate;

            }
            if(@$model->def_service && @$model->def_provider){
                $model->def_boost_service = BoostServices::findOne($model->def_service)->service_id;
            }
            if (!@$model->id){
                $model->created_at = date('Y-m-d H:i:s');
            }
            $model->updated_at = date('Y-m-d H:i:s');
            $service_log->updated = date('Y-m-d H:i:s');
            $service_log->to_def_service = @$model->def_service;
            $service_log->to_def_provider = @$model->def_provider;
            $service_log->user_id = $user_id;
            $model->save();
            $service_log->service_id = @$model->id;
            $service_log->save();
            $this->redirect('index');
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Services model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        if(\Yii::$app->request->post()){
            $post = \Yii::$app->request->post();
            $id = $post['view_id'];
            $model = $this->findModel($id);
            return $this->renderAjax('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Services model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Services();
        if ($this->request->isPost) {

            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Services model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        if(\Yii::$app->request->post()){
            $post = \Yii::$app->request->post();
            $id = $post['service_id'];
            $model = $this->findModel($id);
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionDefServices()
    {
        if(\Yii::$app->request->post()){
            $id = $_POST['id'];
            $name = Providers::findOne($id)->name;
            $st = $_POST['name'];
            $boost_services = BoostServices::find()->where(['=','services_from',$name])->andWhere(['like','name',$st])->asArray()->all();
            return Json::encode($boost_services);
        }
    }

    /**
     * Deletes an existing Services model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Services::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
