<?php

use app\models\Order;
use app\models\ProviderOrders;
use app\models\Services;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

//$this->title = 'Orders';
//$this->params['breadcrumbs'][] = $this->title;
// #4884f4 blue collor

?>
<style>
    .pagination .page-item.disabled .page-link {
        pointer-events: none; /* Disable click events on disabled links */
        cursor: default; /* Show default cursor on disabled links */
        color: #868e96; /* Set text color for disabled links */
    }
    /*table tr td:last-child,th:last-child {*/
    /*    border: 1px solid #dee2e6;*/
    /*    min-width: 100px;*/
    /*    padding: 0.5rem 0.5rem !important;*/
    /*}*/
    /*.unchecked td{*/
    /*    background:#f8d7da !important;*/
    /*}*/
    /*.text-success td{*/
    /*    background: #28a745!important;*/
    /*}*/
    .new_btn{
        background:#e8f4fc !important;
        color:#6c757d;
        border:none;
    }
    .choosen_btn{
        background:#4884f4 !important;
        color:white;
    }
    .u_footer .choosen_btn{
        background:#4884f4 !important;
        color:white;
    }
    .fab{
        color:#4884f4;
        font-size:20px;
    }


    /*.parent{*/
    /*    padding-left:0px !important;*/
    /*    padding-right: 0px !important ;*/
    /*}*/
    .border-right {
        border-right: 2px solid #c3c8c9!important;
        padding-right: 8px;
    }
    .u_name{
        font-weight: 700;
        color:rgba(101, 101, 101, 1);
    }
    .u_price{
        font-weight: 700;
        font-size:24px;
        color: rgba(101, 101, 101, 1);
    }
    .p-left-8{
        padding-left: 8px;
    }
    .m-t-10{
        margin-top: 10px;
    }
    .m-t-30{
        margin-top: 30px;
    }
    .border{
        border:1px solid rgba(203, 203, 203, 1)!important;
        border-radius:10px !important;
    }
    .paperclip {
        background-color:rgba(241, 241, 241, 1);
        background-repeat:no-repeat;
        width:46px;
        height:46px;
        border-radius: 14px !important;
    }
    .paperclip img{
        padding: 10px;
    }
    .input-group-text{
        min-height: 46px;
        background: rgba(241, 241, 241, 1);
        border-radius:7px;
        width:290px;
    }
    .parent{
        max-width:324px;
        min-height:320px;
        height:auto;
    }
    .u_footer button{
        border-radius:10px;
        padding:11px 30px;
        background:rgba(226, 226, 226, 1);
        color:rgba(101, 101, 101, 1);
        font-weight: 700;
        font-size: 16px;
        border:none;
    }
    .one_order form span{
        font-weight:700;
        font-size:14px;
        line-height:16.1px;
        color:rgba(101, 101, 101, 1)
    }
    .one_order{
        height: auto;
        background: white;
        /*max-width: 360px;*/
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius:30px 30px 0px 0px;
    }
    .one_order .form-control:disabled,.one_order .form-control[readonly] {
        background-color: white;
        opacity: 1;
    }
    .form-control{
        padding:0px !important;

    }
    .form{
        max-width:95%;
    }
    .swipe{
        width :70px;
        height :5px;
        border-radius :10px;
        background:rgba(226, 226, 226, 1);
        margin:10px 0 20px;
    }
    .orders_list{
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }

    .ftco-section .container{
        max-width:100%;
    }

    .container-fluid{
        padding:0;
        background:#4884f4 !important;
    }
    .calendar {
        margin: auto;
        font-weight: 400;
        display: flex;
        flex-direction: column;
    }
    .calendar_content, .calendar_weekdays{
        display:flex;
    }

    .calendar_content div {
        min-width:50px;
        max-width:50px;
        background: rgba(66, 134, 245, 1);
        padding:1px 0 14px 0;
    }
    .calendar_weekdays div {
        min-width:50px;
        max-width:50px;
        background: rgba(66, 134, 245, 1);
        padding:2px 0 10px 0;
    }
    .calendar, .calendar_weekdays, .calendar_content {
        max-width: 100%;
        background:none;
        margin  : auto;
    }
    .week_today{
        background: rgba(103, 161, 255, 1) !important;
        color: black !important;
        border-radius: 20px 20px 0px 0px !important;
    }
    .today{
        background: rgba(103, 161, 255, 1) !important;
        color: black !important;
        border-radius: 0px 0px 20px 20px;
    }
    /*.calendar_content, .calendar_weekdays, .calendar_header {*/
        /*position: relative;*/
        /*overflow: unset !important;*/
    /*}*/

    .calendar_weekdays div{
        position:relative;
    }
    .modal-body label{
        font-weight: 700;
        font-size: 24px;
        line-height :27.6px;
        color:rgba(101, 101, 101, 1);
        padding-top:20px;
        text-align:center;
        min-width:300px;
    }
    .modal-body .choosen_btn{
        max-width:300px;
        width:75%;
        padding:14px 30px 14px 30px;
    }
    .modal-content{
        border-radius:20px;
    }
    .modal{
        display: flex !important;
        justify-content: center;
        align-items: center;
    }
    .multyple_forms label{
        font-weight:400;
        font-size:12px;
        color:rgba(101, 101, 101, 1);
    }

    .functional-buttons button{
        width:46px;
        height:46px;
        border-radius:10px;
        background: rgba(226, 241, 255, 1) !important;
        color:rgba(66, 134, 245, 1) !important;
        border:none;
        font-size:20px;
    }
    .long_text{
        text-overflow: ellipsis;
        display: block !important;
        /*white-space: nowrap;*/
        overflow: hidden;
        max-width:99%;
    }
    .parent w-75{
        height:auto;
    }
    .parent .w-75 label{
        max-width: 220px;
        height:auto;
    }
    .padding-around-10{
        padding:0px 6px;
    }
    .min-width-300 {
        min-width: 300px !important;
    }
    .max-width-300 {
        min-width: 300px !important;
    }
    .min-width-250{
        min-width: 250px !important;
    }
    .max-width-250{
        min-width: 250px !important;
    }
    .min-width-150 {
        min-width: 150px !important;
    }
    .max-width-150 {
        min-width: 150px !important;
    }
    .min-width-100 {
        min-width: 100px !important;
    }
    .max-width-100 {
        min-width: 100px !important;
    }
    .min-width-50 {
        min-width: 50px !important;
    }
    .max-width-50 {
        min-width: 50px !important;
    }
    .text-align-center{
        text-align:center;
    }
    .unique-input-1{
        background: rgba(48, 107, 204, 1);
        color: white;
        border:none;
        width:100%;
        margin:auto;
    }
    .unique-input-1 ::placeholder{ /* Chrome, Firefox, Opera, Safari 10.1+ */
        color:white;
    }
    .unique-input-1 ::-ms-input-placeholder { /* Microsoft Edge */
        color:white;
    }

    .unique-form-1{
        width:100%;
        background:rgba(48, 107, 204, 1);
    }
    input[type="checkbox"]{
        width :18px;
        height :18px;
        border-radius:5px;
    }
    form input{
        padding:0px;
    }
    .counts_views label{
        padding: 9px !important;
    }
    @media screen and (max-width: 767px) {
        .container-fluid{
            width:100% !important;
        }
        .one_order{
            margin:auto;
        }
        .nav-item{
            display:none;
        }
        .pagination{
            display:none;
        }
    }
    @media screen and (min-width: 766px) {
        .view-more-orders{
            display:none;
        }
    }

</style>
<!--<i class="fab  fa-instagram"></i>-->
<!--<i class="fab  fa-facebook"></i>-->
<!--<i class="fab  fa-telegram"></i>-->
<!--<i class="fab far  fa-envelope"></i>-->
<!--<i class="fab fas  fa-phone"></i>-->
<!--<i class="fab fas fa-exclamation-circle"></i>-->
<!--<i class="fab far fa-comment-alt"></i>-->
<!--<i class="fab fas fa-paperclip"></i>-->
<!--<img src="--><?php //= '/img/Link.png' ?><!--">-->
<!--<img src="--><?php //= '/img/Chat.png' ?><!--">-->
<!--<img src="--><?php //= '/img/Group 225.png' ?><!--">-->
<!--<img src="--><?php //= '/img/Comment Unread.png' ?><!--">-->
<!--<i class="bi bi-trash"></i>-->
<!---->
<!--<i class="fab fas fa-trash"></i>-->
<!-- Email Envelope Icon -->
<!--<i class="fas fa-envelope"></i>-->
<!---->
<!-- Send Icon -->
<!--<i class="fas fa-paper-plane"></i>-->
<!---->
<!-- Receive Icon -->
<!--<i class="fas fa-inbox"></i>-->

<div class="dashboard">
    <?= \Yii::$app->view->renderFile('@app/views/order/calendar.php'); ?>
    <form action="/order/test" method="get" class="d-flex align-items-center justify-content-evenly w-100 unique-form-1">
        <div class="w-100">
            <input type="text" class="form-control unique-input-1" name="sorting[about]" placeholder="Search...">
        </div>
        <div style="width:5%; padding:7px 0; background:rgba(48, 107, 204, 1);">
            <img src="/img/Group 201.png">
        </div>
    </form>
</div>
<div class="order-index overflow-auto" style="padding:0% 0%;background:rgba(66, 134, 245, 1);">
    <div class="one_order ">
        <div class="swipe"></div>
        <div class="buttons d-flex flex-wrap justify-content-center w-100" style="max-width:700px">
            <div class="d-flex justify-content-between w-50 min min-width-300">
                <a class=""><button class="btn-primary btn new_btn">+</button></a>
                <a class="" href="/order/test?sorting[status]=''"><button class="btn-primary btn new_btn choosen_btn ">New</button></a>
                <a class="" href="/order/test?sorting[status]=progress"><button class="btn-primary btn new_btn ">On Progress</button></a>
                <a class="" href="/order/test?sorting[status]=completed"><button class="btn-primary btn new_btn">Finish</button></a>
            </div>
            <div class="d-flex justify-content-between w-50 min-width-300">
                <button type="button" class="btn-primary btn new_btn" >
                    <a href="/order/test?<?= @parse_url($_SERVER['REQUEST_URI'])['query'].'&' ?? '?'; ?>sorting[s_t][0]=YT">
                        <img src="<?= '/img/Youtube.png' ?>">
                    </a>
                </button>
                <button type="button" class="btn-primary btn new_btn" >
                    <a href="/order/test?<?= @parse_url($_SERVER['REQUEST_URI'])['query'].'&' ?? '?'; ?>sorting[s_t][0]=TW">
                        <img src="<?= '/img/Twitter.png' ?>">
                    </a>
                </button>
                <button type="button" class="btn-primary btn new_btn" >
                    <a href="/order/test?<?= @parse_url($_SERVER['REQUEST_URI'])['query'].'&' ?? '?'; ?>sorting[s_t][0]=TT">
                        <img src="<?= '/img/Tiktok.png' ?>">
                    </a>
                </button>
                <button type="button" class="btn-primary btn new_btn" >
                    <a href="/order/test?<?= @parse_url($_SERVER['REQUEST_URI'])['query'].'&' ?? '?'; ?>sorting[s_t][0]=TG">
                        <img src="<?= '/img/Telegram.png' ?>">
                    </a>
                </button>
                <button type="button" class="btn-primary btn new_btn" >
                    <a href="/order/test?<?= @parse_url($_SERVER['REQUEST_URI'])['query'].'&' ?? '?'; ?>sorting[s_t][0]=FB">
                        <img src="<?= '/img/Facebook.png' ?>" >
                    </a>
                </button>
                <button type="button" class="btn-primary btn new_btn" >
                    <a href="/order/test?<?= @parse_url($_SERVER['REQUEST_URI'])['query'].'&' ?? '?'; ?>sorting[s_t][0]=IG">
                        <img src="<?= '/img/Instagram-blue.png' ?>" >
                    </a>
                </button>
            </div>
        </div>
        <div class="d-flex flex-wrap orders_list">
            <?php if(isset($query) && !empty($query)){ ?>
                <?php foreach ($query as $index => $item) {?>
                    <?php $price = (Services::getPrice($item['service_id']))/1000 ?>
                    <?php $balance = Services::getBalance($item['service_id']) ?>
                    <?php switch (trim($item['social_type'])){
                        case 'TT';
                            $img = "<img src='/img/Tiktok.png'>";
                            break;
                        case 'YT';
                            $img = "<img src='/img/Youtube.png'>";
                            break;
                        case 'IG';
                            $img = "<img src='/img/Instagram-blue.png'>";
                            break;
                        case 'TG';
                            $img = "<img src='/img/Telegram.png'>";
                            break;
                        case 'FB';
                            $img = "<img src='/img/Facebook.png'>";
                            break;
                        default;
                            $img = "<img src='/img/Facebook.png'>";
                     } ?>

                    <?php
                    $description = trim($item['description']); // Trim the description value

                    $validDescriptions = [
                        'გამომწერი პროფილზე' => 'PROFILE FOLLOWERS',
//                        'ლაიქი პოსტზე' => 'POST LIKES',
//                        'A] TT 1000 ლაიქი' => 'LIKES',
                        'ლაიქი' => 'LIKES',
                        'ნახვა' => 'VIEWS',
                        'REEL ნახვა' => 'REELS VIEWS',
                        'STORIES ნახვა' => 'STORIES VIEWS',
                        'სოციალური რეპოსტი' => 'SOCITAL SHARES',
                        'რეპოსტი' => 'SHARES',
                        'პრემიუმ გამომწერი' => 'PREMIUM FOLLOWERS',
                    ];

                    $desc = $description; // Default to the original description

                    foreach ($validDescriptions as $key => $value) {
                        if (strpos($description, $key) !== false) {
                            // If the description includes the key, use the corresponding value
                            $desc = $value;
                            break; // Exit the loop as soon as a match is found
                        }else {
                            // The description is not in the list, use the original description
                            $desc = $description;
                        }
                    }

                    ?>
            <div class=" m-1 p-3 parent border border-secondary rounded m-t-10">
                <?= $item['id'] ?>
                <?= $item['created_at'] ?>
                <?= $item['service_id'] ?>
                <?= $item['counts_checked'] ?>
                <div class="input-group-text d-flex justify-content-between m-t-10">
                    <div class="d-flex">
                        <div class="border-right">
                            <img class="copy_data" data-data="<?= $item['customer_email'] ?>" title="<?= $item['customer_email'] ?>" src="<?= '/img/Email.png' ?>">
                        </div>
                        <div class="p-left-8"><span class="u_name"><?=  mb_substr($item['customer_name'], 0, 20)  ?></span></div>
                    </div>
                    <div>
                        <img src="<?= '/img/Phone.png' ?>" class="copy_data" data-data="<?= $item['customer_mobile'] ?>" title="<?= $item['customer_mobile'] ?>">
                    </div>
                </div>

                <div class="input-group-text d-flex justify-content-between m-t-10 order_description">
                    <div class="d-flex">
                        <div class="border-right">
                            <?= $img ?>
                        </div>
                        <div class="p-left-8"><span class="u_name"><?= $desc.' '.$item['quantity'] ?></span></div>
                    </div>
                    <div></div>
                </div>

                <div class="input-group-text d-flex justify-content-between m-t-10 overflow-hidden">
                    <div class="d-flex">
                        <div class="border-right">
                            <img class="comment-unread" data-id="<?= $item['id'] ?>" src="<?= '/img/Comment Unread.png' ?>">
                        </div>
                        <div class="p-left-8"><span class=""><?= mb_substr($item['customer_comment'], 0, 15).'...'; ?></span></div>
                    </div>
                    <div></div>
                </div>
                <div class="d-flex justify-content-between m-t-10 before_start">
                    <div class="d-flex">
                        <div class="d-flex">
                            <div class="paperclip d-flex justify-content-center">
                                <img src="/img/Link.png" class="copy_data" data-data="<?= $item['link'] ?>" title="<?= $item['link'] ?>">
                            </div>
                        </div>
                        <div class="d-flex ml-1">
                            <div class="paperclip d-flex justify-content-center"><img src="/img/Chat.png"></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="u_price pr-1"><?=  (@$price * @($item['quantity'])/1000)   ?> $ </span>
                        <div class=" <?= (!!$item['status_paid']) ? "confirmed" : 'unconfirmed'; ?>" data-id="<?= $item['id'] ?>" >
                            <img src="<?= (!!$item['status_paid']) ? "/img/Group 241.png" : '/img/Payment is not Confirmed.png'; ?>">
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between u_footer m-t-10">
                    <button class="w-75 <?= (!!$item['status_paid']) ? 'choosen_btn start' : 'disabled'; ?>" data-checked="<?= $item['counts_checked'] ?>">Start</button>
                    <button class="delete-provider-order"  style="padding:0px;"  data-id=<?= $item['id'] ?>><img src="<?= '/img/Group 225.png' ?>"></button>
                </div>

                <div class="d-flex justify-content-between m-t-10">
                    <form action="<?= Yii::$app->urlManager->createUrl(['order/send-order']) ?>" method="post" class="d-none form_<?= $item['id'] ?>" >
                        <input type="hidden" name="main_link" value="<?= $item['link'] ?>">
                        <input type="hidden" name="prov_order_id" value="<?= $item['id'] ?>">
                        <!--                        likes rellse-->
                        <?php if (!str_contains($desc,'FOLLOW')){ ?>
                            <div class="balance_counter">
                                <div class="d-flex justify-content-between align-items-center multyple_forms ">
                                    <div class="w-45">
                                        <input type="hidden" value="<?= $item['id'] ?>" name="prov_order_id">
                                        <label>Provider $ Service ID</label>
                                        <select class="form-control autolikes_service" name="service">
                                            <option>SELECT SERVICE</option>
                                            <?php foreach ($services as $key => $value) { ?>
                                                <option value="<?= $value['id'] ?>" <?= $item['service_id'] == $value['id'] ? 'selected' : ''; ?>><?= parse_url($value['name'])['host'].' '.$value['def_boost_service'].' '.$value['service_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="w-25">
                                        <label>Overflow</label>
                                        <select class="form-control">
                                            <option>1%</option>
                                            <option selected>5%</option>
                                            <option>10%</option>
                                            <option>15%</option>
                                            <option>20%</option>
                                            <option>25%</option>
                                            <option>30%</option>
                                        </select>
                                    </div>
                                    <div class="w-25">
                                        <label>Quantity</label>
                                        <input type="number" value="<?= intval($item['quantity']*1.05) ?>" class="form-control main_quantity">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center m-t-10">
                                    <span class="prov_balance">Balance: <?= @$balance ?></span>
                                    <span class="prov_price" data-value="<?= @$price * @$item['quantity'] ?>"  <?= ((@$price * @$item['quantity']) > @$balance) ? 'style=color:red' : ''; ?>>Charge: $<?=  @$price * @$item['quantity']  ?></span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center m-t-30 multyple_forms">
                                <div class="w-60">
                                    <label>The principle of distribution</label>
                                    <select class="form-control">
                                        <option>Evenly Last Posts (Default)</option>
                                    </select>
                                </div>
                                <div class="w-35">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" value="10" readonly>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center m-t-30 multyple_forms counts_views">
                                <div class="w-75">
                                    <label class="d-block form-control long_text"><?= $item['link'] ?></label>
                                    <input type="hidden" name="link[]" value="<?= $item['link'] ?>">
                                </div>
                                <div class="w-20">
                                    <label  class="d-block form-control count_xx" ><?= $item['quantity'] ?></label>
                                    <input type="hidden" name="quantity[]" value="<?= $item['quantity'] ?>">
                                </div>
                                <div class="d-flex align-items-center">
                                    <span style="margin:0px 0 15px 5px ; font-size:20px;" class="remove-line">x</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start align-items-center m-t-30 functional-buttons">
                                <div class="w-20">
                                    <button class="add_link" data-id="<?= $item['id'] ?>" type="button">+</button>
                                </div>
                                <div class="w-20">
                                    <button type="button" class="d-flex align-items-center justify-content-center"><img src="<?= '/img/list.png' ?>"></button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between u_footer m-t-10">
                                <div class="d-flex">
                                    <div class="paperclip d-flex justify-content-center" style="background:#4884f4;">
                                        <img src="/img/link-01.png" class="copy_data" data-data="<?= $item['link'] ?>" title="<?= $item['link'] ?>" >
                                    </div>
                                </div>
                                <div class="d-flex ml-1">
                                    <div class="paperclip d-flex justify-content-center"><img src="/img/Chat.png"></div>
                                </div>
                                <div class="d-flex ml-1">
                                    <div class="paperclip d-flex justify-content-center paperclip_confirm"><img src="/img/Divide.png"></div>
                                </div>
                                <button type="submit" class="w-75 "  disabled>Execute</button>
                            </div>
                        <?php }
                        /** likes end */
                        //active follows begin
                        else if(str_contains($desc,'ACTIVE FOLLOWERS')) { ?>
                            <div class="balance_counter">
                                <div class="d-flex justify-content-between align-items-center multyple_forms">
                                    <div class="w-45">
                                        <input type="hidden" value="<?= $item['id'] ?>" name="prov_order_id">
                                        <label>Followers $ Service ID</label>
                                        <select class="form-control autolikes_service" name="service">
                                            <option>SELECT SERVICE</option>
                                            <?php foreach ($services as $key => $value) { ?>
                                                <option value="<?= $value['id'] ?>" <?= $item['service_id'] == $value['id'] ? 'selected' : ''; ?>><?= parse_url($value['name'])['host'].' '.$value['def_boost_service'].' '.$value['service_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="w-25">
                                        <label>Overflow</label>
                                        <select class="form-control">
                                            <option>1%</option>
                                            <option selected>5%</option>
                                            <option>10%</option>
                                            <option>15%</option>
                                            <option>20%</option>
                                            <option>25%</option>
                                            <option>30%</option>
                                        </select>
                                    </div>
                                    <div class="w-25">
                                        <label>Quantity</label>
                                        <input type="number" value="<?= intval($item['quantity']*1.05) ?>" class="form-control main_quantity">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center m-t-10">
                                    <span class="prov_balance service_balance">Balance: <?= @$balance ?></span>
                                    <span class="prov_price"  <?= (((@$price * @$item['quantity']) > @$balance) || !$balance) ? 'style=color:red' : ''; ?>>Charge: $<?=  @$price * @$item['quantity']  ?></span>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-between align-items-start multyple_forms balance_counter border w-100 p-2 m-t-30 mini_order">
                                <div class="d-flex justify-content-start  align-items-center m-t-10"">
                                    <div class="d-flex justify-content-between">
                                        <input type="checkbox" class="auto_checkbox" name="auto_likes" checked>
                                        <label style="margin:0 ;margin-left:5px; font-size:15px" >AutoLikes</label>
                                    </div>
                                </div>
                                <div class="d-flex   justify-content-between align-items-end m-t-10">
                                    <div class="d-flex flex-column justify-content-start align-items-start min-width-150 max-width-150">
                                        <label style="margin:0 ; ">AutoLikes Service ID</label>
                                        <select class="form-control autolikes_service" name="autolike[service_id]">
                                            <option>SELECT SERVICE</option>
                                            <?php foreach ($services as $key => $value) { ?>
                                                <option value="<?= $value['id'] ?>"> <?= $item['service_id'] == $value['id'] ? 'selected' : ''; ?><?= parse_url($value['name'])['host'].' '.$value['def_boost_service'].' '.$value['service_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between min-width-50 max-width-50">
                                        <label style="margin:0">Ratio</label>
                                        <select class="form-control">
                                            <option> 6% </option>
                                        </select>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between min-width-50 max-width-50">
                                        <label style="margin:0">Quantity</label>
                                        <input type="text" class="form-control" value="<?= ($item['quantity']*0.06)*0.8 ?>-<?= ($item['quantity']*0.06)*1.2 ?>" name="like[min-max]" readonly>
                                    </div>
                                </div>
                                <div class="d-flex   justify-content-between align-items-end m-t-10">
                                    <div class="d-flex flex-column justify-content-start align-items-start min-width-150 max-width-150">
                                        <label style="margin:0 ; " class="service_balance">Balance: 0</label>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between min-width-50 max-width-50">
                                        <label style="margin:0" class="service_price" data-value="0" >Cost: 0</label>
                                    </div>
                                </div>
                            </div>
<!--                            second autoview-->
                            <div class="d-flex flex-column justify-content-between align-items-start multyple_forms balance_counter border w-100 p-2 m-t-30 opacity-05 mini_order">
                                <div class="d-flex justify-content-start  align-items-center m-t-10"">
                                    <div class="d-flex justify-content-between">
                                        <input type="checkbox" class="auto_checkbox" name="auto_views" disabled >
                                        <label style="margin:0 ;margin-left:5px; font-size:15px" >AutoViews</label>
                                    </div>
                                </div>
                                <div class="d-flex   justify-content-between align-items-end m-t-10">
                                    <div class="d-flex flex-column justify-content-start align-items-start min-width-150 max-width-150">
                                        <label style="margin:0 ; ">AutoLikes Service ID</label>
                                        <select class="form-control autolikes_service" name="autoView[service_id]">
                                            <option>SELECT SERVICE</option>
                                            <?php foreach ($services as $key => $value) { ?>
                                                <option value="<?= $value['id'] ?>"> <?= $item['service_id'] == $value['id'] ? 'selected' : ''; ?><?= parse_url($value['name'])['host'].' '.$value['def_boost_service'].' '.$value['service_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between min-width-50 max-width-50">
                                        <label style="margin:0">Ratio</label>
                                        <select class="form-control">
                                            <option> 18% </option>
                                        </select>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between min-width-50 max-width-50">
                                        <label style="margin:0">Quantity</label>
                                        <input type="text" class="form-control" value="<?= ($item['quantity']*0.18)*0.8 ?>-<?= ($item['quantity']*0.18)*1.2 ?>"  name="view[min-max]" readonly>
                                    </div>
                                </div>
<!--                                second autoview end-->
                                <div class="d-flex   justify-content-between align-items-end m-t-10">
                                    <div class="d-flex flex-column justify-content-start align-items-start min-width-150 max-width-150">
                                        <label style="margin:0 ; " class="service_balance">Balance: 0</label>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between min-width-50 max-width-50">
                                        <label style="margin:0" class="service_price" data-value="0" >Cost: 0</label>
                                    </div>
                                </div>
                            </div>
<!--                            COMMENT-->
                            <div class="d-flex  justify-content-between align-items-start multyple_forms ">
                                <div class="d-flex justify-content-between flex-column w-75 border p-2 m-t-30 min-width-250">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex justify-content-start  flex-column align-items-center m-t-10"">
                                            <label for="">Existing</label>
                                           <input type="text" class="form-control" value="10" name="existing" >
                                        </div>
                                        <div class="d-flex text-align-center justify-content-end align-items-end  ">
                                            <label class="min-width-100">Post Ratio</label>
                                        </div>
                                        <div class="d-flex justify-content-start  flex-column align-items-center m-t-10"">
                                            <label for="">Future</label>
                                            <input type="text" class="form-control" value="80" name="future" >
                                        </div>
                                    </div>
                                    <div>
                                        <input type="range" class="form-control w-100" min="1" max="100">
                                    </div>
                                </div>
                                 <div class="d-flex flex-column justify-content-center m-t-30 ">
                                    <div class="d-flex flex-column align-items-center ">
                                         <label for="">Posts</label>
                                         <input type="number" class="form-control w-75" value="" >
                                    </div>
                                    <div class="d-flex flex-column align-items-center ">
                                         <label for="">Days</label>
                                         <input type="number" class="form-control w-75" name="days" value="">
                                    </div>
                                </div>
                            </div>
<!--                            COMMENT-->
                            <div class="d-flex align-items-center justify-content-between u_footer m-t-10">
                                <div class="d-flex">
                                    <div class="paperclip d-flex justify-content-center" style="background:#4884f4;">
                                        <img src="/img/link-01.png" class="copy_data" data-data="<?= $item['link'] ?>" title="<?= $item['link'] ?>" >
                                    </div>
                                </div>
                                <div class="d-flex ml-1">
                                    <div class="paperclip d-flex justify-content-center"><img src="/img/Chat.png"></div>
                                </div>
                                <div class="d-flex ml-1">
                                    <div class="paperclip d-flex justify-content-center paperclip_confirm"><img src="/img/Divide.png"></div>
                                </div>
                                <button type="submit" class="w-75 "  disabled>Execute</button>
                            </div>
<!--                        active follows end-->
<!--                        follows begin-->
                        <?php }
                        else{ ?>
                            <div class="d-flex justify-content-between align-items-center multyple_forms">
                                <div class="w-45">
                                    <input type="hidden" value="<?= $item['id'] ?>" name="prov_order_id">
                                    <label>Provider $ Service ID</label>
                                    <select class="form-control autolikes_service" name="service">
                                        <option>SELECT SERVICE</option>
                                        <?php foreach ($services as $key => $value) { ?>
                                            <option value="<?= $value['id'] ?>" <?= $item['service_id'] == $value['id'] ? 'selected' : ''; ?>><?= parse_url($value['name'])['host'].' '.$value['def_boost_service'].' '.$value['service_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="w-25">
                                    <label>Overflow</label>
                                    <select class="form-control">
                                        <option>1%</option>
                                        <option selected>5%</option>
                                        <option>10%</option>
                                        <option>15%</option>
                                        <option>20%</option>
                                        <option>25%</option>
                                        <option>30%</option>
                                    </select>
                                </div>
                                <div class="w-25">
                                    <label>Quantity</label>
                                    <input type="number" value="<?= intval($item['quantity']*1.05) ?>" class="form-control main_quantity">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center m-t-10">
                                <span class="prov_balance" >Balance: <?= @$balance ?></span>
                                <span class="prov_price" data-value="<?= @$price * @$item['quantity'] ?>"  <?= (((@$price * @$item['quantity']) > @$balance) || !$balance) ? 'style=color:red' : ''; ?>>Charge: $<?=  @$price * @$item['quantity']  ?></span>
                            </div>


                            <div class="d-flex justify-content-start  align-items-end m-t-10"">
                                <div class="d-flex max-width-100 min-width-100 flex-column justify-content-between">
<!--                                    <label style="margin:0">AutoLikes Service ID</label>-->
<!--                                    <select class="form-control w-50">-->
<!--                                        --><?php //foreach ($services as $key => $value) { ?>
<!--                                            <option value="--><?php //= $value['id'] ?><!--" --><?php //= $item['service_id'] == $value['id'] ? 'selected' : ''; ?><?php //= parse_url($value['name'])['host'].' '.$value['def_boost_service'].' '.$value['service_name'] ?><!--</option>-->
<!--                                        --><?php //} ?>
<!--                                    </select>-->
                                    <label style="margin:0">Drip-feed interval</label>
                                    <select class="form-control">
                                        <option>Every 12 hours</option>
                                    </select>
                                </div>
                                <div class="d-flex max-width-50 min-width-50 flex-column justify-content-between">
<!--                                    <label style="margin:0">Ratio</label>-->
<!--                                    <select class="form-control w-75" >-->
<!--                                        <option> 6% </option>-->
<!--                                    </select>-->
                                    <label class="margin-0">runs</label>
                                    <input type="number" class="form-control" value="10">
                                </div>
                                <div class="d-flex max-width-50 min-width-50 flex-column justify-content-between">
                                    <label style="margin:0">Portion</label>
                                    <input class="form-control" type="number" value="<?= $item['quantity'] ?>">
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between u_footer m-t-10">
                                <div class="d-flex">
                                    <div class="paperclip d-flex justify-content-center" style="background:#4884f4;">
                                        <img src="/img/link-01.png" class="copy_data" data-data="<?= $item['link'] ?>" title="<?= $item['link'] ?>" >
                                    </div>
                                </div>
                                <div class="d-flex ml-1">
                                    <div class="paperclip d-flex justify-content-center"><img src="/img/Chat.png"></div>
                                </div>
                                <div class="d-flex ml-1">
                                    <div class="paperclip d-flex justify-content-center paperclip_confirm"><img src="/img/Divide.png"></div>
                                </div>
                                <button type="submit" class="w-75 "  disabled>Execute</button>
                            </div>
                        <?php } ?>
<!--                        follows end-->
                    </form>

                </div>

            </div>
                <?php } ?>
            <?php } ?>
        </div>
        <?php  $count = round($count/20)     ; ?>
        <nav aria-label="Page navigation example" class="pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="/order/test?paging=<?= $page-1 ?>"  >Previous</a>
                </li>
                <?php for ($i = $page-2;$i < $page + 3; $i++){ ?>
                    <?php if($i > 0 && $i <= $count+1){ ?>
                        <li class="page-item <?= ($page==$i) ? 'active' : 'no' ?>"  ><a class="page-link" href="/order/test?<?= parse_url($_SERVER['REQUEST_URI'])['query'] ?? '' ?>&paging=<?= $i ?>"><?= $i ?></a></li>
                    <?php } ?>
                <?php } ?>
                <li class="page-item">
                    <a class="page-link" <a class="page-link" href="/order/test?paging=<?= $page+1 ?>">Next</a>
                </li>
            </ul>
        </nav>
        <nav aria-label="Page navigation example" class="cursor-pointer page-item view-more-orders " data-page="2">
            <span class="page-link" >View More...</span>
        </nav>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    jQuery.noConflict();
    (function($) {
        $(document).ready(function() {
            var touchStartX = null;
            var touchStartY = null;
            var isSwiping = false;

            $(".calendar_weekdays, .calendar_content").on("touchstart", function(event) {
                // Store the initial touch coordinates
                var touch = event.touches[0];
                touchStartX = touch.clientX;
                touchStartY = touch.clientY;
            });

            $(".calendar_weekdays, .calendar_content").on("touchmove", function(event) {
                if (touchStartX === null || touchStartY === null || isSwiping) {
                    return;
                }

                var touch = event.touches[0];
                var touchEndX = touch.clientX;

                var deltaX = touchEndX - touchStartX;

                if (Math.abs(deltaX) >= 50) {
                    // Detect a swipe threshold (e.g., 50 pixels)
                    isSwiping = true;
                    var animationProperties = {};

                    if (touchEndX < touchStartX) {
                        // Swipe left
                        animationProperties.left = "-=100px";
                    } else {
                        // Swipe right
                        animationProperties.left = "+=100px";
                    }
                    // Animate the elements smoothly over 1 second
                    $('.calendar_weekdays div, .calendar_content div').animate(animationProperties, 200, function() {
                        // Animation complete, reset flags and touch coordinates
                        isSwiping = false;
                        touchStartX = null;
                        touchStartY = null;
                    });
                }
            });

            $(".calendar_weekdays, .calendar_content").on("touchend", function() {
                // Clear the flags and touch coordinates if the user releases the touch
                isSwiping = false;
                touchStartX = null;
                touchStartY = null;
            });


            $("body").on('click','.copy_data',function() {
                let el = $(this);
                let textToCopy = $(this).data('data');
                copy_text(el,textToCopy);
                alert("Text copied!");
            });

            $('body').on('click','.comment-unread', function (el) {
                if($('#commentModal')){
                    $('#commentModal').remove();
                }
                var id = $(this).data('id');
                $.ajax({
                    url: '/provider-orders/get-comment',
                    method: 'get',
                    dataType: 'html',
                    data: { id: id,  },
                    success: function (data) {
                        $('body').append(data);
                        $('body').find('#modal-comment').trigger('click');
                        $('body').find('#modal-comment').remove();
                    }
                });
            })
        })
    })(jQuery);





</script>
    <?php $this->registerJsFile('@web/js/calculator.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]); ?>




