<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\OrderSearch;
use app\models\ProviderOrders;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        if ($action->id == 'your-action') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
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
//
//            ]
//        );
//    }
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['categories','index','create','update','delete','View','SubOrder','SubOrderMain'], // Укажите здесь действия, которые хотите ограничить
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
     * Lists all Order models.
     *
     * @return string
     * update and create
     */
    public function actionInsta()
    {
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://v1.nocodeapi.com/arturaa/instagram/kdMBfBAoroevTJtC",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'GET',
//            CURLOPT_POSTFIELDS => '{}',
//            CURLOPT_HTTPHEADER => array(
//                'Content-Type: application/json'
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        curl_close($curl);
//        $data = json_decode($response);
//        echo '<pre>';
//        var_dump($data);

        $users = ['user1', 'user2'];
        $accessToken = 'ВАШ_ТОКЕН_ДОСТУПА';

        foreach ($users as $user) {
            $url = "https://graph.instagram.com/v1/users/{artur_petrosyan_1}?fields=id,username,media_count&access_token={IGQVJYVHN5MnR4TmZA1RGdmd3BnUkcxUENqYjNmcFZA4V2hpdzc4U3h2YUF0LUw0bzJZAdEZAITE9BUVRvWjJzMlpQRGFKcXhfVlI5YUNDVUtmUG55MHJVM1Y0RnFyU3A4dU5ZAeC1Bek9rem5pQlE1NWY2MwZDZD}";

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $userData = json_decode($response, true);

            // Обрабатывайте и используйте данные для каждого пользователя по мере необходимости
            // Например:
            echo 'ID пользователя: ' . $userData['id'] . '<br>';
            echo 'Имя пользователя: ' . $userData['username'] . '<br>';
            echo 'Количество медиа: ' . $userData['media_count'] . '<br><br>';
        }

    }


    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = new Order();
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($this->request->post('id')) {
                $model = Order::findOne([$this->request->post('id')]);
                $model->updated_at = date('Y-m-d H:i:s');
            }
            if ($model->load($this->request->post())) {
                if (!$model->id){
                    $model->created_at = date('Y-m-d H:i:s');
                }
                $model->updated_at = date('Y-m-d H:i:s');

                $model->customer_name = $post['Order']['customer_name'] ?? '';
                $model->currency = $post['Order']['currency'] ?? '';
                $model->customer_mobile = $post['Order']['customer_mobile'] ?? '';
                $model->customer_comment = $post['Order']['customer_comment'] ?? '';
                $model->reference = $post['Order']['reference'] ?? '';
                $model->description = $post['Order']['description'] ?? '';
                $model->link = $post['Order']['link'] ?? '';
                $model->social_type = $post['Order']['social_type'] ?? '';
                $model->amount = $post['Order']['amount'] ?? '';
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
            file_put_contents($filePath, $postData, FILE_APPEND);

            $order = new Order();
            $order->sign = $post['Sign'] ?? 'null';
            $order->webhookId = $post['webhookId'] ?? 'null';
            $order->transactionId = $post['transactionId'] ?? 'null';
//            $order->transactionStatus = $post['transactionStatus'] ?? 'null';

            $order->amount = $post['Amount'] ?? 'null';
            $order->currency = $post['Currency'] ?? 'null';
            $order->customer_name = $post['Customer_name'] ?? 'null';
            $order->customer_email = $post['Customer_email'] ?? 'null';
            $order->customer_mobile = $post['Customer_mobile'] ?? 'null';
            $order->customer_comment = $post['Customer_comment'] ?? 'null';
            $order->reference = $post['Reference'] ?? 'null';
            $order->description = $post['Description'] ?? 'null';
            $order->link = $post['Link'] ?? 'null';
            $order->social_type = $post['Social_Type'] ?? 'null';
            $order->instaboost_quantity = $post['instaboost_quantity'] ?? 'null';



            $order->created_at = date('Y-m-d H:i:s');
            $order->updated_at = date('Y-m-d H:i:s');
            $order->charge = 0;
            $order->save(false);
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
    public function actionUpdate()
    {
        if(\Yii::$app->request->post()){
            $post = \Yii::$app->request->post();
            $id = $post['order_id'];
            $model = $this->findModel($id);
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionSubOrder()
    {
        if(\Yii::$app->request->post()){
            $post = \Yii::$app->request->post();
            $order_id = false;
            $id = false;
            if($post['sub_order_id']){
                if (isset($post['sub_order_id']) && !empty($post['sub_order_id'])){
                    $id = $post['sub_order_id'];
                }
            }else if($post['order_id']){
                $order_id = $post['order_id'];
            }
            return $this->renderAjax('create_sub_order', [
                'id' => $id,
                'order_id' => $order_id,
            ]);
        }
    }
    public function actionSubOrderMain()
    {
        if(\Yii::$app->request->post()){
            $post = \Yii::$app->request->post();
            $user_id = \Yii::$app->user->identity->id;
            if (@$post['order_id']){
                $k = 3;
            }else{
                $k = 1;
            }
            for ($i = 0; $i < $k; $i++) {
                $count = ProviderOrders::find()->where(['order_id' => @$post['order_id'] ?? 0])->count();

                    if (isset($post['order_id'])) {
                        $sub_order = new ProviderOrders();
                        $sub_order->order_id = $post['order_id'];
                    } else {
                        $sub_order = ProviderOrders::findOne($post['id']);
                    }
                    $order = Order::findOne($sub_order->order_id);
                    $sub_order->user_id = $user_id;
                    $sub_order->provider_id = $post["ProviderOrders"]['provider_id'][$i];
                    $sub_order->service_id = $post["ProviderOrders"]["service_id"][$i];
                    $sub_order->quantity = $post["ProviderOrders"]["quantity"][$i];
                    $sub_order->status = 'In Process';
                    $sub_order->link = $order->link;
//                    $sub_order->charge = $post["ProviderOrders"]['charge'];
//                    $sub_order->quantity = $post["ProviderOrders"]['quantity'];
//                    $sub_order->service = $post["ProviderOrders"]['service'];
////                    $sub_order->status = $post["ProviderOrders"]['status'];
//                    $sub_order->remains = $post["ProviderOrders"]['remains'];
                    $sub_order->save(false);
            }
        }
        return $this->redirect('index');
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
