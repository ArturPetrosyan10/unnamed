<?php

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#orderModal" data-whatever="@getbootstrap">Create New Order</button>
<!--        --><?php //= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-hover table-striped'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'created_at',
            'payload_link',
            'charge',
//            'customer_name',
            'start_count',
            'quantity',
            'service',
            'status',
            'remains',
//            'description',
//            'customer_id',
//            'updated_at',
//            'transaction_number',
//            'transaction_date',
//            'email:email',
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
                    return Url::toRoute([$action, 'id' => $model->id]);
                     }
//                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Use jQuery.noConflict() to avoid conflicts
    jQuery.noConflict();
    (function($) {
        // Your custom jQuery code here using the '$' sign
        $(document).ready(function() {
            $('body').on('click', '.show-sub-orders', function () {
                var el = $(this).attr("class").split(" ");
                var id = el[1].substring(1);
                var tr = $(this).closest('tr');
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
                                // console.log(data);
                             tr.after(data);
                            }
                        });
                    }
            })
        })
    })(jQuery);
</script>


<?= $this->render('_form', [
    'model' => $model,
]) ?>



