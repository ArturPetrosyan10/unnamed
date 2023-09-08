<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ProviderOrders $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Provider Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="provider-orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'order_id',
            'user_id',
            'client_id',
            'charge',
            'provider_id',
            'service_id',
            'price',
            'transaction_date',
            'quantity',
            'created_at',
            'updated_at',
            'status',
            'remains',
            'start_count',
            'customer_mobile',
            'customer_comment:ntext',
            'description:ntext',
            'link',
        ],
    ]) ?>

</div>
