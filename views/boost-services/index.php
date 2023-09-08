<?php

use app\models\BoostServices;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BoostServicesSearch $searchModel */
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
<div class="boost-services-index overflow-auto" style="padding:4% 3%">
    <h1><?= Html::encode($this->title) ?></h1>
<!--    <p>-->
<!--        <button type="button" class="btn btn-primary" ><a href="services/index">Our Services</a></button>-->
<!--    </p>-->
    <?php $dataProvider->pagination->pageSize = 12; ?>
    <?= GridView::widget([
        'filterModel' => $searchModel,
        'pager' => [
            'options' => ['class' => 'pagination'],
            'firstPageLabel' => 'First', // Customize the "First" page label
            'lastPageLabel' => 'Last', // Customize the "Last" page label
            'maxButtonCount' => 15, // Maximum number of page buttons to be displayed
            'linkContainerOptions' => ['class' => 'page-item'], // Customize the CSS class for the <li> elements
            'linkOptions' => ['class' => 'page-link'], // Customize the CSS class for the <a> elements
            'disabledListItemSubTagOptions' => ['tag' => 'a href="#" class="page-link"'], // Render disabled links as <a> tags
        ],
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered table-hover table-striped'],
        'columns' => [
//            'id',
            'service_id',
            'name',
            'type',
            'rate',
            'min',
            'max',
//            'services_from',
            [
                'attribute' => 'services_from',
                'label' => 'Services From',
                'headerOptions' => ['class' => 'sorting'],
                 'value' => function ($model) { return (parse_url($model->services_from))['host']; },
            ],
        ],
    ]); ?>


</div>
