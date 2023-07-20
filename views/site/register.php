<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

//$this->title = 'Create Account';
//$this->params['breadcrumbs'][] = $this->title;
?>

<!--<h1>--><?php //= Html::encode($this->title) ?><!--</h1>-->


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true ,'required' => true]) ?>

                <?= $form->field($model, 'last_name')->textInput(['required' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['type' => 'email','required' => true ]) ?>

                <?= $form->field($model, 'password')->passwordInput(['required' => true]) ?>

                <?= $form->field($model, 'password_repeat')->passwordInput(['required' => true]) ?>

                <?= $form->field($model, 'number')->textInput(['type' => 'tel','required' => true])?>

                <div class="form-group field-user-role">
                    <label class="control-label" for="user-role">Role</label>
                    <select class="form-control" name="role">
                        <?php
                        foreach ($rols as $index => $item) { ?>
                            <option  value="<?= $item->id ?>"><?= $item->name ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Create account', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                </div>

    <?php ActiveForm::end(); ?>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<?= \Yii::$app->view->renderFile('@app/views/site/users_list.php', [
    'model' => $model,
    'rols' => $rols,
]); ?>






