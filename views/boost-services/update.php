<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BoostServices $model */

$this->title = 'Update Boost Services: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Boost Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="boost-services-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
