<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProviderOrders $model */

$this->title = 'Create Provider Orders';
$this->params['breadcrumbs'][] = ['label' => 'Provider Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
