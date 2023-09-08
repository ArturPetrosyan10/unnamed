<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BoostServices $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="boost-services-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'service_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rate')->textInput() ?>

    <?= $form->field($model, 'min')->textInput() ?>

    <?= $form->field($model, 'max')->textInput() ?>

    <?= $form->field($model, 'dripfeed')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refill')->textInput() ?>

    <?= $form->field($model, 'cancel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'services_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
