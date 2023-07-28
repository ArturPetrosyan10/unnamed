<?php
use app\models\User;
use app\models\Providers;
use app\models\ProviderOrders;
use app\models\Services;
$users = User::find()->orderBy('role')->all();
//edit
if($id){
    $model = ProviderOrders::findOne(['id'=>$id]);
    $selectedProviderId = $model->provider_id;
    $selectedServiceId = $model->service_id;
    $k = 1;
}
//create
elseif ($order_id){
    $k = 3;
    $model = new ProviderOrders();
}
$providers = Providers::find()->select(['id' ,'name'])->asArray()->all();
$providerItems = [];
foreach ($providers as $provider) {
    $providerItems[$provider['id']] = $provider['name'];
}

$services = Services::find()->select(['id' , 'service_name'])->asArray()->all();
$ServiceItems = [];
foreach ($services as $service) {
    $ServiceItems[$service['id']] = $service['service_name'];
}

?>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>
<button type="button" class="btn btn-primary" id="modal-update-sub-order" data-toggle="modal" data-target="#updateModal" data-whatever="@getbootstrap">Send Sub Order</button>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Sub Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="order-form">
                        <?php $form = ActiveForm::begin([
                            'action' => ['order/sub-order-main'],
                        ]); ?>
                        <?php if ($model->id){ //update ?>
                            <input type="hidden" value="<?= $model->id ?>" name="id">
                        <?php }elseif ($order_id){ //create?>
                            <input type="hidden" value="<?= $order_id ?>" name="order_id">
                        <?php }?>

                        <?php for ($i = 0;$i < $k; $i++){ ?>
                            <?= $form->field($model, 'provider_id[]')->label('Provider')->dropDownList(
                                $providerItems,
                                ['class' => 'form-control',
                                'options' => [
                                      @$selectedProviderId => ['selected' => true]
                                    ]
                                ]
                            ) ?>
                            <?= $form->field($model, 'service_id[]')->label('Service')->dropDownList(
                                $ServiceItems,
                                ['class' => 'form-control',
                                'options' => [
                                    @$selectedServiceId => ['selected' => true]
                                ]
                                ]
                            ) ?>
                            <?= $form->field($model,'quantity[]' )->textInput() ?>
                        <?php } ?>
                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>

                     <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>

