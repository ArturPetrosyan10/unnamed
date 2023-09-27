<?php

use app\models\Status;
use app\models\User;
use app\models\Providers;
use app\models\ProviderOrders;
use app\models\Services;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$users = User::find()->orderBy('role')->all();
//edit
if(@$id){
    $model = ProviderOrders::findOne(['id'=>$id]);
    $selectedProviderId = $model->provider_id;
    $selectedServiceId = $model->service_id;
}
//create
elseif (@$order_id){
    $model = new ProviderOrders();
}
$providers = Providers::find()->select(['id' ,'name'])->asArray()->all();
$providerItems = [];
//$providerItems[''] = 'Select Provider';
foreach ($providers as $provider) {
    $provider['name'] = parse_url($provider['name']);
    $providerItems[$provider['id']] = $provider['name']['host'];
}

$services = Services::find()->select(['id' , 'service_name'])->asArray()->all();
$ServiceItems = [];
foreach ($services as $service) {
    $ServiceItems[$service['id']] = $service['service_name'];
}

$status = Status::find()->where(['prov_order_id' => $model->id])->one();
?>
<?php

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>
<button type="button" class="btn btn-primary" id="modal-update-sub-order" data-toggle="modal" data-target="#updateModal" data-whatever="@getbootstrap">Send Sub Order</button>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Send Sub Order</h5>
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
                        <?= /*$form->field($model, 'provider_id[]')->label('Provider')->dropDownList(
                            $providerItems,
                            ['class' => 'form-control',
                                'prompt' => 'Select Provider',
                                'options' => [
                                      @$selectedProviderId => ['selected' => true]
                                ],
                                'required' => true
                            ]
                        ) */'' ?>
                        <?= $form->field($model, 'service_id[]')->label('Service')->dropDownList(
                            $ServiceItems,
                            [
                                'class' => 'form-control',
                                'prompt' => 'Select Service',
                                'options' => [
                                    @$selectedServiceId => ['selected' => true]
                                ],
                                'required' => true
                            ]
                        ) ?>
                        <?php if ($id){ ?>
                            <?= $form->field($model,'quantity[]' )->textInput(['value' => ceil($model->quantity)]) ?>
                        <?php } else{ ?>
                            <?= $form->field($model,'quantity[]' )->textInput() ?>
                        <?php } ?>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        <?php if(!@$status->id){ ?>
                            <?= Html::submitButton('Send Order', ['class' => 'btn btn-dark', 'name'=>'to_order' ]) ?>
                        <?php } ?>
                        <?php if(@$status->id){ ?>
                            <?= Html::submitButton('Refill', ['class' => 'btn btn-secondary', 'name'=>'to_refill' ]) ?>
                        <?php } ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>

