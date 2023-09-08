<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProviderOrders $model */

$this->title = 'Update Provider Orders: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Provider Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="provider-orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
