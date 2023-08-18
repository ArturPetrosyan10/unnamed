<?php
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

//$this->title = 'Create Account';
//$this->params['breadcrumbs'][] = $this->title;
?>

<!--<h1>--><?php //= Html::encode($this->title) ?><!--</h1>-->

<div class="user-index overflow-auto" style="padding:4% 3%">
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
<!--                    --><?php //var_dump(Yii::$app->user->identity); ?>

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
                                <?php if(Yii::$app->user->identity->u_role_id == 5 || (Yii::$app->user->identity->u_role_id == 1 && $item->id != 5)){ ?>
                                        <option  value="<?= $item->id ?>"><?= $item->name ?></option>
                                <?php } ?>
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
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Create New Account</button>
    <?php //= \Yii::$app->view->renderFile('@app/views/site/users_list.php', [
    //    'model' => $model,
    //    'rols' => $rols,
    //]); ?>
    <?php $dataProvider->pagination->pageSize = 15; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            'last_name',
            'number',
            'u_role_id'=>
                [
                    'label' => 'Role',
                    'format' => 'raw',
                    'value'=>function ($model){
                            return $model->getRole();
                    },
                    'attribute' => 'u_role_id',
                ] ,
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    if ($action === 'update') {
                        return Url::toRoute(['#', 'id' => $model->id]);
                    }
                    if ($action === 'delete') {
                        return Url::toRoute(['#', 'id' => $model->id]);
                    }
                },
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if(Yii::$app->user->identity->u_role_id == 1 && $model->u_role_id != 5){
                            return '<a href="#" class="pl-2 modal_update_user" data-id="'.$model->id.'"><i class="fas fa-pencil-alt "></i></a>';
                        }else if (Yii::$app->user->identity->u_role_id == 5){
                            return '<a href="#" class="pl-2 modal_update_user" data-id="'.$model->id.'"><i class="fas fa-pencil-alt "></i></a>';
                        }
                    },
                    'delete' => function ($url, $model, $key) {
                        return '<a href="#" onclick="deleteUser('.$model->id.')" style="color:#dc3545!important" class=""><i class="fas fa-trash-alt "></i></a>';
                    },

                ],
            ],

        ],
        'pager' => [
            'options' => ['class' => 'pagination'], // Customize the CSS class for the pagination container
            'maxButtonCount' => 10, // Maximum number of page buttons to be displayed
            'linkContainerOptions' => ['class' => 'page-item'], // Customize the CSS class for the <li> elements
            'linkOptions' => ['class' => 'page-link'], // Customize the CSS class for the <a> elements
            'disabledListItemSubTagOptions' => ['tag' => 'a href="#" class="page-link"'], // Render disabled links as <a> tags
        ],
    ]); ?>
</div>




