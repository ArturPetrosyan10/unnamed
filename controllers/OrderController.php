<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderSearch;
use app\models\ProviderOrders;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
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

    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        if ($action->id == 'your-action') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    /**
     * Lists all Order models.
     *
     * @return string
     */

    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = new Order();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');
                $model->save();
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Order();
        if ($this->request->isPost) {
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            if ($model->load($this->request->post()) && $model->save()) {
                $model->created_at = date('Y-m-d H:i:s');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionAddOrders(){
        if($_POST){
            $post = $_REQUEST;

            $postData = json_encode($post);
            $filePath = '../views/order/request';
//            file_put_contents($filePath, $postData['Amount'], FILE_APPEND);
            $order = new Order();
            $order->customer_name = $post['Customer_name'];
            $order->customer_id = 11;
            $order->customer_mobile = $post['Customer_mobile'];
            $order->customer_comment = $post['Customer_comment'];
            $order->reference = $post['Reference'];
            $order->description = $post['Description'];
            $order->link = $post['Link'];
            $order->social_type = $post['Social_Type'];
            $order->amount = $post['Amount'];
            $order->created_at = date('Y-m-d H:i:s');
            $order->updated_at = date('Y-m-d H:i:s');
            $order->charge = 0;
            $order->save();
            file_put_contents($filePath, $postData, FILE_APPEND);
            die;
//            $prov_order = new ProviderOrders();
//            $prov_order->currency = $post['customer'];
//            $prov_order->customer_name = $post['customer_name'];
//            $prov_order->customer_mobile = $post['customer_mobile'];
//            $prov_order->customer_comment = $post['customer_comment'];
//            $prov_order->reference = $post['reference'];
//            $prov_order->description = $post['description'];
//            $prov_order->link = $post['link'];
//            $prov_order->social_type = $post['social_type'];
//            file_put_contents($filePath,$prov_order->save(), FILE_APPEND);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionGetSubOrders() {
        if(\Yii::$app->request->get()){
            $get = \Yii::$app->request->get();
            $sub_orders = ProviderOrders::find()->where(['order_id' => $get['id']])->all();
//            var_dump($sub_orders);
            return $this->renderAjax('sub-orders', ['sub_orders' => $sub_orders]);
        }
    }


}
