<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Services $model */
/** @var yii\widgets\ActiveForm $form */

//$this->title = 'Update Services: ' . $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<button type="button" class="btn btn-primary" id="modal-update-services" data-toggle="modal" data-target="#updateModal" data-whatever="@getbootstrap">Update Service</button>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Account</h5>
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">

                <h1><?= Html::encode($this->title) ?></h1>

                <div class="services-form">

                    <?php $form = ActiveForm::begin([
                        'action' => ['services/index'],
                    ]); ?>
                    <?php if (@$model->id){ ?>
                        <input type="hidden" value="<?= $model->id ?>" name="id">
                    <?php } ?>

                    <?= $form->field($model, 'service_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>


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

