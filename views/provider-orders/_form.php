<?php

use app\models\Providers;
use app\models\Services;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProviderOrders $model */
/** @var yii\widgets\ActiveForm $form */


$services = Services::find()->select(['id' , 'service_name'])->asArray()->all();
$ServiceItems = [];
//$ServiceItems[''] = 'Select Service';
foreach ($services as $service) {
    $ServiceItems[$service['id']] = $service['service_name'];
}

?>
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Create Sub Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="provider-orders-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'order_id')->textInput() ?>

                    <?= $form->field($model, 'client_id')->textInput() ?>

                    <?= $form->field($model, 'provider_id')->textInput() ?>

                    <?= $form->field($model, 'price')->textInput() ?>

                    <?= $form->field($model, 'service_id[]')->label('Service')->dropDownList(
                        $ServiceItems,
                        ['class' => 'form-control',
                            'prompt' => 'Select Service',
                            'options' => [
                                @$selectedServiceId => ['selected' => true]
                            ],
                            'required' => true
                        ]
                    ) ?>

                    <div class="form-group">
<!--                        --><?php //= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
