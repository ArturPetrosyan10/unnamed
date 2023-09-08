<?php

use app\models\ProviderOrders;
use app\models\Services;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProviderOrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>
<style>
    .pagination .page-item.disabled .page-link {
        pointer-events: none; /* Disable click events on disabled links */
        cursor: default; /* Show default cursor on disabled links */
        color: #868e96; /* Set text color for disabled links */
    }
    table tr td:last-child,th:last-child {
        border: 1px solid #dee2e6;
        min-width: 100px;
        padding: 0.5rem 0.5rem !important;
    }

</style>
<div class="provider-orders-index overflow-auto" style="padding:4% 3%">
    <?php $dataProvider->pagination->pageSize = 12; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered table-hover table-striped'],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'order_id',
//            'user_id',
//            'client_id',
//            'charge',
            //'provider_id',
            //'service_id',
            //'price',
            [
            'attribute' => 'service_id',
                'label' => 'Service',
                'headerOptions' => ['class' => 'sorting'],
                'contentOptions' => [],
                'footerOptions' => [],
                 'value' =>
                 function ($model) {
                    $service = Services::findOne($model->service_id);
                    return @$service->service_name;

                 },
            ],
            'quantity',
            'created_at',
            'status',
            //'updated_at',
            //'status',
            //'remains',
            //'start_count',
            'customer_mobile',
            'customer_comment:ntext',
            'description:ntext',
            'link',
        ],
        'pager' => [
            'options' => ['class' => 'pagination'],
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'maxButtonCount' => 15,
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'a href="#" class="page-link"'],

        ],
    ]); ?>
</div>

