<?php

use app\models\Providers;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Services $model */
/** @var yii\widgets\ActiveForm $form */

$providers = Providers::find()->all();
?>
<div class="modal fade" id="serviceModal"  role="dialog" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Create Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="services-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'service_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<!--                    --><?php //= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <label>Default Provider</label>
                        <select class="def-provider select2-select  form-control input-group input-group-sm" name="Services[def_provider]" style="width: 100%; ">
                            <option>select Default provider</option>
                            <?php foreach ($providers as $index => $provider) { ?>
                                <option value="<?= $provider->id ?>"><?=$provider->name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group soctial_types_group" style="display:none">
                        <label>Select Soctial Type</label>
                        <select class="social_types form-control">
                            <option></option>
                            <option value="Youtube">Youtube</option>
                            <option value="Tiktok">Tiktok</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Instagram">Instagram</option>
                        </select>
                    </div>
                    <div class="form-group def-providers">

                    </div>
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