<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BoostServicesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="boost-services-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'service_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'rate') ?>

    <?php // echo $form->field($model, 'min') ?>

    <?php // echo $form->field($model, 'max') ?>

    <?php // echo $form->field($model, 'dripfeed') ?>

    <?php // echo $form->field($model, 'refill') ?>

    <?php // echo $form->field($model, 'cancel') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'services_from') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'subscription') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
