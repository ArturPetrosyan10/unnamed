<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Create Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="order-form">
                    <?php $form = ActiveForm::begin(); ?>
                    <input type="hidden" value="<?= $model->id ?>" name="id">

                    <?= $form->field($model,'customer_name' )->textInput() ?>

                    <?= $form->field($model,'currency' )->textInput() ?>

                    <?= $form->field($model,'customer_mobile' )->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model,'customer_comment' )->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model,'reference' )->textInput() ?>

                    <?= $form->field($model,'description' )->textInput() ?>

                    <?= $form->field($model,'link' )->textInput() ?>

                    <?= $form->field($model, 'social_type')->dropDownList([
                        'IG' => 'Instagram (IG)',
                        'TT' => 'TikTok (TT)',
                        'FB' => 'Facebook (FB)',
                        'YT' => 'YouTube (YT)',
                        'TG' => 'Telegram (TG)',
                        'TW' => 'Twitter (TW)',
                    ], ['prompt' => 'Select Social Type']) ?>


                    <!--                    --><?php //= $form->field($model,'amount' )->textInput(['type' => 'email','required' => true ]) ?>


                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
