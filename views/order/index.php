<?php

use app\models\Order;
use app\models\ProviderOrders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

//$this->title = 'Orders';
//$this->params['breadcrumbs'][] = $this->title;
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
<div class="order-index overflow-auto" style="padding:4% 3%">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#orderModal" data-whatever="@getbootstrap">Create New Order</button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php $dataProvider->pagination->pageSize = 15; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-hover table-striped'],
        'columns' => [
            'customer_name',
            'currency',
            'customer_mobile',
            [
                'attribute' => 'customer_comment',
                'format' => 'raw',
                'value' => function ($model) {
                    $id = 'comment-' . $model->id;
                    return '<a class="comment-trigger" data-toggle="collapse" href="#' . $id . '">'.mb_substr($model->customer_comment, 0, 10).'...</a>'
                        . '<div id="' . $id . '" class="collapse">' . $model->customer_comment . '</div>';
                },
            ],
            'customer_email',
            'reference',
            'tilla_id',
//            'description',
            'link'=> [
                'header' => '<a href="/order/index?sort=link" data-sort="link" >Link</a>',
                'format' => 'raw',
                'value' => function($model) {
                    return '<a href="'.$model->link.'">'.mb_substr($model->link, 8, 15).'...</a>';
                }
            ],
            'social_type',
            'providers'=> [
                'header' => '<a href="#">Providers</a>',
                'format' => 'raw',
                'value' => function($model) {
                    return '<a href="#" class="show-sub-orders a'.$model->id.'"> Sub Orders  </a>';
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                                    if ($action === 'update') {
                                        return Url::toRoute(['#', 'id' => $model->id]);
                                    }
                                    if ($action === 'view') {
                                        return Url::toRoute(['#', 'id' => $model->id]);
                                    }
                                    else {
                                        return Url::toRoute([$action, 'id' => $model->id]);
                                    }
                                },
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        $url = '#';
//                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class' => 'update-order-modal', 'data-id' => $model->id,]);
                        return '<a class="update-order-modal" data-id="'.$model->id.'" style="cursor:pointer"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>';
                    },
                    'view' => function ($url, $model, $key) {
                        $url = '#';
                        $count = ProviderOrders::find()->where(['order_id' => $model->id])->count();
                        if ($count >= 3){
                            return '<a class="view-order-modal cursor-pointer" data-id="'.$model->id.'" style="cursor:pointer"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        }
                        return '<a class="view-order-modal cursor-pointer" data-id="'.$model->id.'" style="cursor:pointer"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="update-sub-order-modal" data-id="'.$model->id.'" style="padding-left:4px; cursor:pointer"><i class="fa fa-plus"></i></a>';
                    },
                ],
            ],
        ],
        'pager' => [
            'options' => ['class' => 'pagination'], // Customize the CSS class for the pagination container
//            'prevPageLabel' => 'Previous', // Customize the "Previous" page label
//            'nextPageLabel' => 'Next', // Customize the "Next" page label
//            'firstPageLabel' => 'First', // Customize the "First" page label
//            'lastPageLabel' => 'Last', // Customize the "Last" page label
            'maxButtonCount' => 10, // Maximum number of page buttons to be displayed
            'linkContainerOptions' => ['class' => 'page-item'], // Customize the CSS class for the <li> elements
            'linkOptions' => ['class' => 'page-link'], // Customize the CSS class for the <a> elements
            'disabledListItemSubTagOptions' => ['tag' => 'a href="#" class="page-link"'], // Render disabled links as <a> tags
//            'disabledListItemSubTagClass' => 'page-link', // Set the class for disabled links
        ],
    ]); ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    jQuery.noConflict();
    (function($) {
        $(document).ready(function() {
            $('body').on('click', '.show-sub-orders', function () {
                var el = $(this).attr("class").split(" ");
                var id = el[1].substring(1);
                var tr = $(this).closest('tr');
                if ($('table .sub-tr').html()) {
                    $('table .sub-tr').remove();
                }
                if ($('table tr[data-suborder="' + id + '"]').html()){
                    $('table tr[data-suborder="' + id + '"]').remove();
                }else{
                    $.ajax({
                        url: '/order/get-sub-orders',
                        method: 'get',
                        dataType: 'html',
                        data: {
                            id: id,
                        },
                        success: function (data) {
                            tr.after(data);
                        }
                    });
                }
            })

            $('body').on('click', '.comment-trigger', function (e) {
                e.preventDefault();
                var target = $(this).attr('href');
                $(target).collapse('toggle');
            });

        })
    })(jQuery);

</script>



<?= $this->render('_form', [
    'model' => $model,
]) ?>



