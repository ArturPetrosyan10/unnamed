<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\BoostServices $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Boost Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="boost-services-view">

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
            'service_id',
            'name',
            'type',
            'rate',
            'min',
            'max',
            'dripfeed',
            'refill',
            'cancel',
            'category',
            'services_from',
            'created_date',
            'description:ntext',
            'subscription',
        ],
    ]) ?>

</div>
