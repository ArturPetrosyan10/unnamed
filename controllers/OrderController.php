<?php

namespace app\controllers;

require '../vendor/autoload.php';

use app\models\Api;
use app\models\BoostServices;
use app\models\Order;
use app\models\OrderLogs;
use app\models\ProviderOrdersSearch;
use app\models\Providers;
use app\models\Request;
use app\models\Services;
use app\models\Status;
use Exception;
use GuzzleHttp\Exception\RequestException;
use app\models\Tokens;
use Yii;
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
                'only' => ['categories','index','create','update','delete','View','sub-order','sub-order-main','api-order'], // Укажите здесь действия, которые хотите ограничить
                'rules' => [
                    [
                        'allow' => false,
//                        'actions' => ['index', 'create','ApiOrder'],
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

    public function actionInsta($data){
        $req = new Request();
        $req->req = json_encode($data);
        $req->ip = $_SERVER['REMOTE_ADDR'];
        $req->save(false);
        $token = Tokens::find()->where(['name'=>'get_order'])->one()->token;
        $_GET = $data;
        echo '<pre>';
        if(@$_GET['token'] === $token) {
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
            $profiles = parse_url($profiles);
//            var_dump(parse_url('https://instagram.com/etukabuchukuri__official'));
//            echo '<br>';
//            var_dump(parse_url('https://www.instagram.com/p/CguS7euIjRp/'));
//            echo '<br>';
//            var_dump(parse_url('https://www.instagram.com/reel/CwvTIIeo4rI/'));
//            echo '<br>';
//            var_dump(parse_url('https://instagram.com/ik.moz'));
//            echo '<br>';
//            var_dump(parse_url('instagram.com/mayrisabie'));
            $profiles = explode('/', trim($profiles['path'], '/'));
            if (count(parse_url($_GET['link'])) === 1){
                $profiles = $profiles[1];
                $url_status = 'page';
                $actorId = 'dSCLg0C3YEZ83HzYX';
            }
            elseif (count($profiles) == 2) {
                $profiles = $_GET['link'];
                $url_status = 'post';
                $actorId = 'shu8hvrXbJbY3Eb9W';
            }else {
                $profiles = $profiles[0];
                $url_status = 'page';
                $actorId = 'dSCLg0C3YEZ83HzYX';
            }

            if ($url_status === 'post'){
                $response = $client->post('acts/' . $actorId . '/runs', [
                    'json' => [
                        'directUrls' => [$profiles],
                        "shouldDownloadVideos" => false,
                        "shouldDownloadCovers" => false,
                        'maxPostsPerProfile' => 1,
                        'resultsPerPage' => 1,
                        'results' => 1,
                        "shouldDownloadSlideshowImages" => false
                    ], 'query' => ['waitForFinish' => 60],
                ]);

                $parsedResponse = \json_decode($response->getBody(), true);
                $runId = $parsedResponse['data'];
            }
            else if ($url_status === 'page'){
                $response = $client->post('acts/' . $actorId . '/runs', [
                    'json' => [
                        'usernames' => [$profiles],
                        'resultsPerPage' => 1,
                        "shouldDownloadVideos" => false,
                        "shouldDownloadCovers" => false,
                        "shouldDownloadSlideshowImages" => false,
                        'maxPostsPerProfile' => 1,
                        'results' => 1,
                    ], 'query' => ['waitForFinish' => 60],
                ]);

                $parsedResponse = \json_decode($response->getBody(), true);
                $runId = @$parsedResponse['data'];
            }
            sleep(20);
            /** url with post */
//            $runId["id"] = 'm2zhlG5Bk05hofBvB';
            $response = $client->get('actor-runs/' . $runId["id"] . '/dataset/items');
            $parsedResponse = \json_decode($response->getBody(), true);
            $data = \json_decode($response->getBody(), true);
            if(@$_GET['order_id'] && $url_status === 'post' && !empty($data)){
                $start_counts = new ProviderCounts();
                $start_counts->order_id = $_GET['order_id'];
//                $start_counts->follows = $data[0]['authorMeta']["fans"];
                $start_counts->likes = @$data[0]['likesCount'];
                $start_counts->comments = @$data[0]["commentsCount"];
                $start_counts->played = @$data[0]["playCount"];
                $start_counts->video_likes = @$data[0]["diggCount"];
                $start_counts->name = @$data[0]["ownerUsername"];
                $start_counts->app_type = 'IG';
                if($start_counts->save()){
                    $order = Order::findOne($_GET['order_id']);
                    $order->counts_checked = 'true';
                    $order->save();

                }
            }
            else if (@$_GET['order_id'] && $url_status === 'page' ){
                $start_counts = new ProviderCounts();
                $start_counts->order_id = $_GET['order_id'];
                $start_counts->follows = $data[0]['followersCount'];
                $start_counts->name = $data[0]['username'];
                $start_counts->app_type = 'TT';

                if($start_counts->save()){
                    $order = Order::findOne($_GET['order_id']);
                    $order->counts_checked = 'true';
                    $order->save();
                }
            }
        }
    }
    public function actionFacebook()
    {
        if(@$_SERVER['USER'] != 'apache') {
            $panel_url  = "https://panel.instaboost.ge/order/add-orders";
            $data_for_panel = '{
                "instaboost_sign":"465D5CF9C77B28AEFCD68E51F1ACE1F7",
                "instaboost_webhookId":"wFia3SrEPIQ2pNb",
                "instaboost_transactionId":"TC-TR_1DVbJYR",
                "instaboost_transactionStatus":"ONE_TIME_PAYMENT_STATUS_PAID",
                "instaboost_amount":"25.00",
                "instaboost_currency":"GEL",
                "instaboost_customer_name":"Tornike Ramishvili",
                "instaboost_customer_email":"tornikeramishvili94@gmail.com",
                "instaboost_customer_mobile":"1112745",
                "instaboost_customer_comment":" ",
                "instaboost_tildaOrderId":"2049268445",
                "instaboost_origName":"TG 700 პრემიუმ გამომწერი",
                "instaboost_soctype":"TG",
                "instaboost_quantity":[700],
                "instaboost_description":"ნახვა",
                "instaboost_link":"https://t.me/TFVPM1GEORGIA"
            }';
            $curl = curl_init($panel_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_for_panel);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: '.strlen($data_for_panel)
            ]);
            $result_panel = curl_exec($curl);
            curl_close($curl);
            if ($result_panel === 'SUCCESS'){
                echo $result_panel;
            }else{
                echo $result_panel;
            }
        }
    }

    public function actionTiktok($data)
    {
        //https://vm.tiktok.com/ZGJG7Syrc/
        //https://vt.tiktok.com/ZSLWFvo8U/
        //tiktok.com/@shakokirvalidze
        //www.tiktok.com/@leila.iosebidze
        //https://www.tiktok.com/@leila.iosebidze?_t=8f2iZwlkg9h&_r=1
        //http://www.tiktok.com/@makaku_57

        $req = new Request();
        $req->req = json_encode($data);
        $req->ip = $_SERVER['REMOTE_ADDR'];
        $req->save(false);
        $token = Tokens::find()->where(['name'=>'get_order'])->one()->token;
        if(@$data['token'] === $token) {
            $apiToken = 'apify_api_qcYOgdu2J9vcniWTvaYPHPQwX30z5g4zv8KD';
            $client = new Client([
                'base_uri' => 'https://api.apify.com/v2/',
                'verify' => false,
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                ],
            ]);
            $profiles = $data['link'];
            $maxPostsPerProfile = 1; // Maximum posts per profile
            if (strpos($profiles, '/video/') !== false || strpos($profiles, '/t/') || str_contains($profiles,'vt.tiktok.com') || str_contains($profiles,'vm.tiktok.com')) {
                $url_status = 'post';
                $actorId = 'S5h7zRLfKFEr8pdj7';
            }else {
                $profiles = parse_url($profiles);
                if(!isset($profiles['scheme']) && !isset($profiles['host'])){
                    $profiles = $data['link'];
                    $profiles = explode('/', $data['link']);
                    $profiles = end($profiles);
                }else{
                    $profiles = substr($profiles['path'], 1);
                }
                $url_status = 'page';
                $actorId = '0FXVyOXXEmdGcV88a';
            }
            echo '<pre>';
//            var_dump($url_status);
//            var_dump($profiles);
//            die;
            if ($url_status === 'post'){
                $a = 1;
                $response = $client->post('acts/' . $actorId . '/runs', [
                    'json' => [
                        'postURLs' => [$profiles],
                        "shouldDownloadVideos" => false,
                        "shouldDownloadCovers" => false,
                        "shouldDownloadSlideshowImages" => false,
                        ],
                    'query' => ['waitForFinish' => 120],
                ]);
                $parsedResponse = \json_decode($response->getBody(), true);
                $runId = $parsedResponse['data'];
            }
            else if ($url_status === 'page'){
                $response = $client->post('acts/' . $actorId . '/runs', [
                    'json' => [
                        'profiles' => [$profiles],
                        'resultsPerPage' => 1,
                        "shouldDownloadVideos" => false,
                        "shouldDownloadCovers" => false,
                        "shouldDownloadSlideshowImages" => false,
                        'maxPostsPerProfile' => 1,
                        'results' => 1,
                    ], 'query' => ['waitForFinish' => 120],
                ]);

                $parsedResponse = \json_decode($response->getBody(), true);
                $runId = $parsedResponse['data'];
            }
            sleep(15);
            /** url with post */
//            $runId["id"] = 'PIog18qz7sZTGyL5h';
            $response = $client->get('actor-runs/' . $runId["id"] . '/dataset/items');
            $parsedResponse = \json_decode($response->getBody(), true);
            $query = \json_decode($response->getBody(), true);
            if(@$data['order_id'] && $url_status === 'post'){
                $start_counts = new ProviderCounts();
                $start_counts->order_id = $data['order_id'];
                $start_counts->comments = $query[0]["commentCount"];
                $start_counts->played = $query[0]["playCount"];
                $start_counts->video_likes = $query[0]["diggCount"];
                $start_counts->post_share = $query[0]['shareCount'];
                $start_counts->shareCount = $query[0]["shareCount"];
                $start_counts->name = $query[0]['authorMeta']['name'];
                $start_counts->app_type = 'TT';
                if($start_counts->save()){
                    $order = Order::findOne($data['order_id']);
                    $order->counts_checked = 'true';
                    $order->save();
                }
            }else if (@$data['order_id'] && $url_status === 'page' ){
                $start_counts = new ProviderCounts();
                $start_counts->order_id = $data['order_id'];
                $start_counts->follows = $query[0]['authorMeta']["fans"];
                $start_counts->likes = $query[0]['authorMeta']['heart'];
                $start_counts->videos_count = $query[0]['authorMeta']['video'];
                $start_counts->name = $query[0]["authorMeta"]['name'];
                $start_counts->app_type = 'TT';
                if($start_counts->save()){
                    $order = Order::findOne($data['order_id']);
                    $order->counts_checked = 'true';
                    $order->save();
                }
            }
        }
    }

    public function actionApiBalance(){
        $provs = Providers::find()
                    ->all();
        foreach ($provs as $prov) {
            $api = new Api();
            $api->api_url= $prov->name;
            $api->api_key= $prov->api_key;

            $balanceResponse = $api->balance(); // Call the balance method
            $prov->balance = $balanceResponse->balance;
            $prov->updated_at = date('Y-m-d H:i:s');
            $prov->save();
        }
    }
    public function actionTest(){
//        $updatedRows = ProviderOrders::updateAll(['service_id' => 33],  ['>', 'id',10000 ]);
        $searchModel = new ProviderOrdersSearch();
        /**  the order of query is important */
        $query = $searchModel->prov_search($this->request->queryParams);
        $count = $query['count'];
        $query = $query['query'];

        $model = new ProviderOrders();

        $services = $model->getServices();
        $page = $_GET['paging'] ?? 1;
        return $this->render('test', [
            'model' => $model,
            'searchModel' => $searchModel,
            'query' => $query,
            'page'=>$page,
            'services'=>$services,
            'count'=>$count,

        ]);
    }

    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $user_id = \Yii::$app->user->identity->id;
        $model = new Order();
        $order_log = new OrderLogs();
        $order_log->user_id = $user_id;
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($this->request->post('id')) {
                $model = Order::findOne([$this->request->post('id')]);
                $model->updated_at = date('Y-m-d H:i:s');
                $order_log->from_link = @$model->link;
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
                $order_log->to_link = @$model->link;
                $model->save();
                $order_log->order_id = @$model->id;
                $order_log->save();
                return $this->redirect('index');
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
     * add start counts telegram
     */
    public function actionTelegram($data = null){
        $token = Tokens::find()->where(['name'=>'get_order'])->one()->token;
        $botToken = Tokens::find()->where(['name'=>'TG'])->one()->token;
        if(@$data['token'] === $token) {
            $link = parse_url(@$data['link']);
            $link['path'] = trim($link['path'], '/');
            if ($link['path'][0] !== '+' || $link['path'][0] !== '-') {
                $link = '@' . $link['path'];
                $channelUsername = $link;
            } else {
                $channelUsername = '';
            }
            $action = 'getChatMembersCount';
            $url = "https://api.telegram.org/bot{$botToken}/{$action}?chat_id={$channelUsername}";
            $response = file_get_contents($url);
            $query = json_decode($response, true);
            if (@$data['order_id'] && @$query) {
                $start_counts = new ProviderCounts();
                $start_counts->order_id = $data['order_id'];
                $start_counts->follows = $query["result"];
                $start_counts->app_type = 'TG';
                if ($start_counts->save()) {
                    $order = Order::findOne($data['order_id']);
                    $order->counts_checked = 'true';
                    $order->save();
                }
            }
        }
    }
    public function actionYoutube($data)
    {
        $req = new Request();
        $req->req = json_encode($data);
        $req->ip = $_SERVER['REMOTE_ADDR'];
        $req->save(false);
        echo '<pre>';
        $_GET = $data;
        $token = Tokens::find()->where(['name'=>'get_order'])->one()->token;
        var_dump($token);
//        var_dump(parse_url('https://www.youtube.com/shorts/fWh_7xHXg-8'));
//        var_dump(parse_url('https://youtu.be/cltg8PAgc7A'));
//        var_dump(parse_url('https://youtube.com/@youtubery_elo835?si=14kVyoZOI3SRAnp2'));
//        var_dump(parse_url('https://youtu.be/9gw8jKXJHlg?feature=shared'));
//        echo '<pre>';
//        var_dump($_GET['link']);
//        var_dump(parse_url($_GET['link']));
        if(@$_GET['token'] === $token) {
            $apiKey = Tokens::find()->where(['name'=>'youtube_api'])->one()->token;
            $videoId = $_GET['link'];
            $videoId = parse_url($videoId);
            if (isset($videoId['query']) && !empty($videoId['query']) && (!str_contains($videoId['path'], '/@' ) )) {
                if (!str_contains($videoId['path'],'/watch')){
                    $videoId = substr($videoId['path'], 1);
                } else{
                    $videoId = substr($videoId['query'], 2);
                }
                $url_status = 'post';
            }
            elseif (!str_contains($videoId['path'], '/@' ) ){
                if (str_contains($videoId['path'], '/shorts/' )){
                    $videoId = substr($videoId['path'], 8);
                }else{
                    $videoId = substr($videoId['path'], 1);
                }
                $url_status = 'post';
            }
            else {
                $url_status = 'page';
            }
            if ($url_status === 'post') {
                $videoApiUrl = "https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics&id={$videoId}&key={$apiKey}";
                $videoResponse = file_get_contents($videoApiUrl);
                $videoData = json_decode($videoResponse, true);
                if (isset($videoData['items'][0]['statistics'])) {
                    $statistics = $videoData['items'][0]['statistics'];
                    $views = @$statistics['viewCount'];
                    $likes = @$statistics['likeCount'];
                    $comments = @$statistics['commentCount'];
                } else {
                    echo "Video not found or an error occurred.";
                    exit;
                }
                $channelId = @$videoData['items'][0]['snippet']['channelId'];
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
                    $start_counts->app_type = 'YT';
                    $start_counts->name = $channelData['items']['0']['snippet']['customUrl'];
                    if($start_counts->save()){
                        $order = Order::findOne($_GET['order_id']);
                        $order->counts_checked = 'true';
                        $order->save();

                    }
                } else {
                    echo "Channel data not found or an error occurred.";
                }
            }
            else if ($url_status === 'page') {
//                if (isset($videoId['query'])) {
//                    parse_str($videoId['query'], $query);
//                    if (isset($query['v'])) {
//                        $videoId = $query['v'];
//                    } else {
//                        echo "Invalid video link.";
//                        exit;
//                    }
//                } else
                if (isset($videoId['path'])) {
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
                            $start_counts->app_type = 'YT';
                            if($start_counts->save()){
                                $order = Order::findOne($_GET['order_id']);
                                $order->counts_checked = 'true';
                                $order->save();

                            }
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
        $token = Tokens::find()->where(['name'=>'get_order'])->one()->token;
        $check_token = new Tokens();
        $filePath = '../views/order/request-v2';
        $r = json_decode(file_get_contents("php://input"));
        $post = (array) $r;
        $post['IP'] = $_SERVER['REMOTE_ADDR'];
        $post['date_time'] = date('Y-m-d H:i:s');
        $content = print_r($post, true);
        file_put_contents($filePath, $content, FILE_APPEND);

        if($post && $check_token->check_key($post,$token)){
            if(@Order::findOne(['sign' => $post['instaboost_sign']])->id){
                echo 'SUCCESS';
                die;
            }
            $main_link = @$post['instaboost_link'];
            if (isset($post['instaboost_link']) && !empty($post['instaboost_link'])){
                if(str_contains($post['instaboost_link'],'?')){
                    $post['instaboost_link'] = substr($post['instaboost_link'], 0, strpos($post['instaboost_link'], "?"));
                }
            }
            $order = new Order();
            $order->sign = $post['instaboost_sign'] ?? ' ';
            $order->webhookId = $post['instaboost_webhookId'] ?? ' ';
            $order->transactionId = $post['instaboost_transactionId'] ?? ' ';
            $order->transactionStatus = $post['instaboost_transactionStatus'] ?? ' ';
            $order->amount = $post['instaboost_amount'] ?? ' ';
            $order->currency = $post['instaboost_currency'] ?? ' ';
            $order->customer_name = $post['instaboost_customer_name'] ?? ' ';
            $order->customer_email = $post['instaboost_customer_email'] ?? ' ';
            $order->customer_mobile = $post['instaboost_customer_mobile'] ?? ' ';
            $order->customer_comment = $post['instaboost_customer_comment'] ?? ' ';
            $order->tilda_id = $post['instaboost_tildaOrderId'] ?? ' ';
            $order->origName = $post['instaboost_origName'] ?? ' ';
            $order->reference = $post['Reference'] ?? ' ';
            $order->link = $main_link ?? ' ';
            $order->social_type = $post['instaboost_soctype'] ?? ' ';
            $order->created_at = date('Y-m-d H:i:s');
            $order->updated_at = date('Y-m-d H:i:s');
            $order->charge = 0;
            if($order->save(false)){
                if(@$post['instaboost_quantity']) {
                    foreach (@$post['instaboost_quantity'] as $key => $item) {
                        $prov_order = new ProviderOrders();
                        $prov_order->order_id = $order->id;
                        $prov_order->quantity = $item;
                        $prov_order->description = $post['instaboost_description'];
                        $prov_order->link = $order->link;
                        $prov_order->customer_comment = $order->customer_comment;
                        $prov_order->customer_mobile = $order->customer_mobile;
                        $prov_order->save(false);
                    }
                }
                echo 'SUCCESS';
                $link = $post['instaboost_link'] ?? 'null';
                $parse_link = parse_url($link);
                $parse_link = $parse_link['host'] ?? $parse_link['path'];
                if(str_contains($link,'tiktok.com/@')){
                    $parse_link = 'tiktok.com';
                }
                switch (trim($order->social_type)){
                    case 'TT';
                        $this->actionTiktok([
                            'link' => $link,
                            'token' => $token,
                            'order_id' => $order->id,
                        ] );
                        break;
                    case 'YT';
                        $this->actionYoutube([
                            'link' => @$main_link,
                            'token' => $token,
                            'order_id' => $order->id,
                        ]);
                        break;
                    case 'IG';
                        $this->actionInsta([
                            'link' => $link,
                            'token' => $token,
                            'order_id' => $order->id,
                        ]);
                    break;
                    case 'TG';
                        $this->actionTelegram([
                            'link' => $link,
                            'token' => $token,
                            'order_id' => $order->id,
                        ]);
                        break;
                    default;
                        echo '<h1 style="color:red">the link is wrong</h1>';
//                        Order::deleteAll(['id' => $order->id]);
//                        ProviderOrders::deleteAll(['order_id' => $order->id]);
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
        $user_id = \Yii::$app->user->identity->id;
        $order_log = new OrderLogs();
        $order_log->user_id = \Yii::$app->user->identity->id;
        if(\Yii::$app->request->post()){
            $post = \Yii::$app->request->post();
            $count = ProviderOrders::find()->where(['order_id' => @$post['order_id'] ?? 0])->count();
            if (isset($post['order_id'])) {
                $sub_order = new ProviderOrders();
                $sub_order->order_id = $post['order_id'];
            } else {
                $sub_order = ProviderOrders::findOne($post['id']);
                $order_log->from_link = @$sub_order->link;
                $order_log->from_quantity = @$sub_order->quantity;
                $order_log->from_service = @$sub_order->service_id;
            }
            $order = Order::findOne($sub_order->order_id);
            $sub_order->user_id = $user_id;
            $sub_order->service_id = $post["ProviderOrders"]["service_id"][0];
            $sub_order->quantity = $post["ProviderOrders"]["quantity"][0];
            $sub_order->status = $sub_order->status ?? '';
            $sub_order->link = $order->link;
            $sub_order->save(false);
            $order_log->to_link = @$sub_order->link;
            $order_log->to_quantity = @$sub_order->quantity;
            $order_log->to_service = @$sub_order->service_id;
            $order_log->prov_order_id = $sub_order->id;
            $order_log->save();
            if(isset($post['to_order'])){
                $url = Url::to(['api-order','id'=>$sub_order->id], true);
                return $this->redirect($url);
            }
            elseif (isset($post['to_refill'])){
                $url = Url::to(['api-refill','id'=>$sub_order->id], true);
                return $this->redirect($url);
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
        ProviderOrders::deleteAll(['order_id'=> $id]);
        return $this->redirect(['index']);
    }

    public function actionGetSubOrders() {
        if(\Yii::$app->request->get()){
            $get = \Yii::$app->request->get();
            $sub_orders = ProviderOrders::find()->where(['order_id' => $get['id']])->all();
//            var_dump($sub_orders);
            return $this->renderAjax('sub-orders', ['sub_orders' => $sub_orders]);
        }
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
    public function actionApi()
    {
        $provs = Providers::find()
            ->asArray()->all();
        $api = new Api();
        foreach ($provs as $prov) {
            $i = 0;
            $api->api_url= $prov['name'];
            $api->api_key= $prov['api_key'];
            $services = $api->services();
            $check_old = BoostServices::find()
                ->select('service_id')
                ->where(['services_from' => $prov['name']])
                ->asArray()
                ->all();
            $check_old = array_column($check_old,'service_id');
            foreach ($services as $service) {
                if(!in_array($service->service,$check_old)){
                    $new_services = new BoostServices;
                    $new_services->service_id = intval($service->service);
                    $new_services->name = $service->name;
                    $new_services->type = $service->type;
                    $new_services->rate = $service->rate;
                    $new_services->min = $service->min;
                    $new_services->max = $service->max;
                    if (isset($service->dripfeed)){
                        $new_services->dripfeed = $service->dripfeed ? 'true' : 'false';
                    }else{
                        $new_services->dripfeed = '';
                    }
                    $new_services->refill = intval($service->refill);
                    $new_services->cancel = $service->cancel ? 'true' : 'false';
                    $new_services->category = $service->category;
                    $new_services->subscription = $service->subscription ?? '';
                    $new_services->description = $service->description ?? '';
                    $new_services->services_from = $api->api_url ?? '';
                    if($new_services->save(false) == false){
                        var_dump($new_services->getErrors());
                    }else{
                        $i++;
                    }
                }
            }
            echo 'createt ' . $i . ' from ' .count($services);
        }
        die;
    }

//    public function actionTest(){
        //[make] ,[where]
//        $updatedRows = ProviderOrders::updateAll(['status' => NULL],  ['!=', 'order_id',1115 ]);
//    }
    public function actionStatuss(){
        $all_provs = Status::find()
            ->select('status.id,prov_order_id,back_order_id,service_id,providers.api_key,providers.name,providers.id as prov_id')
            ->where(['in','status.id',array_column(Status::find()
                ->select(['MAX(id) AS id'])
                ->groupBy('prov_order_id')
                ->asArray()
                ->all(),'id')])
            ->andWhere(['!=','status','Completed'])
//            ->andWhere(['!=','status','Pending'])
            ->andWhere(['!=','status','Canceled'])
            ->leftJoin('services','status.service_id = services.id')
            ->leftJoin('providers','providers.id = status.provider_id')
            ->asArray()
            ->all();
        $StatusResponse = [];
        $i = 0;
        foreach ($all_provs as $index => $all_prov) {
            $api = new Api();
            $api->api_key = $all_prov['api_key'];
            $api->api_url = $all_prov['name'];

            $StatusResponse[] = $api->status($all_prov['back_order_id']);
            if ($StatusResponse[$i]){
                $status = new Status();
                $status->prov_order_id = $all_prov['prov_order_id'];
                $status->back_order_id = $all_prov['back_order_id'];
                $status->status = $StatusResponse[$i]->status;
                $status->remains = $StatusResponse[$i]->status;
                $status->currency = $StatusResponse[$i]->currency;
                $status->updated_at = date('y-m-d H:i:s');
                $status->start_count = $StatusResponse[$i]->start_count;
                $status->charge = $StatusResponse[$i++]->charge;
                $status->provider_id = $all_prov['prov_order_id'];
                $status->service_id = $all_prov['service_id'];
                $status->save();
            }
            $provider_order = ProviderOrders::findOne($all_prov['prov_order_id']);
            $provider_order->status = $status->status;
            $provider_order->save();
        }
    }
    public function actionApiStatus($id){
        $api = new Api();
        $provider_order = ProviderOrders::find()->where(['id' => $id])->asArray()->one();
        $get_order_id = Status::findOne(['prov_order_id' => $id])->back_order_id;

        $api->api_url = Providers::findOne($provider_order['provider_id'])->name;
        $api->api_key = Providers::findOne($provider_order['provider_id'])->api_key;

        $StatusResponse = $api->status($get_order_id);
        echo '<pre>';
        var_dump($id);
        var_dump($get_order_id);
        var_dump($api->api_url);
        var_dump($api->api_key);
        var_dump($StatusResponse);
        $status = new Status();
        $status->prov_order_id = $id;
        $status->back_order_id = $get_order_id;
        $status->status = $StatusResponse->status;
        $status->remains = $StatusResponse->status;
        $status->currency = $StatusResponse->currency;
        $status->updated_at = date('y-m-d H:i:s');
        $status->start_count = $StatusResponse->start_count;
        $status->charge = $StatusResponse->charge;
        $status->provider_id = $provider_order['provider_id'];
        $status->service_id = $provider_order['service_id'];
        $status->save();
        $provider_order = ProviderOrders::findOne($id);
        $provider_order->status = $status->status;
        $provider_order->save();
        die;

        var_dump($api);
        var_dump($provider_order);
    }
    /**
        int $id sub_order_id
     */
    public function actionApiOrder($id)
    {
        $api = new Api(); // Create an instance of the Api model
        $provider_order = ProviderOrders::find()->where(['id' => $id])->asArray()->one();
        $b_service = Services::findOne($provider_order['service_id'])->def_boost_service;
        $api->api_url = Providers::findOne($provider_order['provider_id'])->name;
        $api->api_key = Providers::findOne($provider_order['provider_id'])->api_key;

        $orderData = [
            'api_key' => $api->api_key,
            'action' => 'add',
            'service' => $b_service,
            'link' => $provider_order['link'],
            'quantity' => $provider_order['quantity']*1.05,
            'runs'=>''
        ];

        $orderResponse = $api->order($orderData); // Call the order method
        var_dump($orderResponse);
        $status = new Status();
        $status->prov_order_id = $id;
        $status->provider_id = $provider_order['provider_id'];
        $status->service_id = $provider_order['service_id'];
        $status->back_order_id = $orderResponse->order;
        $status->created_at = date('y-m-d H:i:s');
        var_dump($status->save());
        return $this->redirect('index');
    }
    public function actionSendOrder(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if(isset($post['auto_likes'])){
                $post['service'] = $post['autolike']['service_id'];
                $min_max = explode('-', $post['like']['min-max']);
                $min = $min_max[0];
                $max = $min_max[1];
                $service = $post['service'];
                $old_posts = $post['existing'];
                $posts = $post['future'];

                $username = (new ProviderOrders)->getUsername($post['prov_order_id']);
            }
            elseif(isset($post['auto_views'])){
                $post['service'] = $post['autoView']['service_id'];
                $min_max = explode('-', $post['view']['min-max']);
                $min = $min_max[0];
                $max = $min_max[1];
                $service = $post['service'];
                $old_posts = $post['existing'];
                $posts = $post['future'];
                $username = (new ProviderOrders)->getUsername($post['prov_order_id']);
            }
            echo '<pre>';
            var_dump($username);
            die;
            $delay = 0;
            $boost_service = Services::find()
                ->select('def_boost_service , def_provider, providers.name, providers.api_key')
                ->where(['services.id' => $post['service']])
                ->leftJoin('providers','services.def_provider = providers.id')
                ->asArray()
                ->one();

            $api = new Api();
            $api->api_key = $boost_service['api_key'];
            $api->api_url = $boost_service['name'];
            $b_service = $boost_service['def_boost_service'];
            echo '<pre>';
            var_dump($min);
            var_dump($max);
            var_dump($api->api_key);
            var_dump($api->api_url);
            var_dump($b_service);
            die;
            $id = $post['prov_order_id'];
            echo '<pre>';
            var_dump($post);
            die;
            foreach ($post['quantity'] as $index => $item) {
                $orderData = [
                    'api_key' => $api->api_key,
                    'action' => 'add',
                    'service' => $b_service,
                    'link' => $post['link'][$index],
                    'quantity' => $item,
                    'runs'=>''
                ];
//                $orderResponse = $api->order($orderData); // Call the order method
//                var_dump($orderResponse);
                $status = new Status();
                $status->prov_order_id = $id;
                $status->provider_id = $boost_service['def_provider'];
                $status->service_id = $boost_service['def_boost_service'];
                @$status->back_order_id = @$orderResponse->order;
                $status->created_at = date('y-m-d H:i:s');
//                var_dump($status->save());
                var_dump($orderData);
            }
            die;
            return $this->redirect('index');
        }
        echo '<pre>';
        var_dump($post);
        var_dump($orderData);
        die;
    }
    public function actionApiRefill($id)
    {
        $api = new Api(); // Create an instance of the Api model
        $provider_order = ProviderOrders::find()->where(['id' => $id])->asArray()->one();

        $back_order_id = Status::findOne(['prov_order_id' => $provider_order['id']])->back_order_id;
        $api->api_url = Providers::findOne($provider_order['provider_id'])->name;
        $api->api_key = Providers::findOne($provider_order['provider_id'])->api_key;

        $orderResponse = $api->refill($back_order_id); // Call the order method
        echo '<pre>';
        var_dump($back_order_id);
        var_dump($orderResponse);
        die;

        $status = new Status();
        $status->prov_order_id = $id;
        $status->provider_id = $provider_order['provider_id'];
        $status->service_id = $provider_order['service_id'];
//        $status->back_order_id = $orderResponse->order;
        $status->created_at = date('y-m-d H:i:s');
        $status->refill = @$orderResponse->refill;
        var_dump($status->save());
        return $this->redirect('index');
    }
}
