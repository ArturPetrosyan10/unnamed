<?php

namespace app\controllers;

require '../vendor/autoload.php';

use GuzzleHttp\Exception\RequestException;
use Yii;
use app\models\Order;
use app\models\OrderSearch;
use app\models\ProviderOrders;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ProviderCounts;

use GuzzleHttp\Client;

//use app\models\ApifyService;
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

    public function actionInsta(){
        //переменные
//        $url_parser="https://www.instagram.com/huyshavatser11/?__a=1&__d=1"; //ссылка для парсинга
        $url_parser="https://www.instagram.com/p/Cvxb_x9MS_L/?__a=1&__d=1"; //ссылка для парсинга
        $glubina_stranic="10"; //глубина парсинга, на одной странице 20 id пользователей
        $source = file_get_contents($url_parser);
        $source = json_decode($source);
        echo '<pre>';
        var_dump($source->graphql);//subscripes
//        var_dump($source->graphql->user->edge_followed_by->count);//subscripers ++

//        var_dump($source);
    }
    public function actionFb()
    {
    }
    public function actionFacebook()
    {
    }

    public function actionTiktok()
    {
        echo '<pre>';
        if(@$_GET['token'] === '26F0B118A6DA07343983894B586031EE') {
            $apiToken = 'apify_api_qcYOgdu2J9vcniWTvaYPHPQwX30z5g4zv8KD';
            $client = new Client([
                'base_uri' => 'https://api.apify.com/v2/',
                'verify' => false,
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                ],
            ]);
            $profiles = $_GET['link'];
            $maxPostsPerProfile = 1; // Maximum posts per profile



            if (strpos($profiles, '/video/') !== false) {
                $profiles = explode('/video/', $profiles);
                $url_status = 'post';
                $actorId = 'S5h7zRLfKFEr8pdj7';
            }else {
                $profiles = parse_url($profiles);
                $profiles = substr($profiles['path'], 1);
                $url_status = 'page';
                $actorId = '0FXVyOXXEmdGcV88a';
            }

            if ($url_status === 'post'){
                $payload = [
                    'input.profiles' => $profiles,
                    'waitForFinish' => $maxPostsPerProfile,
                ];

                $response = $client->post('acts/' . $actorId . '/runs', [
                    'json' => [
                        'postURLs' => [$profiles],
                        "shouldDownloadVideos" => false,
                        "shouldDownloadCovers" => false,
                        "shouldDownloadSlideshowImages" => false
                    ], 'query' => ['waitForFinish' => 60],
                ]);

                $parsedResponse = \json_decode($response->getBody(), true);
                $runId = $parsedResponse['data'];
            }
            else if ($url_status === 'page'){
                $payload = [
                    'input.profiles' => $profiles,
                    'waitForFinish' => $maxPostsPerProfile,
                ];

                $response = $client->post('acts/' . $actorId . '/runs', [
                    'json' => [
                        'profiles' => [$profiles],
                        'resultsPerPage' => 1,
                        "shouldDownloadVideos" => false,
                        "shouldDownloadCovers" => false,
                        "shouldDownloadSlideshowImages" => false,
                        'maxPostsPerProfile' => 1,
                        'results' => 1,
                    ], 'query' => ['waitForFinish' => 60],
                ]);

                $parsedResponse = \json_decode($response->getBody(), true);
                $runId = $parsedResponse['data'];
            }
            sleep(25);
            /** url with post */
            $runId["id"] = 'pYx49mLcfCKMAmmNZ';
            $response = $client->get('actor-runs/' . $runId["id"] . '/dataset/items');
            $parsedResponse = \json_decode($response->getBody(), true);
            $data = \json_decode($response->getBody(), true);
            var_dump($data[0]['authorMeta']['fans']);
            var_dump($data[0]['authorMeta']['heart']);
            var_dump($data[0]['authorMeta']['video']);
            if(@$_GET['order_id'] && $url_status === 'post'){
                $start_counts = new ProviderCounts();
                $start_counts->order_id = $_GET['order_id'];
                $start_counts->follows = $data[0]['authorMeta']["fans"];
                $start_counts->likes = $data[0]['authorMeta']["heart"];
                $start_counts->comments = $data[0]["commentCount"];
                $start_counts->played = $data[0]["playCount"];
                $start_counts->video_likes = $data[0]["diggCount"];
                $start_counts->app_type = 'TT';
                var_dump($start_counts->save());
            }else if (@$_GET['order_id'] && $url_status === 'page' ){
                $start_counts = new ProviderCounts();
                $start_counts->order_id = $_GET['order_id'];
                $start_counts->follows = $data[0]['authorMeta']["fans"];
                $start_counts->likes = $data[0]['authorMeta']['heart'];
                $start_counts->videos_count = $data[0]['authorMeta']['video'];
                $start_counts->app_type = 'TT';
                var_dump($start_counts->save());
            }
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
     * Lists all Order models.
     *
     * @return string
     * update and create
     */
    public function actionYoutube()
    {
        if(@$_GET['token'] === '26F0B118A6DA07343983894B586031EE') {
            $apiKey = 'AIzaSyC2WO-x1L9aW402NemNhdr2El4AEMsXYLI';
            $videoId = $_GET['link'];
            $videoId = parse_url($videoId);
            if (isset($videoId['query']) && !empty($videoId['query'])) {
                $url_status = 'post';
                $videoId = substr($videoId['query'], 2);
            } else {
                $url_status = 'page';
            }
            if ($url_status === 'post') {
                $videoApiUrl = "https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics&id={$videoId}&key={$apiKey}";
                $videoResponse = file_get_contents($videoApiUrl);
                $videoData = json_decode($videoResponse, true);

                if (isset($videoData['items'][0]['statistics'])) {
                    $statistics = $videoData['items'][0]['statistics'];
                    $views = $statistics['viewCount'];
                    $likes = $statistics['likeCount'];
                    $comments = $statistics['commentCount'];
                } else {
                    echo "Video not found or an error occurred.";
                    exit;
                }

                $channelId = $videoData['items'][0]['snippet']['channelId'];
                $channelApiUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id={$channelId}&key={$apiKey}";
                $channelResponse = file_get_contents($channelApiUrl);
                $channelData = json_decode($channelResponse, true);

                if (isset($channelData['items'][0]['snippet'])) {
                    $channelSnippet = $channelData['items'][0]['snippet'];
                    $channelTitle = $channelSnippet['title'];
                    $channelDescription = $channelSnippet['description'];
                    $subscriberCount = $channelData['items'][0]['statistics']['subscriberCount'];

                    $start_counts = new ProviderCounts();
                    $start_counts->order_id = $_GET['order_id'];
                    $start_counts->follows = $subscriberCount;
                    $start_counts->likes = 0;
                    $start_counts->comments = $comments;
                    $start_counts->played = $views;
                    $start_counts->video_likes = $likes;
                    $start_counts->app_type = 'Youtube';
                    var_dump($start_counts->save());
                } else {
                    echo "Channel data not found or an error occurred.";
                }
            }
            else if ($url_status === 'page') {
                if (isset($videoId['query'])) {
                    parse_str($videoId['query'], $query);
                    if (isset($query['v'])) {
                        $videoId = $query['v'];
                    } else {
                        echo "Invalid video link.";
                        exit;
                    }
                } elseif (isset($videoId['path'])) {
                    $pathParts = explode('/', $videoId['path']);
                    $channelName = end($pathParts);
                    $searchApiUrl = "https://www.googleapis.com/youtube/v3/search?q={$channelName}&type=channel&key={$apiKey}";
                    $searchResponse = file_get_contents($searchApiUrl);
                    $searchData = json_decode($searchResponse, true);
                    if (isset($searchData['items'][0]['id']['channelId'])) {
                        $channelId = $searchData['items'][0]['id']['channelId'];
                        $channelApiUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id={$channelId}&key={$apiKey}";
                        $channelResponse = file_get_contents($channelApiUrl);
                        $channelData = json_decode($channelResponse, true);
                        if (isset($channelData['items'][0]['snippet'])) {
                            $channelSnippet = $channelData['items'][0]['snippet'];
                            $subscriberCount = $channelData['items'][0]['statistics']['subscriberCount'];
                            $videoCount = $channelData['items'][0]['statistics']['videoCount'];

                            $start_counts = new ProviderCounts();
                            $start_counts->order_id = $_GET['order_id'];
                            $start_counts->follows = $subscriberCount;
                            $start_counts->videos_count = $videoCount;
                            $start_counts->app_type = 'Youtube';
                            var_dump($start_counts->save());
                        } else {
                            echo "Channel data not found or an error occurred.";
                        }
                    } else {
                        echo "Channel not found or an error occurred.";
                    }
                } else {
                    echo "Invalid link.";
                    exit;
                }
            }
        }
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
        if($_REQUEST && $_REQUEST['SECRET_KEY'] == '26F0B118A6DA07343983894B586031EE'){
            $post = $_REQUEST;
            $order = new Order();
            $order->sign = $post['Sign'] ?? 'null';
            $order->webhookId = $post['webhookId'] ?? 'null';
            $order->transactionId = $post['transactionId'] ?? 'null';
            $order->transactionStatus = $post['transactionStatus'] ?? 'null';
            $order->amount = $post['Amount'] ?? 'null';
            $order->currency = $post['Currency'] ?? 'null';
            $order->customer_name = $post['Customer_name'] ?? 'null';
            $order->customer_email = $post['Customer_email'] ?? 'null';
            $order->customer_mobile = $post['Customer_mobile'] ?? 'null';
            $order->customer_comment = $post['Customer_comment'] ?? 'null';
            $order->reference = $post['Reference'] ?? 'null';
            $order->link = $post['Link'][0] ?? 'null';
            $order->social_type = $post['Social_Type'] ?? 'null';
            $order->created_at = date('Y-m-d H:i:s');
            $order->updated_at = date('Y-m-d H:i:s');
            $order->charge = 0;
            if($order->save(false)){
                foreach ($post['Quantity'] as $key => $item) {
                    $prov_order = new ProviderOrders();
                    $prov_order->order_id = $order->id;
                    $prov_order->quantity = $item;
                    $prov_order->description = $post['Description'][$key];
                    $prov_order->status = 'In Progress';
                    if($prov_order->save(false)){
                        echo $prov_order->description.'-'.$prov_order->quantity.' successfully added';
                        echo '<br>';
                    }else{
                        echo 'ERROR: doesnt added';
                    }
                }
                $link = $post['Link'][$key] ?? 'null';
                $parse_link = parse_url($link);
                $parse_link = $parse_link['host'];

                switch ($parse_link){
                    case 'www.tiktok.com';
                        return $this->redirect(Url::to(['tiktok', 'link' => $link,'token' => '26F0B118A6DA07343983894B586031EE' ,'order_id'=> $order->id]));
                        break;
                    case 'www.youtube.com';
                        return $this->redirect(Url::to(['youtube', 'link' => $link,'token' => '26F0B118A6DA07343983894B586031EE' ,'order_id'=> $order->id]));
                        break;
                    case 'www.instagram.com';
                        return $this->redirect(Url::to(['insta', 'link' => $link,'token' => '26F0B118A6DA07343983894B586031EE' ,'order_id'=> $order->id]));
                        break;
                    case 'www.facebook.com';
                        echo 'not yet';
                        break;
                }
            }
        }else{
            echo 'Secret Key is not valid';
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
                $k = 3 - ProviderOrders::find()->where(['order_id'=>$post['order_id']])->count();
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
