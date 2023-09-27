<?php

namespace app\controllers;

use app\models\ProviderOrders;
use app\models\ProviderOrdersSearch;
use app\models\Services;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProviderOrdersController implements the CRUD actions for ProviderOrders model.
 */
class ProviderOrdersController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()

    {
        $searchModel = new ProviderOrdersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetComment(){
        if (isset($_GET['id']) || isset($_GET['not_confirmed'])) {
            return $this->renderAjax('comment', ['get' => $_GET]);
        }
    }
    public function actionPayment(){
        if (isset($_GET['id'])) {
            return $this->renderAjax('payment', ['get' => $_GET]);
        }
    }
    public function actionDeleteProviderOrder(){
        if (isset($_POST['id'])) {
            return $this->renderAjax('delete', ['get' => $_POST]);
        }
    }
    public function actionAddLink(){
        if (isset($_GET['id'])) {
            return $this->renderAjax('add-link', ['get' => $_GET]);
        }
    }
    public function actionViewMore(){
        if (isset($_GET['swipe_page'])) {
            $searchModel = new ProviderOrdersSearch();
            $query = $searchModel->prov_search($this->request->queryParams);
            $model = new ProviderOrders();
            $services = $model->getServices();
            return $this->renderAjax('view-more', [
                'get' => $_GET,
                'services' => $services,
                'query' => $query
            ]);
        }
    }
    public function actionGetBalance(){
        if (isset($_GET['service_id'])) {
            $model = Services::find()
                ->select('providers.balance , services.price')
                ->where(['services.id' => $_GET['service_id']])
                ->leftJoin('providers','services.def_provider = providers.id')
                ->asArray()
                ->one();
            return json_encode([$model['balance'],$model['price']]);
        }
    }
    public function actionConfirmAllViews(){
        return $this->renderAjax('confirm-all-views',['get' => $_GET['form']]);
    }
    public function actionDelete(){
        if (isset($_POST['id'])) {
            $model = ProviderOrders::findOne($_POST['id']);
            $model->delete();
        }
        $this->redirect(Yii::$app->urlManager->createUrl(['order/test']));
    }
    public function actionConfirmPayment(){
        if(isset($_POST['id'])){
            $prov_o =  ProviderOrders::findOne($_POST['id']);
            if (isset($_POST['to_confirm']) && $_POST['to_confirm'] == 1){
                $prov_o->status_paid = 1;
            }else{
                $prov_o->status_paid = 0;
            }
            $prov_o->save();
        }
        $this->redirect(Yii::$app->urlManager->createUrl(['order/test']));
    }

    protected function findModel($id)
    {
        if (($model = ProviderOrders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
