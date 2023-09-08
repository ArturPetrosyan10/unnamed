<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BoostServices $model */

$this->title = 'Create Boost Services';
$this->params['breadcrumbs'][] = ['label' => 'Boost Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boost-services-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
